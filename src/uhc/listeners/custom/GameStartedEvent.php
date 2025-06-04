<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\game\Game;

class GameStartedEvent extends Event {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function getGame() : Game {
        return $this->game;
    }
}