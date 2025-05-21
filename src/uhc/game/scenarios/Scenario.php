<?php

namespace uhc\game\scenarios;

abstract class Scenario implements ScenarioIds {

    private int $id;
    private string $name;
    private string $description;
    private bool $enabled = false;

    public function __construct(int $id, string $name, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    abstract public function getId() : int;

    abstract public function getName() : string;

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