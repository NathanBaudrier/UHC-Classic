<?php

namespace uhc\game\scenarios\utils;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use uhc\UPlayer;

class Power {

    const int STRENGTH_POWER = 0;
    const int RESISTANCE_POWER = 1;
    const int JUMP_BOOST_POWER = 2;
    const int SPEED_POWER = 3;
    const int DOUBLE_LIFE_POWER = 4;

    private int $id;

    public function __construct() {
        $this->id = rand(self::STRENGTH_POWER, self::DOUBLE_LIFE_POWER);
    }

    public function getId() : int {
        return $this->id;
    }

    public function getName(int $power) : string {
        return match ($power) {
            self::STRENGTH_POWER => "Force",
            self::RESISTANCE_POWER => "Résistance",
            self::JUMP_BOOST_POWER => "Saut Boosté",
            self::SPEED_POWER => "Vitesse",
            self::DOUBLE_LIFE_POWER => "Double Vie"
        };
    }

    public function getDescription(int $power) : string {
        return match ($power) {
            self::STRENGTH_POWER => "Vous avez un effet de Force I permanent.",
            self::RESISTANCE_POWER => "Vous avez un effet de Résistance I permanent.",
            self::JUMP_BOOST_POWER => "Vous avez un effet de Jump Boost III permanent.",
            self::SPEED_POWER => "Vous avez un effet de Vitesse I permanent.",
            self::DOUBLE_LIFE_POWER => "Vous avez 20 coeurs permanents."
        };
    }

    public function apply(UPlayer $player) : void {
        switch($this->id) {
            case self::STRENGTH_POWER:
                $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 99999999, 0, false));
                break;

            case self::RESISTANCE_POWER:
                $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 99999999, 0, false));
                break;

            case self::JUMP_BOOST_POWER:
                $player->getEffects()->add(new EffectInstance(VanillaEffects::JUMP_BOOST(), 99999999, 2, false));
                break;

            case self::SPEED_POWER:
                $player->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 99999999, 0, false));
                break;

            case self::DOUBLE_LIFE_POWER:
                $player->setMaxHealth(20);
        }
    }
}