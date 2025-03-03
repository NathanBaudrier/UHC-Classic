<?php

namespace uhc\game;

use pocketmine\utils\TextFormat;
use uhc\game\scenarios\manager\DoorManager;
use uhc\game\scenarios\manager\PowerManager;
use uhc\game\scenarios\ScenarioManager;
use uhc\game\settings\Border;
use uhc\game\settings\Teams;
use uhc\Main;
use uhc\tasks\UpdateTimeTask;
use uhc\UPlayer;
use uhc\utils\scenarios\DamageCycle;
use uhc\utils\Time;

class Game {

    private Main $main;
    private bool $started = false;
    private int $limitPlayers = 50;
    private Time $duration;
    /**
     * @var UPlayer[]
     */
    private array $players = [];
    private int $maxPlayers = 30;
    private Border $border;
    private Teams $teams;
    private ScenarioManager $scenarios;
    private Time $pvpTime;
    private array $starterKit = [];

    private ?DamageCycle $damageCycle = null;

    private DoorManager $doors;
    private PowerManager $powers;

    public function __construct() {
        $this->main = Main::getInstance();
        $this->duration = new Time();
        $this->border = new Border();
        $this->teams = new Teams();
        $this->scenarios = new ScenarioManager();
        $this->pvpTime = new Time(0, 20);

        $this->doors = new DoorManager();
    }

    public function hasStarted() : bool {
        return $this->started;
    }

    public function start() : void {
        $this->started = true;

        $this->main->getScheduler()->scheduleRepeatingTask(new UpdateTimeTask($this), 20);
        //TODO
        if($this->teams->areRandom()) {
            //Do random team
        }

        if($this->scenarios->getById($this->scenarios::ANONYMOUS_ID)->isEnabled()) {
            foreach($this->players as $player) {
                $player->setDisplayName(TextFormat::OBFUSCATED . "MONKEY");
                //$player->setSkin(); TODO
            }
        }
    }

    public function getLimitPlayers() : int {
        return $this->limitPlayers;
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
        unset($this->players[array_search($player, $this->players)]);
    }

    public function getMaxPlayers() : int {
        return $this->maxPlayers;
    }

    public function setMaxPlayers(int $maxPlayers) : void {
        $this->maxPlayers = $maxPlayers;
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

    private function doRandomTeam() : void {
        $max = $this->teams->getAmount();
        //TODO
    }

    public function getStarterKit() : array {
        return $this->starterKit;
    }

    public function setStarterKit(array $starterKit) : void {
        $this->starterKit = $starterKit;
    }

    public function getDamageCycle() : ?DamageCycle {
        return $this->damageCycle;
    }

    public function setDamageCycle(DamageCycle $damageCycle) : void {
        $this->damageCycle = $damageCycle;
    }

    public function getDoors() : DoorManager {
        return $this->doors;
    }

    public function getPowers() : PowerManager {
        return $this->powers;
    }
}