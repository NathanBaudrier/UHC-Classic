<?php

namespace uhc;

use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;
use uhc\game\team\Team;
use uhc\items\ConfigItem;
use uhc\libs\scoreboard\Scoreboard;

class UPlayer extends Player {

    private ?Scoreboard $scoreboard = null;
    private ?Team $team = null;

    public function isOp() : bool {
        return $this->getServer()->isOp($this->getName());
    }
    public function isHost() : bool {
        return true;
    }

    public function sendHostInventory() : void {
        $this->getInventory()->clearAll();
        $this->getInventory()->setContents([
            4 => new ConfigItem()
        ]);
    }

    public function sendGuessInventory() : void {
        $this->getInventory()->clearAll();
    }

    public function getScoreboard() : ?Scoreboard {
        return $this->scoreboard;
    }

    public function setScoreboard(Scoreboard $scoreboard) : void {
        $this->scoreboard = $scoreboard;
    }

    public function removeScoreboard() : void {
        $this->scoreboard = null;
    }

    public function sendScoreboard() : void
    {
        if (!is_null($this->scoreboard)) {
            $scoreboard = new SetDisplayObjectivePacket();

            $scoreboard->displayName = $this->scoreboard->getDisplayName();
            $scoreboard->objectiveName = $this->scoreboard->getObjectiveName();
            $scoreboard->displaySlot = $this->scoreboard->getDisplaySlot();
            $scoreboard->sortOrder = $this->scoreboard->getSortOrder();
            $scoreboard->criteriaName = $this->scoreboard->getCriteriaName();

            $this->getNetworkSession()->sendDataPacket($scoreboard);

            $scorePacket = new SetScorePacket();
            $scorePacket->type = SetScorePacket::TYPE_CHANGE;

            var_dump($this->scoreboard->getLines());
            foreach ($this->scoreboard->getLines() as $index => $line) {
                $entry = new ScorePacketEntry();
                $entry->objectiveName = $this->scoreboard->getObjectiveName();
                $entry->customName = $line;
                $entry->score = $index;
                $entry->scoreboardId = $index;
                $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

                $scorePacket->entries[] = $entry;
            }

            $this->getNetworkSession()->sendDataPacket($scorePacket);
        }
    }

    public function getTeam() : Team {
        return $this->team;
    }

    public function setTeam(Team $team) : void {
        $this->team?->removeMember($this);

        $this->team = $team;
        $team->addMember($this);
    }

    public function resetTeam() : void {
        $this->team = null;
    }
}