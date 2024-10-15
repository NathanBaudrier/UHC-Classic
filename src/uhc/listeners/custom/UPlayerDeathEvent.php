<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\UPlayer;

class UPlayerDeathEvent extends Event {

    private UPlayer $player;
    private ?UPlayer $killer;

    public function __construct(UPlayer $player, ?UPlayer $killer = null) {
        $this->player = $player;
        $this->killer = $killer;
    }

    public function getPlayer(): UPlayer {
        return $this->player;
    }

    public function getKiller(): ?UPlayer {
        return $this->killer;
    }
}