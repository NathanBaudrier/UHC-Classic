<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\utils\Utils;

class VeinMiner extends Scenario {

    public function getId() : int {
        return self::VEIN_MINER_ID;
    }

    public function getName() : string {
        return "Vein Miner";
    }

    public function getDescription() : string {
        return "Vein Miner";
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

        if(in_array($block->getTypeId(), $validOres)) Utils::mineConnectedBlocks($block, $block->getTypeId());
    }
}