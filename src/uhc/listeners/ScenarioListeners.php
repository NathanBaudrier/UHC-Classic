<?php

namespace uhc\listeners;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\GoldOre;
use pocketmine\block\IronOre;
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
use Random\RandomException;
use uhc\game\Game;
use uhc\listeners\custom\UPlayerDeathEvent;

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
            }
        }
    }

    public function onDeath(UPlayerDeathEvent $event) : void {
        $player = $event->getPlayer();
        $killer = $event->getKiller();
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted()) {
            if($killer !== null) {
                if($scenarios->getById($scenarios::NO_CLEAN_UP_ID)->isEnabled()) {
                    $killer->setHealth($killer->getHealth() / 2);
                }
            }
        }
    }

    public function onShoot(EntityShootBowEvent $event) : void {
        $player = $event->getEntity();
        $event->
        $scenarios = $this->game->getScenarios();

        if($this->game->hasStarted()) {
            switch (true) {
                case $scenarios->getById($scenarios::BOW_SEED_ID)->isEnabled():
                    //To test
                    break;
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
}