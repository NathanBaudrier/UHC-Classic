<?php

namespace uhc\listeners;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\item\Axe;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Hoe;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;
use pocketmine\item\VanillaItems;
use Random\RandomException;
use uhc\game\Game;

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
                case $scenarios->getById($scenarios::TIMBER_ID)->isEnabled():
                    if($block->getTypeId() == BlockTypeIds::OAK_LEAVES || $block->getTypeId() == BlockTypeIds::DARK_OAK_LEAVES) {
                        $random = random_int(1, 100);
                        if($random <= 20) $event->setDrops([VanillaItems::APPLE()]);
                    }
            }
        }
    }
}