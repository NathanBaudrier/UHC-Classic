<?php

namespace uhc\game\scenarios\utils;

use pocketmine\block\Door;

class DoorManager {

    /**
     * @var Door[]
     */
    private array $doors = [];

    public function getAll(): array {
        return $this->doors;
    }

    public function add(Door $door): void {
        $this->doors[] = $door;
    }

    public function remove(Door $door): void {
        unset($this->doors[array_search($door, $this->doors)]);
    }

    public function chooseRandom(): Door {
        return $this->doors[array_rand($this->doors)];
    }

    public function exists(Door $door): bool {
        return isset($this->doors[array_search($door, $this->doors)]);
    }
}