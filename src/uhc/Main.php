<?php

namespace uhc;

use pocketmine\plugin\PluginBase;
use uhc\game\Game;
use uhc\listeners\PlayerListeners;
use uhc\listeners\ScenarioListeners;

class Main extends PluginBase {

    private static self $instance;
    private static Game $game;

    public function onEnable() : void {
        self::$instance = $this;
        self::$game = new Game($this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerListeners(self::$game), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ScenarioListeners(self::$game), $this);
    }

    public static function getInstance() : self {
        return self::$instance;
    }

    public static function getGame() : Game {
        return self::$game;
    }
}