<?php

namespace uhc\game\scenarios\list;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Event;
use uhc\game\scenarios\Scenario;
use uhc\listeners\custom\UPlayerDeathEvent;

class FastGatewayScenario extends Scenario {

    public function getId() : int {
        return self::FAST_GATEWAY_ID;
    }

    public function getName() : string {
        return "Fast Gateway";
    }

    public function getDescription() : string {
        return "Fast Gateway";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof UPlayerDeathEvent) return;

        $event->getKiller()?->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 20 * 60));
    }
}