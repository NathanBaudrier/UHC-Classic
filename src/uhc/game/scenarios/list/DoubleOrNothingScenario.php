<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;

class DoubleOrNothingScenario extends Scenario {

    public function getId() : int {
        return self::DOUBLE_OR_NOTHING_ID;
    }

    public function getName() : string {
        return "Double Or Nothing";
    }

    public function getDescription() : string {
        return "Double Or Nothing";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;

        $block = $event->getBlock();
        $validOres = [
            BlockTypeIds::COAL_ORE,
            BlockTypeIds::IRON_ORE,
            BlockTypeIds::GOLD_ORE,
            BlockTypeIds::REDSTONE_ORE,
            BlockTypeIds::LAPIS_LAZULI_ORE,
            BlockTypeIds::DIAMOND_ORE,
        ];

        if(in_array($block->getTypeId(), $validOres)) {
            rand(0, 1) ? $event->setDrops(array_map(function ($item) {
                return $item->setCount($item->getCount() * 2); }, $event->getDrops())) : $event->setDrops([]);
        }
    }
}