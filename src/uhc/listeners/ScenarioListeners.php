<?php

namespace uhc\listeners;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\CoalOre;
use pocketmine\block\DiamondOre;
use pocketmine\block\Door;
use pocketmine\block\EmeraldOre;
use pocketmine\block\GoldOre;
use pocketmine\block\IronOre;
use pocketmine\block\LapisOre;
use pocketmine\block\RedstoneOre;
use pocketmine\block\VanillaBlocks;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerItemEnchantEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Axe;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\GoldenApple;
use pocketmine\item\Hoe;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;
use pocketmine\item\VanillaItems;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use uhc\game\Game;
use uhc\game\scenarios\DamageCycle;
use uhc\listeners\custom\NewDamageCycleEvent;
use uhc\listeners\custom\UPlayerDeathEvent;
use uhc\Main;
use uhc\UPlayer;

class ScenarioListeners implements Listener {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onCraft(CraftItemEvent $event) : void {
        $player = $event->getPlayer();

        if($this->game->hasStarted()) {

            $scenarios = $this->game->getScenarios();

            /*
            switch (true) {
                case $scenarios->getById($scenarios::PARANOIA_ID)?->isEnabled():
                    foreach($event->getOutputs() as $item) {
                        if($item instanceof GoldenApple || $item->getTypeId() == BlockTypeIds::ENCHANTING_TABLE || $item->getTypeId() == BlockTypeIds::ANVIL) {
                            $player->getServer()->broadcastMessage($player->getName() . " a confectionné " . $item->getName() . " aux coordonnées : " . $player->getPosition()->getX() . ":" . $player->getPosition()->getY() . ":" . $player->getPosition()->getZ());
                        }
                    }
            }
            */
        }
    }

    public function onHeldItem(PlayerItemHeldEvent $event) : void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $scenarios = $this->game->getScenarios();

        if($scenarios->getById($scenarios::HASTEY_BOYS_ID)?->isEnabled()) {
        }
    }

    public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if($this->game->hasStarted()) {

            $scenarios = $this->game->getScenarios();

            switch (true) {
                case $scenarios->getById($scenarios::VANILLA_PLUS_ID)?->isEnabled():

                case $scenarios->getById($scenarios::TIMBER_ID)?->isEnabled():

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

                case $scenarios->getById($scenarios::PARANOIA_ID)->isEnabled():
                    if($block instanceof GoldOre || $block instanceof DiamondOre) {
                        $player->getServer()->broadcastMessage($player->getName() . " a miné " . $block->getName() . " aux coordonnées : " . $player->getPosition()->getX() . ":" . $player->getPosition()->getY() . ":" . $player->getPosition()->getZ());
                    }

                case $scenarios->getById($scenarios::MONSTER_AND_CIE_ID)->isEnabled():
                    if($block instanceof Door && $this->game->getDoors()->exists($block)) {
                        $this->game->getDoors()->remove($block);
                    }
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

                case $scenarios->getById($scenarios::PARANOIA_ID)->isEnabled():
                    if($killer != null) {
                        $player->getServer()->broadcastMessage($killer->getName() . " a tué " . $player->getName() . " aux coordonnées : " . $killer->getPosition()->getX() . ":" . $killer->getPosition()->getY() . ":" . $killer->getPosition()->getZ());
                    }
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

            if($scenarios->getById($scenarios::BLOOD_ENCHANT_ID)?->isEnabled()) {
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
    }

    public function onPlace(BlockPlaceEvent $event) : void {
        $player = $event->getPlayer();
        $block = $event->getBlockAgainst();
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted()) {
            switch (true) {
                case $scenarios->getById($scenarios::AUTO_BREAK_ID)->isEnabled():
                    Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use ($block) {
                        $block?->getPosition()->getWorld()->setBlock($block->getPosition()->asVector3(), VanillaBlocks::AIR());
                    }), 60*20);
                case $scenarios->getById($scenarios::MONSTER_AND_CIE_ID)->isEnabled():
                    if($block instanceof Door) {
                        $this->game->getDoors()->add($block);
                    }
            }
        }
    }

    public function onConsume(PlayerItemConsumeEvent $event) : void {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if($this->game->hasStarted()) {

            $scenarios = $this->game->getScenarios();

            switch (true) {
                case $scenarios->getById($scenarios::PARANOIA_ID)->isEnabled():
                    if($item instanceof GoldenApple) {
                        $player->getServer()->broadcastMessage($player->getName() . " a mangé " . $item->getName() . " aux coordonnées : " . $player->getPosition()->getX() . ":" . $player->getPosition()->getY() . ":" . $player->getPosition()->getZ());
                    }
            }
        }
    }

    public function onMove(PlayerMoveEvent $event) : void {
        $player = $event->getPlayer();

        //détecter si un joueur passe à travers une porte
        //je ne connais pas la gestion d'une position d'une porte sur le jeu
    }
}