<?php

namespace uhc\tasks;

use pocketmine\scheduler\Task;
use uhc\game\Game;
use uhc\listeners\custom\PvpEnabledEvent;

class UpdateTimeTask extends Task {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onRun() : void {
        if($this->game->hasStarted()) {
            if($this->game->getPvpTime()->equals($this->game->getDuration())) {
                $ev = new PvpEnabledEvent($this->game->getPvpTime());
            }

            $this->game->getDuration()->addSeconds(1);
            $this->game->getDuration()->update();
        }
    }
}