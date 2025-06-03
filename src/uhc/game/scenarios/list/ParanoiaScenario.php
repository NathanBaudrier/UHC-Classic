<?php

namespace uhc\game\scenarios\list;

use pocketmine\block\DiamondOre;
use pocketmine\block\GoldOre;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\item\GoldenApple;
use uhc\game\scenarios\Scenario;
use uhc\listeners\custom\UPlayerDeathEvent;

class ParanoiaScenario extends Scenario {

    public function getId() : int {
        return self::PARANOIA_ID;
    }

    public function getName() : string {
        return "Paranoia";
    }

    public function getDescription() : string {
        return "Paranoia";
    }

    public function onEvent(Event $event) : void {
        if($event instanceof UPlayerDeathEvent) {
            if(($killer = $event->getKiller()) != null) {
                $player = $event->getPlayer();
                $player->getServer()->broadcastMessage($killer->getName() . " a tué " . $player->getName() . " aux coordonnées : " . round($killer->getPosition()->getX()) . ":" . round($killer->getPosition()->getY()) . ":" . round($killer->getPosition()->getZ()));
            }
        } else if($event instanceof PlayerItemConsumeEvent) {
            if(($item = $event->getItem()) instanceof GoldenApple) {
                $player = $event->getPlayer();
                $player->getServer()->broadcastMessage($player->getName() . " a mangé " . $item->getName() . " aux coordonnées : " . round($player->getPosition()->getX()) . ":" . round($player->getPosition()->getY()) . ":" . round($player->getPosition()->getZ()));
            }
        } else if($event instanceof BlockBreakEvent) {
            $block = $event->getBlock();

            if($block instanceof GoldOre || $block instanceof DiamondOre) {
                $player = $event->getPlayer();
                $player->getServer()->broadcastMessage($player->getName() . " a miné " . $block->getName() . " aux coordonnées : " . round($player->getPosition()->getX()) . ":" . round($player->getPosition()->getY()) . ":" . round($player->getPosition()->getZ()));
            }
        }
    }
}