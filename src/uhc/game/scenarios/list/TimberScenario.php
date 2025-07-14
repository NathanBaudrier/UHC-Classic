<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use pocketmine\item\VanillaItems;
use uhc\game\scenarios\Scenario;
use uhc\utils\Utils;

class TimberScenario extends Scenario {

    public function getId() : int {
        return self::TIMBER_ID;
    }

    public function getName() : string {
        return "Timber";
    }

    public function getDescription() : string {
        return "Timber";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;

        $block = $event->getBlock();

        if($block->getTypeId() == BlockTypeIds::OAK_LOG || $block->getTypeId() == BlockTypeIds::BIRCH_LOG) {
            Utils::mineConnectedBlocks($block, $block->getTypeId());
            $event->setDrops([]);
        }
    }
}