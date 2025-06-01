<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\DiamondOre;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;

class BloodDiamond extends Scenario {

    public function getId() : int {
        return self::BLOOD_DIAMOND_ID;
    }

    public function getName() : string {
        return "Blood Diamond";
    }

    public function getDescription() : string {
        return "Blood Diamond";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;
        if(!$event->getBlock() instanceof DiamondOre) return;

        $player = $event->getPlayer();
        $player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, 1));
    }
}