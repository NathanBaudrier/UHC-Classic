<?php

namespace uhc\game\settings;

use uhc\Main;

class TeamSettings {

    public const int MIN_TEAMS = 2;
    public const int MAX_TEAMS = 16;
    public const int MIN_PLAYERS = 2;
    public const int MAX_PLAYERS = 5;

    private bool $enabled;
    private int $numberOfEnabledTeams;
    private int $maxPlayersPerTeam;
    private bool $random;

    public function __construct(bool $enabled, int $numberOfEnabledTeams, int $maxPlayersPerTeam, bool $random) {
        $this->enabled = $enabled;
        $this->numberOfEnabledTeams = $numberOfEnabledTeams;
        $this->maxPlayersPerTeam = $maxPlayersPerTeam;
        $this->random = $random;
    }

    /**
     * Create a default TeamSettings instance
     * @return self
     */
    public static function Default() : self {
        $maxPlayers = Main::getInstance()->getServer()->getMaxPlayers();
        $numberOfTeams = self::MIN_TEAMS;
        $maxPlayersPerTeam = self::MIN_PLAYERS;

        for($i = self::MIN_TEAMS; $i <= self::MAX_TEAMS; $i++) {
            $stop = false;

            for($j = self::MIN_PLAYERS; $j <= self::MAX_PLAYERS; $j++) {
                if($i * $j >= $maxPlayers) {
                    $numberOfTeams = $i;
                    $maxPlayersPerTeam = $j;
                    $stop = true;
                    break;
                }
            }

            if($stop) break;
        }

        return new self(
            false,
            $numberOfTeams,
            $maxPlayersPerTeam,
            false
        );
    }

    public function areEnabled() : bool {
        return $this->enabled;
    }

    public function getNumberOfEnabledTeams() : int {
        return $this->numberOfEnabledTeams;
    }

    public function getMaxPlayersPerTeam() : int {
        return $this->maxPlayersPerTeam;
    }

    public function areRandomTeams() : bool {
        return $this->random;
    }
}