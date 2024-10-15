<?php

namespace uhc\libs\scoreboard;

use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;

// ABSTRACT CLASS IN CORE //
class Scoreboard {

    private string $displayName;
    private string $objectiveName;
    private string $displaySlot;
    private int $sortOrder;
    private string $criteriaName;

    private array $lines = [];

    public function __construct(
        string $displayName,
        string $objectiveName,
        string $displaySlot = SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
        int $sortOrder = SetDisplayObjectivePacket::SORT_ORDER_ASCENDING,
        string $criteriaName = "dummy"
    ) {
        $this->displayName = $displayName;
        $this->objectiveName = $objectiveName;
        $this->displaySlot = $displaySlot;
        $this->sortOrder = $sortOrder;
        $this->criteriaName = $criteriaName;
    }

    public function getDisplayName() : string {
        return $this->displayName;
    }

    public function getObjectiveName() : string {
        return $this->objectiveName;
    }

    public function getDisplaySlot() : string {
        return $this->displaySlot;
    }

    public function getSortOrder() : int {
        return $this->sortOrder;
    }

    public function getCriteriaName() : string {
        return $this->criteriaName;
    }

    public function getLines() : array {
        return $this->lines;
    }

    public function addLine(int $index, string $text) : void {
        if($index >= 0 && $index < 15) {
            $this->lines[$index] = $text;
        }
    }

    public function removeLine(int $index) : void {
        unset($this->lines[$index]);
    }

    // ABSTRACT FUNCTION IN CORE TO EXTEND //
    public function update() : void {
        //TODO
    }
}
