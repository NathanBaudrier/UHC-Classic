<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\game\scenarios\DamageCycle;

class NewDamageCycleEvent extends Event {

    private ?DamageCycle $cycle;

    public function __construct(?DamageCycle $cycle) {
        $this->cycle = $cycle;
    }

    public function getCycle(): ?DamageCycle {
        return $this->cycle;
    }
}