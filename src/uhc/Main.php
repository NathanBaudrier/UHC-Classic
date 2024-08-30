<?php

namespace uhc;

use pocketmine\plugin\PluginBase;
use uhc\game\Game;

class Main extends PluginBase {

    private static Game $game;

    public function onEnable() : void {

    }

    public static function getGame() : Game {
        return self::$game;
    }
}