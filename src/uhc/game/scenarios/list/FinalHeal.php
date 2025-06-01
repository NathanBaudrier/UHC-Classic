<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\listeners\custom\PvpEnabledEvent;
use uhc\Main;

class FinalHeal extends Scenario {

    public function getId() : int {
        return self::FINAL_HEAL_ID;
    }

    public function getName() : string {
        return "Final Heal";
    }

    public function getDescription() : string {
        return "";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof PvpEnabledEvent) return;

        foreach(Main::getInstance()->getGame()->getPlayers() as $player) {
            $player->setHealth($player->getMaxHealth());
        }
    }
}