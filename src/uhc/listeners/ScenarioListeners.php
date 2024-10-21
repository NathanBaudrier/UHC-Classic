<?php

namespace uhc\listeners;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\CoalOre;
use pocketmine\block\DiamondOre;
use pocketmine\block\EmeraldOre;
use pocketmine\block\GoldOre;
use pocketmine\block\IronOre;
use pocketmine\block\LapisOre;
use pocketmine\block\RedstoneOre;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemEnchantEvent;
use pocketmine\item\Axe;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Hoe;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;
use pocketmine\item\VanillaItems;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Random\RandomException;
use uhc\game\Game;
use uhc\listeners\custom\NewDamageCycleEvent;
use uhc\listeners\custom\UPlayerDeathEvent;
use uhc\UPlayer;
use uhc\utils\scenarios\DamageCycle;

class ScenarioListeners implements Listener {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onCraft(CraftItemEvent $event) : void {
        if($this->game->hasStarted()) {

            $scenarios = $this->game->getScenarios();

            switch (true) {
                case $scenarios->getById($scenarios::HASTEY_BOYS_ID)->isEnabled():
                    foreach($event->getOutputs() as $item) {
                        if($item instanceof Axe
                            || $item instanceof Pickaxe
                            || $item instanceof Hoe
                            || $item instanceof Shovel) {
                            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 3));
                        }
                    }
            }
        }
    }

    /**
     * @throws RandomException
     */
    public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($this->game->hasStarted()) {

            $scenarios = $this->game->getScenarios();

            switch (true) {
                case $scenarios->getById($scenarios::VANILLA_PLUS_ID)->isEnabled():
                    $random = random_int(0, 100);

                    if($block->getTypeId() == BlockTypeIds::OAK_LEAVES || $block->getTypeId() == BlockTypeIds::DARK_OAK_LEAVES) {
                        if($random <= 20) $event->setDrops([VanillaItems::APPLE()]);
                    } else if($block->getTypeId() == BlockTypeIds::GRAVEL) {
                        if($random <= 20) $event->setDrops([VanillaItems::FLINT()]);
                    }

                case $scenarios->getById($scenarios::TIMBER_ID):
                    break;

                case $scenarios->getById($scenarios::CUT_CLEAN_ID)->isEnabled():
                    if($block instanceof IronOre) {
                        $event->setDrops([VanillaItems::IRON_INGOT()]);
                        $event->setXpDropAmount(rand(1, 4));
                    } else if($block instanceof GoldOre) {
                        $event->setDrops([VanillaItems::GOLD_INGOT()]);
                        $event->setXpDropAmount(rand(2, 6));
                    }

                    //Minecraft Wiki information :
                    //Diamond ore xp drop : rand(3, 7)
                    //Coal ore xp drop : rand(0, 2)
                    //Redstone ore xp drop : rand(1, 5)
                    //Lapis Lazuli or xp drop : rand(2, 5)

                case $scenarios->getById($scenarios::DOUBLE_OR_NOTHING_ID)->isEnabled():
                    if($block instanceof CoalOre
                        || $block instanceof IronOre
                        || $block instanceof GoldOre
                        || $block instanceof RedstoneOre
                        || $block instanceof LapisOre
                        || $block instanceof DiamondOre
                        || $block instanceof EmeraldOre
                    ) {
                        rand(0, 1) ? $event->setDrops(array_map(function ($item) { return $item->setCount($item->getCount() * 2); }, $event->getDrops())) : $event->setDrops([]);
                    }

                case $scenarios->getById($scenarios::BLOOD_DIAMOND_ID)->isEnabled():
                    if($block instanceof DiamondOre) $player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, 0.5));
            }
        }
    }

    public function onDeath(UPlayerDeathEvent $event) : void {
        $player = $event->getPlayer();
        $killer = $event->getKiller();
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted()) {
            switch (true) {
                case $scenarios->getById($scenarios::NO_CLEAN_UP_ID)->isEnabled():
                    $killer?->setHealth($killer->getHealth() / 2);

                case $scenarios->getById($scenarios::FAST_GATEWAY_ID)->isEnabled():
                    $killer?->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 60*20, 0, false));
            }
        }
    }

    public function onShoot(EntityShootBowEvent $event) : void {
        $player = $event->getEntity();
        $target = $event->getProjectile()->getOwningEntity();
        $scenarios = $this->game->getScenarios();

        if($player instanceof UPlayer && $target instanceof UPlayer) {
            if($this->game->hasStarted()) {
                switch (true) {
                    case $scenarios->getById($scenarios::BOW_SEED_ID)->isEnabled():
                        $player->sendMessage(TextFormat::GREEN . $target->getName() . " a " . $target->getHealth() . "pv.");
                        //To test

                    case $scenarios->getById($scenarios::LONG_SHOT_ID)->isEnabled():
                        if($player->getPosition()->distance($target->getPosition()->asVector3()) > 75) {
                            $player->setHealth($player->getHealth() + 1);
                            $event->setForce($event->getForce() * 1.5);
                        }
                }
            }
        }
    }

    public function onEnchant(PlayerItemEnchantEvent $event) : void {
        $player = $event->getPlayer();
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted()) {

            if($scenarios->getById($scenarios::BLOOD_ENCHANT_ID)->isEnabled()) {
                $player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, 0.5));
            }
        }
    }

    public function onDamage(EntityDamageEvent $event) : void {
        $player = $event->getEntity();
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted() && $player instanceof UPlayer) {
            if($event->getFinalDamage() < $player->getHealth()) {
                switch (true) {
                    case $scenarios->getById($scenarios::DAMAGE_CYCLE_ID)->isEnabled():
                        if($event->getCause() == $this->game->getDamageCycle()->getCause()) $player->kill();
                        break;

                    case $scenarios->getById($scenarios::CRIPPLE_ID)->isEnabled():
                        if($event->getCause() == EntityDamageEvent::CAUSE_FALL) {
                            $player->getEffects()->add(new EffectInstance(VanillaEffects::SLOWNESS(), 20*90, 0, false));
                        }
                }
            }
        }
    }

    public function onDamageCycle(NewDamageCycleEvent $event) : void {
        $game = $this->game;

        $game->setDamageCycle(DamageCycle::generateNew());
        Server::getInstance()->broadcastMessage(
            TextFormat::WHITE . "[" . TextFormat::YELLOW . "DamageCycle" . TextFormat::WHITE . "] " . TextFormat::BOLD . $game->getDamageCycle()->getName() . "\n" .
            $game->getDamageCycle()->getDescription()
        );

        if($event->getLastCycle() != null) {
            Server::getInstance()->broadcastMessage("(" . $game->getDamageCycle()->getDeaths() . " joueurs sont mort à cause du cycle précédent.)");
        }
    }
}