<?php

namespace uhc\listeners\custom;

use uhc\utils\Time;
use pocketmine\event\Event;

class PvpEnabledEvent extends Event {

    private Time $time;

    public function __construct(Time $time) {
        $this->time = $time;
    }

    public function getTime(): Time {
        return $this->time;
    }
}