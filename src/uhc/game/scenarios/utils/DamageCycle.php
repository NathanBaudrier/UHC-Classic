<?php

namespace uhc\game\scenarios\utils;

use pocketmine\event\entity\EntityDamageEvent;

class DamageCycle {
    private int $cause;

    public function __construct(int $cause) {
        $this->cause = $cause;
    }

    public function getCause(): int {
        return $this->cause;
    }

    public function getName() : string {
        switch ($this->cause) {
            case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                return "Attaques";
            case EntityDamageEvent::CAUSE_PROJECTILE:
                return "Projectiles";
            case EntityDamageEvent::CAUSE_SUFFOCATION:
                return "Suffocation";
            case EntityDamageEvent::CAUSE_FALL:
                return "Chûtes";
            case EntityDamageEvent::CAUSE_FIRE:
                return "Feu";
            case EntityDamageEvent::CAUSE_FIRE_TICK:
                return "";
            case EntityDamageEvent::CAUSE_LAVA:
                return "Lave";
            case EntityDamageEvent::CAUSE_DROWNING:
                return "Noyade";
            case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
                return "Explosion Blocs";
            case EntityDamageEvent::CAUSE_ENTITY_EXPLOSION:
                return "Explosion Monstres";
            case EntityDamageEvent::CAUSE_MAGIC:
                return "Magie";
            case EntityDamageEvent::CAUSE_STARVATION:
                return "Faim";
            case EntityDamageEvent::CAUSE_FALLING_BLOCK:
                return "Chûtes Blocs";
            default:
                $this->cause = self::generateNew()->getCause();
                return $this->getName();
        }
    }

    public function getDescription() : string {
        return match ($this->cause) {
            EntityDamageEvent::CAUSE_ENTITY_ATTACK =>
            "Subir le moindre dégât de la part d'entités ou de joueurs vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_PROJECTILE =>
            "Subir le moindre dégât d'un projectile (exemple: flèches) vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_SUFFOCATION =>
            "Subir le moindre dégât de suffocation vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_FALL =>
            "Subir le moindre dégât de chute vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_FIRE =>
            "Subir le moindre dégât de feu (UNIQUEMENT SI VOUS MARCHEZ SUR DU FEU) vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_FIRE_TICK =>
            "Subir le moindre dégât de feu (exemple: brûler après avoir été dans la lave) vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_LAVA =>
            "Subir le moindre dégât de lave vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_DROWNING =>
            "Subir le moindre dégât de noyade vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_BLOCK_EXPLOSION =>
            "Subir le moindre dégât d'explosion causé par un bloc vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_ENTITY_EXPLOSION =>
            "Subir le moindre dégât d'explosion causé par des monstres vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_MAGIC =>
            "Subir le moindre dégât de magie (exemple: potion de dégâts) vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_STARVATION =>
            "Subir le moindre dégât de faim vous tuera sur le champ.",
            EntityDamageEvent::CAUSE_FALLING_BLOCK =>
            "Subir le moindre dégât d'une chute d'un bloc vous tuera sur le champ.",
            default => (function () {
                $this->cause = self::generateNew()->getCause();
                return $this->getDescription();
            })(),
        };

    }

    public function generateNew() : self {
        $this->cause =  array_rand(
            [
                EntityDamageEvent::CAUSE_ENTITY_ATTACK,
                EntityDamageEvent::CAUSE_PROJECTILE,
                EntityDamageEvent::CAUSE_SUFFOCATION,
                EntityDamageEvent::CAUSE_FALL,
                EntityDamageEvent::CAUSE_FIRE,
                EntityDamageEvent::CAUSE_FIRE_TICK,
                EntityDamageEvent::CAUSE_LAVA,
                EntityDamageEvent::CAUSE_DROWNING,
                EntityDamageEvent::CAUSE_BLOCK_EXPLOSION,
                EntityDamageEvent::CAUSE_ENTITY_EXPLOSION,
                EntityDamageEvent::CAUSE_MAGIC,
                EntityDamageEvent::CAUSE_STARVATION,
                EntityDamageEvent::CAUSE_FALLING_BLOCK
            ]
        );

        return $this;
    }
}