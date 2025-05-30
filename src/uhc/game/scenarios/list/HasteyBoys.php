<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Axe;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Hoe;
use pocketmine\item\Pickaxe;
use pocketmine\item\Shovel;

use uhc\game\scenarios\Scenario;

class HasteyBoys extends Scenario {

    public function getId() : int {
        return self::HASTEY_BOYS_ID;
    }

    public function getName() : string {
        return "Hastey Boys";
    }

    public function getDescription() : string {
        return "";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof PlayerItemHeldEvent) return;

        $player = $event->getPlayer();
        $item = $event->getItem();

        if(
            $item instanceof Axe
            ||
            $item instanceof Pickaxe
            ||
            $item instanceof Hoe
            ||
            $item instanceof Shovel
        ) {
            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 4));
            $player->getInventory()->setItemInHand($item);
        }
    }
}