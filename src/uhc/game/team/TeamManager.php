<?php

namespace uhc\game\team;

use pocketmine\utils\TextFormat;

class TeamManager implements TeamIds {

    /**
     * @var Team[]
     */
    private array $teams = [];

    public function __construct() {
        $this->init();
    }

    public function init() : void {
        $this->teams[] = new Team(self::RED, "Red", TextFormat::RED);
        $this->teams[] = new Team(self::DARK_RED, "Dark Red", TextFormat::DARK_RED);
        $this->teams[] = new Team(self::GOLD, "Gold", TextFormat::GOLD);
        $this->teams[] = new Team(self::YELLOW, "Yellow", TextFormat::YELLOW);
        $this->teams[] = new Team(self::GREEN, "Green", TextFormat::GREEN);
        $this->teams[] = new Team(self::DARK_GREEN, "Dark Green", TextFormat::DARK_GREEN);
        $this->teams[] = new Team(self::AQUA, "Aqua", TextFormat::AQUA);
        $this->teams[] = new Team(self::DARK_AQUA, "Dark Aqua", TextFormat::DARK_AQUA);
        $this->teams[] = new Team(self::DARK_BLUE, "Blue", TextFormat::BLUE);
        $this->teams[] = new Team(self::DARK_BLUE, "Dark Blue", TextFormat::DARK_BLUE);
        $this->teams[] = new Team(self::PINK, "Pink", TextFormat::LIGHT_PURPLE);
        $this->teams[] = new Team(self::PURPLE, "Purple", TextFormat::DARK_PURPLE);
        $this->teams[] = new Team(self::WHITE, "White", TextFormat::WHITE);
        $this->teams[] = new Team(self::GRAY, "Gray", TextFormat::GRAY);
        $this->teams[] = new Team(self::DARK_GRAY, "Dark Gray", TextFormat::DARK_GRAY);
        $this->teams[] = new Team(self::BLACK, "Black", TextFormat::BLACK);
    }

    public function getTeams() : array {
        return $this->teams;
    }

    public function getTeamById(int $id) : ?Team {
        foreach($this->teams as $team) {
            if ($team->getId() === $id) return $team;
        }

        return null;
    }
}