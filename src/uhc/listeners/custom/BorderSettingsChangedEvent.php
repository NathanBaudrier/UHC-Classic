<?php

namespace uhc\listeners\custom;

use pocketmine\event\Event;
use uhc\game\settings\BorderSettings;

class BorderSettingsChangedEvent extends Event {

    private BorderSettings $oldSettings;
    private BorderSettings $newSettings;

    public function __construct(BorderSettings $oldSettings, BorderSettings $newSettings) {
        $this->oldSettings = $oldSettings;
        $this->newSettings = $newSettings;
    }

    public function getOldSettings() : BorderSettings {
        return $this->oldSettings;
    }

    public function getNewSettings() : BorderSettings {
        return $this->newSettings;
    }
}