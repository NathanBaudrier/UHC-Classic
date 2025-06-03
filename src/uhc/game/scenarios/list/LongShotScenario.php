<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\UPlayer;

class LongShotScenario extends Scenario {

    public function getId() : int {
        return self::LONG_SHOT_ID;
    }

    public function getName() : string {
        return "Long Shot";
    }

    public function getDescription() : string {
        return "Long Shot";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof EntityShootBowEvent) return;

        $shooter = $event->getProjectile()->getOwningEntity();
        $target = $event->getEntity();

        if(!$shooter instanceof UPlayer || !$target instanceof UPlayer) return;

        if($shooter->getPosition()->distance($target->getPosition()->asVector3()) > 75) {
            $shooter->setHealth($shooter->getHealth() + 1);
            $event->setForce($event->getForce() * 1.5);
        }
    }
}