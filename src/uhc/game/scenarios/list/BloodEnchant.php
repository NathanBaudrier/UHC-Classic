<?php

namespace uhc\game\scenarios\list;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Event;
use pocketmine\event\player\PlayerItemEnchantEvent;
use uhc\game\scenarios\Scenario;

class BloodEnchant extends Scenario {

    public function getId() : int {
        return self::BLOOD_ENCHANT_ID;
    }

    public function getName() : string {
        return "Blood Enchant";
    }

    public function getDescription() : string {
        return "Blood Enchant";
    }

    public function onEvent(Event $event) : void {
        if(!$event instanceof PlayerItemEnchantEvent) return;

        $player = $event->getPlayer();
        $player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, 1));
    }
}