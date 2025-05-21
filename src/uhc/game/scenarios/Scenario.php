<?php

namespace uhc\game\scenarios;

use pocketmine\event\Event;

abstract class Scenario implements ScenarioIds {
    private bool $enabled = false;

    public function __construct(int $id, string $name, string $description) {
    }

    abstract public function getId() : int;

    abstract public function getName() : string;

    abstract public function getDescription() : string;

    public function isEnabled() : bool {
        return $this->enabled;
    }

    public function enable() : void {
        $this->enabled = true;
    }

    public function disable() : void {
        $this->enabled = false;
    }

    abstract function onEvent(Event $event) : void;
}