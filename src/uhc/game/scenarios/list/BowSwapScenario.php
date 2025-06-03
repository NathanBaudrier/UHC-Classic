<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\UPlayer;

class BowSwapScenario extends Scenario {

    public function getId() : int {
        return self::BOW_SWAP_ID;
    }

    public function getName() : string {
        return "Bow Swap";
    }

    public function getDescription() : string {
        return "Bow Swap";
    }

    public function onEvent(Event $event) : void{
        if(!$event instanceof EntityShootBowEvent) return;

        $shooter = $event->getProjectile()->getOwningEntity();
        $target = $event->getEntity();

        if(!$shooter instanceof UPlayer || !$target instanceof UPlayer) return;

        $position = $target->getPosition();
        $target->teleport($shooter->getPosition());
        $shooter->teleport($position);
    }
}