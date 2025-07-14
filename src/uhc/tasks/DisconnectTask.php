<?php

namespace uhc\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use uhc\Main;
use uhc\UPlayer;

class DisconnectTask extends Task {

    private UPlayer $player;

    public function __construct(UPlayer $player) {
        $this->player = $player;
    }

    public function onRun() : void {
        Main::getInstance()->getGame()->removePlayer($this->player);
        Server::getInstance()->broadcastMessage(TextFormat::RED . $this->player->getName() . " s'est déconnecté depuis plus de 10 minutes, il est donc exlu de la partie.");
        $this->getHandler()->cancel();
    }
}