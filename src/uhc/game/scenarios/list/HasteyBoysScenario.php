<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\inventory\CraftingTableInventory;
use pocketmine\event\Event;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Sword;
use pocketmine\item\TieredTool;
use pocketmine\player\GameMode;

use uhc\game\scenarios\Scenario;

class HasteyBoysScenario extends Scenario {

    public function getId() : int {
        return self::HASTEY_BOYS_ID;
    }

    public function getName() : string {
        return "Hastey Boys";
    }

    public function getDescription() : string {
        return "Hastey Boys";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof CraftItemEvent) return;

        $player = $event->getPlayer();

        if($player->getGamemode() !== GameMode::SURVIVAL) return;

        foreach($event->getOutputs() as $item) {
            if($item instanceof TieredTool && !$item instanceof Sword) {

                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 5));

                if($player->getInventory()->canAddItem($item)) {
                    $player->getInventory()->addItem($item);

                    $event->cancel();

                    foreach($event->getTransaction()->getInventories() as $inventory) {
                        if($inventory instanceof CraftingTableInventory) {
                            $inventory->clearAll();
                        }
                    }

                    break;
                }
            }
        }
    }
}