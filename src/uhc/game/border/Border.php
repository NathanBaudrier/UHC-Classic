<?php

namespace uhc\game\border;

use uhc\game\settings\BorderSettings;
use uhc\listeners\custom\BorderSettingsChangedEvent;

class Border {

    private BorderSettings $settings;
    private int $size;

    public function __construct(BorderSettings $settings) {
        $this->settings = $settings;
        $this->size = $settings->getInitialSize();
    }

    public function changeSettings(BorderSettings $newSettings) : void {
        (new BorderSettingsChangedEvent($this->settings, $newSettings))->call();

        $this->settings = $newSettings;
        $this->size = $newSettings->getInitialSize();
    }

    public function getSettings() : BorderSettings {
        return $this->settings;
    }

    public function getCurrentSize() : int {
        return $this->size;
    }

    public function shrink() : void {
        //TODO
    }
}