<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\game\settings\TeamSettings;

class TeamSettingsChangedEvent extends Event {

    private TeamSettings $oldSettings;
    private TeamSettings $newSettings;

    public function __construct(TeamSettings $oldSettings, TeamSettings $newSettings) {
        $this->oldSettings = $oldSettings;
        $this->newSettings = $newSettings;
    }

    public function getOldSettings() : TeamSettings {
        return $this->oldSettings;
    }

    public function getNewSettings() : TeamSettings {
        return $this->newSettings;
    }
}