<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Event;
use pocketmine\utils\TextFormat;
use uhc\game\scenarios\Scenario;
use uhc\listeners\custom\NewDamageCycleEvent;
use uhc\Main;
use uhc\UPlayer;

class DamageCycleScenario extends Scenario {

    public function getId() : int {
        return self::DAMAGE_CYCLE_ID;
    }

    public function getName() : string {
        return "Damage Cycle";
    }

    public function getDescription() : string {
        return "Damage Cycle";
    }

    public function onEvent(Event $event) : void {
        if($event instanceof NewDamageCycleEvent) {
            $damageCycle = Main::getInstance()->getGame()->getDamageCycle();
            Main::getInstance()->getServer()->broadcastMessage(
                TextFormat::WHITE . "[" . TextFormat::YELLOW . "DamageCycleScenario" . TextFormat::WHITE . "] " . TextFormat::BOLD . $damageCycle->getName() . "\n" .
                $damageCycle->getDescription()
            );
        } else if($event instanceof EntityDamageEvent) {
            if(!($player = $event->getEntity()) instanceof UPlayer) return;

            if($event->getCause() == Main::getInstance()->getGame()->getDamageCycle()->getCause()) $player->kill();
        }

    }
}