<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\listeners\custom\UPlayerDeathEvent;

class NoCleanUpScenario extends Scenario {

    public function getId() : int {
        return self::NO_CLEAN_UP_ID;
    }

    public function getName() : string {
        return "No Cleanup";
    }

    public function getDescription() : string {
        return "No Cleanup";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof UPlayerDeathEvent) return;

        $event->getKiller()?->setHealth($event->getKiller()->getMaxHealth() / 2);
    }
}