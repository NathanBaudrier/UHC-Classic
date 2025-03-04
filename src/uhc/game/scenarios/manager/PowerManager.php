<?php

namespace uhc\game\scenarios\manager;

class PowerManager {

    const int STRENGTH_POWER = 1;
    const int RESISTANCE_POWER = 2;
    const int JUMP_BOOST_POWER = 3;
    const int SPEED_POWER = 4;
    const int DOUBLE_LIFE_POWER = 5;

    public function chooseRandom() : int {
        return rand(self::STRENGTH_POWER, self::DOUBLE_LIFE_POWER);
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
}