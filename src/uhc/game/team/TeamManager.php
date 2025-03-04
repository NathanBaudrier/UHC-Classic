<?php

namespace uhc\game\team;

use pocketmine\utils\TextFormat;
use uhc\Main;

class TeamManager implements TeamIds {

    public const int MIN_TEAMS = 2;
    public const int MAX_TEAMS = 16;
    public const int MIN_PLAYERS = 2;
    public const int MAX_PLAYERS = 5;

    /**
     * @var Team[]
     */
    private array $teams = [];
    private int $enabledTeams = 0;
    private int $maxPlayersPerTeam = 2;
    private bool $random = false;

    public function __construct() {
        $this->init();
    }

    public function init() : void {
        $this->teams[] = new Team(self::RED, "Red", TextFormat::RED, "blocks/concrete_powder_red.png");
        $this->teams[] = new Team(self::DARK_RED, "Dark Red", TextFormat::DARK_RED, "blocks/concrete_red.png");
        $this->teams[] = new Team(self::GOLD, "Gold", TextFormat::GOLD, "blocks/concrete_yellow.png");
        $this->teams[] = new Team(self::YELLOW, "Yellow", TextFormat::YELLOW, "blocks/concrete_powder_yellow.png");
        $this->teams[] = new Team(self::GREEN, "Green", TextFormat::GREEN, "blocks/concrete_powder_lime.png");
        $this->teams[] = new Team(self::DARK_GREEN, "Dark Green", TextFormat::DARK_GREEN, "blocks/concrete_powder_green.png");
        $this->teams[] = new Team(self::AQUA, "Aqua", TextFormat::AQUA, "blocks/concrete_powder_light_blue.png");
        $this->teams[] = new Team(self::DARK_AQUA, "Dark Aqua", TextFormat::DARK_AQUA, "blocks/concrete_powder_cyan.png");
        $this->teams[] = new Team(self::DARK_BLUE, "Blue", TextFormat::BLUE, "blocks/concrete_powder_blue.png");
        $this->teams[] = new Team(self::DARK_BLUE, "Dark Blue", TextFormat::DARK_BLUE, "blocks/concrete_blue.png");
        $this->teams[] = new Team(self::PINK, "Pink", TextFormat::LIGHT_PURPLE, "blocks/concrete_pink.png");
        $this->teams[] = new Team(self::PURPLE, "Purple", TextFormat::DARK_PURPLE, "blocks/concrete_magenta.png");
        $this->teams[] = new Team(self::WHITE, "White", TextFormat::WHITE, "blocks/concrete_powder_white.png");
        $this->teams[] = new Team(self::GRAY, "Gray", TextFormat::GRAY, "blocks/concrete_powder_silver.png");
        $this->teams[] = new Team(self::DARK_GRAY, "Dark Gray", TextFormat::DARK_GRAY, "blocks/concrete_powder_gray.png");
        $this->teams[] = new Team(self::BLACK, "Black", TextFormat::BLACK, "blocks/concrete_black.png");
    }

    public function getTeams() : array {
        return $this->teams;
    }

    public function getNumberOfEnabledTeams() : int {
        return $this->enabledTeams;
    }

    public function setNumberOfEnabledTeams(int $enabledTeams) : bool {
        if($enabledTeams < self::MIN_TEAMS || $enabledTeams > self::MAX_TEAMS) return false;
        $this->disableTeams();

        for($i = 0; $i < $enabledTeams; $i++) {
            $this->teams[$i]->enable();
        }

        return true;
    }

    public function getMaxPlayersPerTeam() : int {
        return $this->maxPlayersPerTeam;
    }

    public function setMaxPlayersPerTeam(int $maxPlayersPerTeam) : bool {
        if($maxPlayersPerTeam < self::MIN_PLAYERS || $maxPlayersPerTeam > self::MAX_PLAYERS) return false;

        $this->maxPlayersPerTeam = $maxPlayersPerTeam;
        return true;
    }

    public function disableTeams() : void {
        foreach ($this->teams as $team) {
            $team->disable();
        }
    }

    public function areRandom() : bool {
        return $this->random;
    }

    public function setRandom(bool $value = true) : void {
        $this->random = $value;
    }

    public function getTeamById(int $id) : ?Team {
        foreach($this->teams as $team) {
            if ($team->getId() === $id) return $team;
        }

        return null;
    }

    /**
     * @return Team[]
     */
    public function getEnabledTeams() : array {
        $enabledTeams = [];

        foreach($this->teams as $team) {
            if ($team->isEnabled()) $enabledTeams[] = $team;
        }

        return $enabledTeams;
    }

    public static function getMinTeamsBasedOnOnlinePlayers() : int {
        return round(count(Main::getInstance()->getServer()->getOnlinePlayers()) / self::MAX_PLAYERS);
    }

    public static function getMaxTeamsBasedOnOnlinePlayers() : int {
        return round(count(Main::getInstance()->getServer()->getOnlinePlayers()) / self::MIN_PLAYERS);
    }
}