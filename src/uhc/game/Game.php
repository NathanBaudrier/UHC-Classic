<?php

namespace uhc\game;

use hoku\core\utils\Time;
use uhc\game\scenarios\ScenarioManager;
use uhc\game\settings\Border;
use uhc\game\settings\Teams;
use uhc\UPlayer;

class Game {

    private bool $started = false;
    private Time $duration;
    /**
     * @var UPlayer[]
     */
    private array $players = [];
    private Border $border;
    private Teams $teams;
    private ScenarioManager $scenarios;
    private Time $pvpTime;

    public function __construct() {
        $this->duration = new Time();
        $this->border = new Border();
        $this->teams = new Teams();
        $this->scenarios = new ScenarioManager();
        $this->pvpTime = new Time(0, 20);
    }

    public function hasStarted() : bool {
        return $this->started;
    }

    public function start() : void {
        //TODO
    }

    public function getDuration() : Time {
        return $this->duration;
    }

    public function isInGame(UPlayer $player) : bool {
        return in_array($player, $this->players);
    }

    public function getPlayers() : array {
        return $this->players;
    }

    public function addPlayer(UPlayer $player) : void {
        $this->players[] = $player;
    }

    public function removePlayer(UPlayer $player) : void {
        $key = array_search($player, $this->players);
    }

    public function getBorder() : Border {
        return $this->border;
    }

    public function getTeams() : Teams {
        return $this->teams;
    }

    public function getScenarios() : ScenarioManager {
        return $this->scenarios;
    }

    public function getPvpTime() : Time {
        return $this->pvpTime;
    }
}