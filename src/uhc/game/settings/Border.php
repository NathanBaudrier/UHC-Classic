<?php

namespace uhc\game\settings;

class Border {

    private int $initialSize = 1500;
    private int $finalSize = 350;
    private int $speed = 20;

    private int $size;

    public function __construct() {
        $this->size = $this->initialSize;
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

    public function getSize() : int {
        return $this->size;
    }
}