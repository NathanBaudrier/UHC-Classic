<?php

namespace uhc\utils\scenarios;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\TextFormat;

class DamageCycle {
    private const PREFIX = TextFormat::WHITE . "[" . TextFormat::YELLOW . TextFormat::BOLD . "INFO" . TextFormat::RESET . TextFormat::WHITE . "] ";
    private int $cause;
    private int $deaths = 0;

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
        $description = self::PREFIX;

        switch ($this->cause) {
            case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                $description .= "Subir le moindre dégât de la part d'entités ou de joueurs vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_PROJECTILE:
                $description .= "Subir le moindre dégât d'un projectile (exemple: flèches) vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_SUFFOCATION:
                $description .= "Subir le moindre dégâts de suffocation vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_FALL:
                $description .= "Subir le moindre dégât de chûte vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_FIRE:
                $description .= "Subir le moindre dégât de feu (UNIQUEMENT SI VOUS MARCHEZ SUR DU FEU) vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_FIRE_TICK:
                $description .= "Subir le moindre dégât de feu (exemple: brûler après avoir été dans la lave) vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_LAVA:
                $description .= "Subir le moindre dégât de lave vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_DROWNING:
                $description .= "Subir le moindre dégât de noyade vous tuera sur le champs";
                break;
            case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
                $description .= "Subir le moindre dégât d'explosion causé par un bloc pour tuera sur le champs";
                break;
            case EntityDamageEvent::CAUSE_ENTITY_EXPLOSION:
                $description .= "Subir le moindre dégât d'explosion causé par des monstres vous tuera sur le champs";
                break;
            case EntityDamageEvent::CAUSE_MAGIC:
                $description .= "Subir le moindre dégât de magie (exemple: potion de dégâts) vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_STARVATION:
                $description .= "Subir le moindre dégât de faim vous tuera sur le champs.";
                break;
            case EntityDamageEvent::CAUSE_FALLING_BLOCK:
                $description .= "Subir le moindre dégât d'une chûte d'un bloc vous tuera sur le champs.";
                break;
            default:
                $this->cause = self::generateNew()->getCause();
                $description = $this->getDescription();
        }

        return $description;
    }

    public function getDeaths() : int {
        return $this->deaths;
    }

    public function addDeath() : void {
        $this->deaths++;
    }

    public static function generateNew() : self {
        return new self(array_rand(
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
        ));
    }
}