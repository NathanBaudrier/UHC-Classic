<?php

namespace uhc\game;

use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\player\GameMode;
use pocketmine\utils\TextFormat;
use pocketmine\world\format\Chunk;
use uhc\game\scenarios\DamageCycle;
use uhc\game\scenarios\manager\DoorManager;
use uhc\game\scenarios\ScenarioManager;
use uhc\game\settings\Border;
use uhc\game\team\TeamManager;
use uhc\Main;
use uhc\tasks\UpdateTimeTask;
use uhc\UPlayer;
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
    private TeamManager $teams;
    private ScenarioManager $scenarios;
    private Time $pvpTime;
    private array $starterKit = [];

    private ?DamageCycle $damageCycle = null;
    private DoorManager $doors;

    public function __construct(Main $main) {
        $this->main = $main;
        $this->duration = new Time();
        $this->border = new Border();
        $this->teams = new TeamManager();
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

        /*
        if($this->scenarios->getById($this->scenarios::ANONYMOUS_ID)->isEnabled()) {
            foreach($this->players as $player) {
                $player->setDisplayName(TextFormat::OBFUSCATED . "MONKEY" . TextFormat::RESET);
                //$player->setSkin(); TODO
            }
        }
        */

        foreach ($this->players as $player) {
            $randomX = rand(-$this->border->getCurrentSize(), $this->border->getCurrentSize());
            $randomZ = rand(-$this->border->getCurrentSize(), $this->border->getCurrentSize());
            $world = Main::getInstance()->getServer()->getWorldManager()->getDefaultWorld();

            $world->orderChunkPopulation($randomX >> Chunk::COORD_BIT_SIZE, $randomZ >> Chunk::COORD_BIT_SIZE, null)->onCompletion(
                function (Chunk $chunk) use ($randomX, $randomZ, $world, $player): void {
                    $player->teleport(new Vector3($randomX, $world->getHighestBlockAt($randomX, $randomZ) + 1, $randomZ));
                    $player->getInventory()->setContents($this->getStarterKit());
                    $player->setHealth($player->getMaxHealth());
                    $player->setGamemode(GameMode::SURVIVAL);
                },
                fn() => null
            );
        }
    }

    public function createWaitingSpawn() : void {
        $world = $this->main->getServer()->getWorldManager()->getDefaultWorld();
        $baseY = 100;
        $radius = 20;

        // Platform
        for($x = $radius; $x >= -$radius; $x--) {
            for($z = $radius; $z >= -$radius; $z--) {
                $world->setBlock(new Vector3($x, $baseY, $z), VanillaBlocks::BARRIER());
            }
        }

        // Walls
        for($c = $radius + 1; $c >= -$radius - 1; $c--) {
            for($y = $baseY + 1; $y < $baseY + 5; $y++) {
                $world->setBlock(new Vector3($radius + 1, $y, $c), VanillaBlocks::BARRIER());
                $world->setBlock(new Vector3($c, $y, $radius + 1), VanillaBlocks::BARRIER());
            }
        }

        for($c = -$radius - 1; $c <= $radius + 1; $c++) {
            for($y = $baseY + 1; $y < $baseY + 5; $y++) {
                $world->setBlock(new Vector3(-$radius - 1, $y, $c), VanillaBlocks::BARRIER());
                $world->setBlock(new Vector3($c, $y, -$radius - 1), VanillaBlocks::BARRIER());
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

    public function getTeams() : TeamManager {
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
}