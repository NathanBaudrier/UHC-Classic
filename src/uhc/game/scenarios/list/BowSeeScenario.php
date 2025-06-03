<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Event;
use pocketmine\utils\TextFormat;
use uhc\game\scenarios\Scenario;
use uhc\UPlayer;

class BowSeeScenario extends Scenario {

    public function getId() : int {
        return self::BOW_SEED_ID;
    }

    public function getName() : string {
        return "Bow See";
    }

    public function getDescription() : string {
        return "Bow See";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof EntityShootBowEvent) return;

        $shooter = $event->getProjectile()->getOwningEntity();
        $target = $event->getEntity();

        if(!$shooter instanceof UPlayer || !$target instanceof UPlayer) return;

        $shooter->sendMessage(TextFormat::GREEN . $target->getName() . " a " . $target->getHealth() . "pv.");
    }
}