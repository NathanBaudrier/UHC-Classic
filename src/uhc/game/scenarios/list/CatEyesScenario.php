<?php

namespace uhc\game\scenarios\list;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\MilkBucket;
use uhc\game\scenarios\Scenario;
use uhc\Main;

class CatEyesScenario extends Scenario {

    public function getId() : int {
        return self::CAT_EYES_ID;
    }

    public function getName() : string {
        return "CatEyesScenario";
    }

    public function getDescription() : string {
        return "CatEyesScenario";
    }

    public function onEvent(Event $event) : void {
        if($event instanceof PlayerJoinEvent) {
            $player = $event->getPlayer();

            if(Main::getInstance()->getGame()->isInGame($player)) {
                $player->getEffects()->add(new EffectInstance(VanillaEffects::NIGHT_VISION(), 9999999, 0, false));
            }
        } else if($event instanceof PlayerItemConsumeEvent) {
            $player = $event->getPlayer();

            if($event->getItem() instanceof MilkBucket) {
                foreach($player->getEffects()->all() as $effect) {
                    if($effect->getType()->getName() != VanillaEffects::NIGHT_VISION()->getName()) {
                        $player->getEffects()->remove($effect);
                    }
                }
            }
        }
    }
}