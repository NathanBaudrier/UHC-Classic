<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;

class Timber extends Scenario {

    public function getId() : int {
        return self::TIMBER_ID;
    }

    public function getName() : string {
        return "Timber";
    }

    public function getDescription() : string {
        return "";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;

        $block = $event->getBlock();
        $world = $block->getPosition()->getWorld();

        if(($block->getTypeId() == BlockTypeIds::OAK_LOG || $block->getTypeId() == BlockTypeIds::BIRCH_LOG) && count($event->getDrops()) != 0) {
            for($y = $block->getPosition()->getY() + 1;
                (
                $nextBlock = $world->getBlock($block->getPosition()->asVector3()->add(0, 1, 0))
                )
                    ->getTypeId() == BlockTypeIds::OAK_LOG || $nextBlock->getTypeId() == BlockTypeIds::BIRCH_LOG;
                $y++
            ) {
                $world->setBlock($nextBlock->getPosition()->asVector3(), VanillaBlocks::AIR());
                $world->dropItem($nextBlock->getPosition()->asVector3(), $event->getDrops()[0]);
            }

            for($y = $block->getPosition()->getY() - 1;
                (
                $nextBlock = $world->getBlock($block->getPosition()->asVector3()->add(0, -1, 0))
                )
                    ->getTypeId() == BlockTypeIds::OAK_LOG || $nextBlock->getTypeId() == BlockTypeIds::BIRCH_LOG;
                $y--
            ) {
                $world->setBlock($nextBlock->getPosition()->asVector3(), VanillaBlocks::AIR());
                $world->dropItem($nextBlock->getPosition()->asVector3(), $event->getDrops()[0]);
            }
        }
    }
}