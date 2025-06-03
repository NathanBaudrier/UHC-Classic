<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\utils\Utils;

class TimberScenario extends Scenario {

    public function getId() : int {
        return self::TIMBER_ID;
    }

    public function getName() : string {
        return "TimberScenario";
    }

    public function getDescription() : string {
        return "TimberScenario";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;

        $block = $event->getBlock();
        if($block->getTypeId() == BlockTypeIds::OAK_WOOD || $block->getTypeId() == BlockTypeIds::BIRCH_WOOD) {
            Utils::mineConnectedBlocks($block, $block->getTypeId());
        }
    }
}