<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\Gravel;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use pocketmine\item\VanillaItems;
use uhc\game\scenarios\Scenario;

class VanillaPlusScenario extends Scenario {

    public function getId() : int {
        return self::VANILLA_PLUS_ID;
    }

    public function getName() : string {
        return "Vanilla+";
    }

    public function getDescription() : string {
        return "Vanilla+";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;

        $block = $event->getBlock();
        $random = rand(1, 5);

        if($random != 1) return;

        if($block instanceof Gravel) {
            $event->setDrops([VanillaItems::FLINT()]);
        } else if($block->getTypeId() == BlockTypeIds::OAK_LEAVES || $block->getTypeId() == BlockTypeIds::DARK_OAK_LEAVES) {
            $event->setDrops([VanillaItems::APPLE()]);
        }
    }
}