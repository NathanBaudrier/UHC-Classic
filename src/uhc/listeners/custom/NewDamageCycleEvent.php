<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\game\scenarios\DamageCycle;

class NewDamageCycleEvent extends Event {

    private ?DamageCycle $lastCycle;

    public function __construct(?DamageCycle $lastCycle) {
        $this->lastCycle = $lastCycle;
    }

    public function getLastCycle(): ?DamageCycle {
        return $this->lastCycle;
    }
}