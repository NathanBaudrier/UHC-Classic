<?php

namespace uhc\utils;

use pocketmine\block\Block;
use pocketmine\player\Player;

class Utils {

    /**
     * @param Block $from
     * @param int $blockId
     * @param Player|null $player
     * @return void
     */
    public static function mineConnectedBlocks(Block $from, int $blockId, Player $player = null) : void {
        self::_mineConnectedBlocks($from, $blockId, $player);
    }

    /**
     * @param Block $block
     * @param int $blockId
     * @param Player|null $player
     * @param array $visited
     * @param int $count
     * @return void
     */
    private static function _mineConnectedBlocks(Block $block, int $blockId, Player $player = null, array &$visited = [], int $count = 0) : void {
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
            self::_mineConnectedBlocks($nextBlock, $blockId, $player, $visited, $count + 1);
        }
    }
}