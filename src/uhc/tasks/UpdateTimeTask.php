<?php

namespace uhc\tasks;

use pocketmine\scheduler\Task;
use uhc\game\Game;
use uhc\listeners\custom\NewDamageCycleEvent;
use uhc\listeners\custom\PvpEnabledEvent;

class UpdateTimeTask extends Task {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onRun() : void {
        $game = $this->game;

        if($game->hasStarted()) {
            if($game->getPvpTime()->equals($game->getDuration())) {
                $ev = new PvpEnabledEvent($game->getPvpTime());
            }

            if($game->getScenarios()->getById($game->getScenarios()::DAMAGE_CYCLE_ID)->isEnabled()) {
                if($game->getDuration()->getMinutes() % 5 == 0) {
                    (new NewDamageCycleEvent($game->getDamageCycle()))->call();
                }
            }

            $game->getDuration()->addSeconds(1);
            $game->getDuration()->update();
        }
    }
}