<?php

namespace uhc\game\settings;

class BorderSettings {

    private int $initialSize;
    private int $finalSize;
    private int $speed;

    public function __construct(int $initialSize = 1500, int $finalSize = 350, int $speed = 20) {
        $this->initialSize = $initialSize;
        $this->finalSize = $finalSize;
        $this->speed = $speed;
    }

    public function getInitialSize() : int {
        return $this->initialSize;
    }

    public function setInitialSize(int $initialSize) : void {
        $this->initialSize = $initialSize;
    }

    public function getFinalSize() : int {
        return $this->finalSize;
    }

    public function setFinalSize(int $finalSize) : void {
        $this->finalSize = $finalSize;
    }

    public function getSpeed() : int {
        return $this->speed;
    }

    public function setSpeed(int $speed) : void {
        $this->speed = $speed;
    }
}