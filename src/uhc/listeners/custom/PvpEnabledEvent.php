<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\utils\Time;

class PvpEnabledEvent extends Event {

    private Time $time;

    public function __construct(Time $time) {
        $this->time = $time;
    }

    public function getTime(): Time {
        return $this->time;
    }
}