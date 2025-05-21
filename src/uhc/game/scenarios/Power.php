<?php

namespace uhc\game\scenarios;

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
            self::STRENGTH_POWER => "",
            self::RESISTANCE_POWER => "",
            self::JUMP_BOOST_POWER => "",
            self::SPEED_POWER => "",
            self::DOUBLE_LIFE_POWER => ""
        };
    }
}