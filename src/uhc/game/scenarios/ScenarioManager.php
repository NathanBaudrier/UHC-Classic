<?php

namespace uhc\game\scenarios;

use uhc\game\scenario\list\HasteyBoys;
use uhc\game\scenarios\list\FinalHeal;
use uhc\game\scenarios\list\Timber;
use uhc\game\scenarios\list\VanillaPlus;

class ScenarioManager implements ScenarioIds {

    /**
     * @var Scenario[]
     */
    private array $scenarios = [];

    public function __construct() {
        $this->init();
    }

    private function init() : void {
        $this->scenarios[] = new FinalHeal();
        $this->scenarios[] = new VanillaPlus();
        $this->scenarios[] = new Timber();
        $this->scenarios[] = new HasteyBoys();
    }

    /**
     * Return all scenarios
     * @return Scenario[]
     */
    public function getAll() : array {
        return $this->scenarios;
    }

    /**
     * Return all the enabled scenarios
     * @return Scenario[]
     */
    public function getEnabled() : array {
        $enabledScenarios = [];

        foreach($this->scenarios as $scenario) {
            if($scenario->isEnabled()) $enabledScenarios[] = $scenario;
        }

        return $enabledScenarios;
    }

    /**
     * Return sorted scenarios (those that are enabled and then those that are disabled)
     * @return Scenario[]
     */
    public function getSorted() : array {
        $enabled  = $this->getEnabled();
        $disabled = $this->getAll();

        foreach($disabled as $scenario) {
            if(in_array($scenario, $enabled)) unset($disabled[array_search($scenario, $disabled)]);
        }

        return array_merge($enabled, $disabled);
    }

    /**
     * Return a scenario by his id
     * @param int $id
     * @return Scenario|null
     */
    public function getById(int $id) : ?Scenario {
        foreach($this->scenarios as $scenario) {
            if($scenario->getId() == $id) return $scenario;
        }

        return null;
    }
}