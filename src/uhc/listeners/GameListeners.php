<?php

namespace uhc\listeners;

use pocketmine\event\Listener;
use uhc\listeners\custom\BorderSettingsChangedEvent;
use uhc\listeners\custom\TeamSettingsChangedEvent;
use uhc\Main;

class GameListeners implements Listener {

    private Main $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onBorderSettingsChanged(BorderSettingsChangedEvent $event) : void {
        $old = $event->getOldSettings();
        $new = $event->getNewSettings();

        $this->main->getServer()->broadcastMessage(
            "Changements des paramètres de la bordure :\n" .
            "Taille initiale : " . $old->getInitialSize() . " -> " . $new->getInitialSize() . "\n" .
            "Taille finale : " . $old->getFinalSize() . " -> " . $new->getFinalSize() . "\n" .
            "Vitesse : " . $old->getSpeed() . " -> " . $new->getSpeed()
        );
    }

    public function onTeamSettingsChanged(TeamSettingsChangedEvent $event) : void {
        $old = $event->getOldSettings();
        $new = $event->getNewSettings();

        $server = $this->main->getServer();

        if($old->areEnabled() && !$new->areEnabled()) {
            $server->broadcastMessage("Les équipes sont désormais désactivées");
            return;
        }

        if(!$old->areEnabled() && $new->areEnabled()) {
            $server->broadcastMessage("Les équipes sont désormais activées.");
            return;
        }

        $server->broadcastMessage(
            "Changements des paramètres des équipes :\n" .
            "Nombre d'équipes : " . $old->getNumberOfEnabledTeams() . " -> " . $new->getNumberOfEnabledTeams() . "\n" .
            "Nombre de joueurs par équipe : " . $old->getMaxPlayersPerTeam() . " -> " . $new->getMaxPlayersPerTeam() . "\n" .
            "Aléatoire ? " . ($old->areRandomTeams() ? "Oui" : "Non") . " -> " . ($new->areRandomTeams() ? "Oui" : "Non")
        );
    }
}