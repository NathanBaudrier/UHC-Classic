<?php

namespace uhc\game\teams;

use pocketmine\utils\TextFormat;
use uhc\game\settings\TeamSettings;
use uhc\listeners\custom\TeamSettingsChangedEvent;
use uhc\Main;

class TeamManager implements TeamIds {

    private TeamSettings $settings;

    /**
     * @var Team[]
     */
    private array $teams = [];

    public function __construct(TeamSettings $settings) {
        $this->settings = $settings;

        $this->init();
    }

    private function init() : void {
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

    public function getSettings() : TeamSettings {
        return $this->settings;
    }

    public function changeSettings(TeamSettings $newSettings) : void {
        (new TeamSettingsChangedEvent($this->settings, $newSettings))->call();

        $this->settings = $newSettings;

        for($i = 0; $i < count($this->teams); $i++) {
            if($newSettings->areEnabled()) {
                $this->teams[$i]->setSize($newSettings->getMaxPlayersPerTeam());

                if($i < $newSettings->getNumberOfEnabledTeams()) {
                    $this->teams[$i]->enable();
                } else {
                    $this->teams[$i]->disable();
                }

                while(count($this->teams[$i]->getMembers()) > $this->teams[$i]->getSize()) {
                    $this->teams[$i]->removeMember($this->teams[$i]->getMembers()[array_rand($this->teams[$i]->getMembers())]);
                }
            } else {
                $this->teams[$i]->disable();
            }
        }
    }

    public function getTeams() : array {
        return $this->teams;
    }

    public function areEnabled() : bool {
        return $this->settings->getNumberOfEnabledTeams() > 1;
    }

    public function getEnabledTeams() : array {
        $enabledTeams = [];
        foreach($this->teams as $team) {
            if($team->isEnabled()) $enabledTeams[] = $team;
        }

        return $enabledTeams;
    }

    public function getTeamById(int $id) : ?Team {
        foreach($this->teams as $team) {
            if ($team->getId() === $id) return $team;
        }

        return null;
    }
}