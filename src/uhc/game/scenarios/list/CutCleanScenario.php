<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\GoldOre;
use pocketmine\block\IronOre;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use pocketmine\item\VanillaItems;
use pocketmine\player\GameMode;
use uhc\game\scenarios\Scenario;
use uhc\Main;

class CutCleanScenario extends Scenario {

    public function getId() : int {
        return self::CUT_CLEAN_ID;
    }

    public function getName() : string {
        return "Cut Clean";
    }

    public function getDescription() : string {
        return "Cut Clean";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof BlockBreakEvent) return;
        if($event->getPlayer()->getGamemode() !== GameMode::SURVIVAL()) return;

        $block = $event->getBlock();
        if(
            Main::getInstance()->getGame()->getScenarios()->getById(self::VEIN_MINER_ID)->isEnabled() &&
            !$event->getItem()->equals(VanillaItems::AIR()) &&
            $block instanceof IronOre ||
            $block instanceof GoldOre
        ) {
            $event->setDrops([]);
            return;
        }

        if($block instanceof IronOre) {
            $event->setDrops([VanillaItems::IRON_INGOT()]);
            $event->setXpDropAmount(1);
        } else if($block instanceof GoldOre) {
            $event->setDrops([VanillaItems::GOLD_INGOT()]);
            $event->setXpDropAmount(2);
        }
    }
}