<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Event;
use pocketmine\scheduler\ClosureTask;
use uhc\game\scenarios\Scenario;
use uhc\Main;

class AutoBreakScenario extends Scenario {

    public function getId() : int {
        return self::AUTO_BREAK_ID;
    }

    public function getName() : string {
        return "Auto Break";
    }

    public function getDescription() : string {
        return "Auto Break";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockPlaceEvent) return;

        $block = $event->getBlockAgainst();

        Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use ($block) {
            $block?->getPosition()->getWorld()->setBlock($block->getPosition()->asVector3(), VanillaBlocks::AIR());
        }), 60*20);
    }
}