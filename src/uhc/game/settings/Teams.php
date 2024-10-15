<?php

namespace uhc\game\settings;

class Teams {

    private int $amount = 0;
    private bool $random = false;

    public function getAmount() : int {
        return $this->amount;
    }

    public function areRandom() : bool {
        return $this->random;
    }

    public function areEnabled() : bool {
        return $this->amount > 0;
    }

    public function enableRandom() : void {
        $this->random = true;
    }

    public function disableRandom() : void {
        $this->random = false;
    }
}