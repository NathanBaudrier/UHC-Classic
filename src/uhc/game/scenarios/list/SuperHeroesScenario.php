<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\game\scenarios\utils\Power;
use uhc\listeners\custom\GameStartedEvent;

class SuperHeroesScenario extends Scenario {

    public function getId() : int {
        return self::SUPER_HERO_ID;
    }

    public function getName() : string {
        return "Super Heroes";
    }

    public function getDescription() : string {
        return "Super Heroes";
    }

    public function onEvent(Event $event) : void {
        if($event instanceof GameStartedEvent) {
            $game = $event->getGame();

            foreach($game->getPlayers() as $player) {
                $player->setPower(new Power());
                $player->getPower()->apply($player);
            }
        }
    }
}