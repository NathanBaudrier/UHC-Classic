<?php

namespace uhc\listeners;

use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use uhc\game\Game;
use uhc\UPlayer;

class PlayerListeners implements Listener {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {

            if(!$this->game->hasStarted()) {
                $this->game->addPlayer($player);
                /*$player->isHost() ||*/ $player->getServer()->isOp($player->getName()) ? $player->sendHostInventory() : $player->sendGuessInventory();
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();

        if(!$this->game->hasStarted() && $this->game->isInGame($player)) {
            $this->game->removePlayer($player);
        }
    }

    public function onTransit(InventoryTransactionEvent $event) : void {
        if(!$this->game->hasStarted()) {

        }
    }
}