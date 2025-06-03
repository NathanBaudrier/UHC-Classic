<?php

namespace uhc\game\scenarios\list;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Event;
use pocketmine\player\GameMode;

use uhc\game\scenarios\Scenario;
use uhc\UPlayer;

class CrippleScenario extends Scenario {

    public function getId() : int {
        return self::CRIPPLE_ID;
    }

    public function getName() : string {
        return "Cripple";
    }

    public function getDescription() : string {
        return "Cripple";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof EntityDamageEvent) return;
        if(!($player = $event->getEntity()) instanceof UPlayer) return;
        if($player->getGamemode() !== GameMode::SURVIVAL()) return;

        if($event->getCause() == EntityDamageEvent::CAUSE_FALL) {
            $player->getEffects()->add(new EffectInstance(VanillaEffects::SLOWNESS(), 20*90, 0, false));
        }
    }
}