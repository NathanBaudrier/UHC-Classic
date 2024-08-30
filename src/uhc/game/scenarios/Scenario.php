<?php

namespace uhc\game\scenarios;

class Scenario {

    private int $id;
    private string $name;
    private string $description;
    private bool $enabled = false;

    public function __construct(int $id, string $name, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function isEnabled() : bool {
        return $this->enabled;
    }

    public function enable() : void {
        $this->enabled = true;
    }

    public function disable() : void {
        $this->enabled = false;
    }
}