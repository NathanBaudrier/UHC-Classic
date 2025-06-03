<?php

namespace uhc;

use pocketmine\plugin\PluginBase;
use uhc\game\Game;
use uhc\listeners\PlayerListeners;
use uhc\listeners\ScenarioListeners;

class Main extends PluginBase {

    private static self $instance;
    private Game $game;

    public function onEnable() : void {
        self::$instance = $this;
        $this->game = new Game($this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerListeners($this->game), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ScenarioListeners($this->game), $this);
    }

    public static function getInstance() : self {
        return self::$instance;
    }

    public function getGame() : Game {
        return $this->game;
    }
}