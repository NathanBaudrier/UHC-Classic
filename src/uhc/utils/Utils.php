<?php

namespace uhc\utils;

use pocketmine\block\Block;

class Utils {

    /**
     * @param Block $from
     * @param int $blockId
     * @return void
     */
    public static function mineConnectedBlocks(Block $from, int $blockId) : void {
        if($from->getTypeId() == $blockId) {
            $world = $from->getPosition()->getWorld();
            $world->useBreakOn($from->getPosition());

            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(1, 0, 0)), $blockId);
            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(0, 1, 0)), $blockId);
            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(0, 0, 1)), $blockId);
            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(-1, 0, 0)), $blockId);
            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(0, -1, 0)), $blockId);
            self::mineConnectedBlocks($world->getBlock($from->getPosition()->asVector3()->add(0, 0, -1)), $blockId);
        }
    }
}