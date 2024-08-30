<?php

namespace uhc;

use pocketmine\player\Player;

class UPlayer extends Player {

    public function sendHostInventory() : void {
        $this->getInventory()->clearAll();
        $this->getInventory()->setContents();
    }

    public function sendGuessInventory() : void {
        $this->getInventory()->clearAll();
    }
}