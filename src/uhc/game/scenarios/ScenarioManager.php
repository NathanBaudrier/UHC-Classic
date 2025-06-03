<?php

namespace uhc\game\scenarios;

use uhc\game\scenarios\list\AutoBreakScenario;
use uhc\game\scenarios\list\BowSeeScenario;
use uhc\game\scenarios\list\BowSwapScenario;
use uhc\game\scenarios\list\CrippleScenario;
use uhc\game\scenarios\list\CutCleanScenario;
use uhc\game\scenarios\list\DamageCycleScenario;
use uhc\game\scenarios\list\DoubleOrNothingScenario;
use uhc\game\scenarios\list\FastGatewayScenario;
use uhc\game\scenarios\list\FinalHealScenario;
use uhc\game\scenarios\list\HasteyBoysScenario;
use uhc\game\scenarios\list\LongShotScenario;
use uhc\game\scenarios\list\NoCleanUpScenario;
use uhc\game\scenarios\list\ParanoiaScenario;
use uhc\game\scenarios\list\TimberScenario;
use uhc\game\scenarios\list\VanillaPlusScenario;
use uhc\game\scenarios\list\BloodDiamondScenario;
use uhc\game\scenarios\list\BloodEnchantScenario;
use uhc\game\scenarios\list\CatEyesScenario;
use uhc\game\scenarios\list\VeinMinerScenario;

class ScenarioManager implements ScenarioIds {

    /**
     * @var Scenario[]
     */
    private array $scenarios = [];

    public function __construct() {
        $this->init();
    }

    public function init() : void {
        $this->scenarios[] = new FinalHealScenario();
        $this->scenarios[] = new CatEyesScenario();
        $this->scenarios[] = new VanillaPlusScenario();
        $this->scenarios[] = new TimberScenario();
        $this->scenarios[] = new HasteyBoysScenario();
        $this->scenarios[] = new BloodDiamondScenario();
        $this->scenarios[] = new BloodEnchantScenario();
        //BloodFusion
        //Bookception
        $this->scenarios[] = new BowSeeScenario();
        $this->scenarios[] = new NoCleanUpScenario();
        //TimeBomb
        $this->scenarios[] = new CutCleanScenario();
        $this->scenarios[] = new BowSwapScenario();
        $this->scenarios[] = new FastGatewayScenario();
        $this->scenarios[] = new LongShotScenario();
        $this->scenarios[] = new DoubleOrNothingScenario();
        //Blocked
        //BenchBlitz
        $this->scenarios[] = new DamageCycleScenario();
        //Monster&Cie
        //SharedLife
        $this->scenarios[] = new ParanoiaScenario();
        //NineSlots
        //BackPack
        //MysteryTeam
        //RockPaperScissors
        $this->scenarios[] = new AutoBreakScenario();
        $this->scenarios[] = new CrippleScenario();
        //SuperHeroes
        $this->scenarios[] = new VeinMinerScenario();
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