<?php

namespace uhc\utils;

use pocketmine\block\Block;
use pocketmine\player\Player;

class Utils {

    /**
     * @param Player $player
     * @param Block $from
     * @param int $blockId
     * @return void
     */
    public static function mineConnectedBlocks(Player $player, Block $from, int $blockId) : void {
        self::_mineConnectedBlocks($player, $from, $blockId);
    }

    private static function _mineConnectedBlocks(Player $player, Block $block, int $blockId, array &$visited = [], int $count = 0) : void {
        if($block->getTypeId() != $blockId) return;
        if($count > 50) return;

        $position = $block->getPosition();
        $key = $position->getX() . ":" . $position->getY() . ":" . $position->getZ();

        if(isset($visited[$key])) return;

        $visited[$key] = true;

        $world = $block->getPosition()->getWorld();
        $item = null;
        $world->useBreakOn($block->getPosition(), $item, $player);

        foreach([
                    [ 1,  0,  0],
                    [-1,  0,  0],
                    [ 0,  1,  0],
                    [ 0, -1,  0],
                    [ 0,  0,  1],
                    [ 0,  0, -1],
                ] as [$dx, $dy, $dz]) {
            $nextPos = $position->add($dx, $dy, $dz);
            $nextBlock = $world->getBlock($nextPos);
            self::_mineConnectedBlocks($player, $nextBlock, $blockId, $visited, $count + 1);
        }
    }
}