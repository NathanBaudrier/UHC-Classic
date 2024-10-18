<?php

namespace uhc\game\scenarios;

class ScenarioManager implements ScenarioIds {

    /**
     * @var Scenario[]
     */
    private array $scenarios = [];

    public function __construct() {
        $this->init();
    }

    public function init() : void {
        $this->scenarios[] = new Scenario(self::FINAL_HEAL_ID, "Final Heal", "");
        $this->scenarios[] = new Scenario(self::CAT_EYES_ID, "Cat Eyes", "");
        $this->scenarios[] = new Scenario(self::TIMBER_ID, "Timber", "");
        $this->scenarios[] = new Scenario(self::HASTEY_BOYS_ID, "Hastey Boys", "");
        $this->scenarios[] = new Scenario(self::BLOOD_DIAMOND_ID, "Blood Diamond", "");
        $this->scenarios[] = new Scenario(self::BLOOD_ENCHANT_ID, "Blood Enchant", "");
        $this->scenarios[] = new Scenario(self::BLOOD_FUSION_ID, "Blood Fusion", "");
        $this->scenarios[] = new Scenario(self::BOOKCEPTION_ID, "Bookception", "");
        $this->scenarios[] = new Scenario(self::BOW_SEED_ID, "Bow See", "");
        $this->scenarios[] = new Scenario(self::NO_CLEAN_UP_ID, "No Clean Up", "");
        $this->scenarios[] = new Scenario(self::TIME_BOMB_ID, "Time Bomb", "");
        $this->scenarios[] = new Scenario(self::CUT_CLEAN_ID, "Cut Clean", "");
        $this->scenarios[] = new Scenario(self::BOW_SWAP_ID, "Bow Swap", "");
        $this->scenarios[] = new Scenario(self::FAST_GATEWAY_ID, "Fast Gateway", "");
        $this->scenarios[] = new Scenario(self::LONG_SHOT_ID, "Long Shot", "");
        $this->scenarios[] = new Scenario(self::DOUBLE_OR_NOTHING_ID, "Double Or Nothing", "");
        $this->scenarios[] = new Scenario(self::BLOCKED_ID, "Blocked", "");
        $this->scenarios[] = new Scenario(self::BENCH_BLITZ_ID, "Bench Blitz", "");
        $this->scenarios[] = new Scenario(self::DAMAGE_CYCLE_ID, "Damage Cycle", "");
        $this->scenarios[] = new Scenario(self::MONSTER_AND_CIE_ID, "Monster & Cie", "");
        $this->scenarios[] = new Scenario(self::SHARED_LIFE_ID, "Shared Life", "");
        $this->scenarios[] = new Scenario(self::PARANOIA_ID, "Paranoia", "");
        $this->scenarios[] = new Scenario(self::NINE_SLOTS_ID, "Nine Slots", "");
        $this->scenarios[] = new Scenario(self::BACK_PACK_ID, "Backpack", "");
        $this->scenarios[] = new Scenario(self::MYSTERY_TEAM_ID, "Mystery Team", "");
        $this->scenarios[] = new Scenario(self::ROCK_PAPER_SCISSORS_ID, "Rock, Paper, Scissors", "");
        $this->scenarios[] = new Scenario(self::BEST_PVE_ID, "Best PVE", "");
        $this->scenarios[] = new Scenario(self::AUTO_BREAK_ID, "Auto Break", "");
        $this->scenarios[] = new Scenario(self::BAREBONES_ID, "Barebones", "");
        $this->scenarios[] = new Scenario(self::ANONYMOUS_ID, "Anonymous", "");
        $this->scenarios[] = new Scenario(self::ASSAULT_AND_BATTERY_ID, "Assault and Battery", "");
        $this->scenarios[] = new Scenario(self::CRIPPLE_ID, "Cripple", "");
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
    
    public function getById(int $id) : ?Scenario {
        foreach($this->scenarios as $scenario) {
            if($scenario->getId() == $id) return $scenario;
        }

        return null;
    }
}