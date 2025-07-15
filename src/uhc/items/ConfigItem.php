<?php

namespace uhc\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use uhc\game\Game;
use uhc\game\settings\BorderSettings;
use uhc\game\settings\TeamSettings;
use uhc\libs\form\CustomForm;
use uhc\libs\form\SimpleForm;
use uhc\Main;
use uhc\UPlayer;

class ConfigItem extends Item {

    private Game $game;

    public function __construct() {
        parent::__construct(new ItemIdentifier(ItemTypeIds::NETHER_STAR), "Config");

        $this->game = Main::getInstance()->getGame();

        $this->setCustomName("Config");
        $this->setLore(["UI to config the game."]);

    }

    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult {
        if($player instanceof UPlayer /* && $player->isHost()*/ && !$this->game->hasStarted()) {
            $this->sendMenuConfigForm($player);
            return ItemUseResult::SUCCESS;
        }

        return ItemUseResult::NONE;
    }

    private function sendMenuConfigForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if(!isset($data)) return;

            switch ($data) {
                case 0:
                    $this->sendSettingsForm($player);
                    break;
                case 1:
                    $this->sendScenariosForm($player);
                    break;
                case 2:
                    break;
                case 3:
                    $this->game->start();
                    break;
            }
        });

        $form->setTitle(TextFormat::YELLOW . "Configuration de la partie");
        $form->setContent("Choisissez une option à configurer :");
        $form->addButton("Paramètres");
        $form->addButton("Scénarios");
        $form->addButton("Résumé");
        $form->addButton( TextFormat::GREEN . "Start");
        $form->addButton(TextFormat::RED . "Quit");

        $player->sendForm($form);
    }

    private function sendSettingsForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if(!isset($data)) {
                $this->sendMenuConfigForm($player);
                return;
            }

            switch($data) {
                case 0:
                    $this->sendBorderSettingsForm($player);
                    break;

                case 1:
                    $this->game->getTeams()->getSettings()->areEnabled() ? $this->sendTeamSettingsForm($player) : $this->sendEnabledTeamsForm($player);
                    break;
            }
        });

        $form->setTitle(TextFormat::YELLOW . "Paramètres de la partie");
        $form->setContent(TextFormat::YELLOW . "Choisissez un paramètres à configurer :");
        $form->addButton("Bordure");
        $form->addButton("Equipes");

        $player->sendForm($form);
    }

    private function sendEnabledTeamsForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if(!isset($data) || $data == 1) {
                $this->sendSettingsForm($player);
                return;
            }

            $settings = $this->game->getTeams()->getSettings();
            $this->game->getTeams()->changeSettings(new TeamSettings(true, $settings->getNumberOfEnabledTeams(), $settings->getMaxPlayersPerTeam(), $settings->areRandomTeams()));

            $this->sendTeamSettingsForm($player);
        });

        $form->setTitle("Paramètres des équipes");
        $form->setContent("Voulez-vous activer les équipes ?");
        $form->addButton("Oui");
        $form->addButton("Non");

        $player->sendForm($form);
    }

    private function sendBorderSettingsForm(UPlayer $player) : void {
        $form = new CustomForm(function (UPlayer $player, $data) {
            if(!isset($data)) {
                $this->sendSettingsForm($player);
                return;
            }

            if($data[0] > $data[1]) {
                $player->sendMessage(TextFormat::RED . "La taille initiale doit être inférieure à la taille finale.");
                return;
            }

            $this->game->getBorder()->changeSettings(new BorderSettings($data[0], $data[1], $data[2]));
        });

        $form->setTitle(TextFormat::YELLOW . "Paramètres de la bordure");

        $settings = $this->game->getBorder()->getSettings();
        $form->addSlider("Taille initiale : ", 500, 3000, -1, $settings->getInitialSize());
        $form->addSlider("Taille finale : ", 1000, 5000, -1, $settings->getFinalSize());
        $form->addSlider("Vitesse : ", 20, 50, -1, $settings->getSpeed());

        $player->sendForm($form);
    }

    private function sendTeamSettingsForm(UPlayer $player) : void {
        $form = new CustomForm(function (UPlayer $player, $data) {
            if(!isset($data)) {
                $this->sendSettingsForm($player);
                return;
            }


            if($data[1] * $data[2] < Main::getInstance()->getServer()->getMaxPlayers()) {
                $player->sendMessage(TextFormat::RED . "Il n'y a pas assez de capacité pour tous les joueurs si la partie est totalement occupée.");
                return;
            }

            $this->game->getTeams()->changeSettings(new TeamSettings(!$data[0], $data[1], $data[2], $data[3]));

        });

        $form->setTitle(TextFormat::YELLOW . "Paramètres des équipes");

        $settings = $this->game->getTeams()->getSettings();
        $form->addToggle("Disable teams", !$settings->areEnabled());
        $form->addSlider("Nombre d'équipes : ", $settings::MIN_TEAMS, $settings::MAX_TEAMS, -1, $settings->getNumberOfEnabledTeams());
        $form->addSlider("Nombre de joueurs par équipe : ", $settings::MIN_PLAYERS, $settings::MAX_PLAYERS, -1, $settings->getMaxPlayersPerTeam());
        $form->addToggle("Aléatoire ? ", $this->game->getTeams()->getSettings()->areRandomTeams());

        $player->sendForm($form);
    }

    private function sendScenariosForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if($data === null) return;

            $scenario = $this->game->getScenarios()->getById($data);

            if($scenario->getId() == $scenario::ASSAULT_AND_BATTERY_ID) {
                $player->sendMessage("Ce scénario ne peut être activé que si des équipes de 2 uniquement sont activées.");
                return;
            }

            $scenario->isEnabled() ? $scenario->disable() : $scenario->enable();

            $this->sendScenariosForm($player);
        });

        $form->setTitle(TextFormat::YELLOW . "Scénarios de la partie");
        $form->setContent("Choisissez un scénarios à activer/désactiver :");
        foreach ($this->game->getScenarios()->getSorted() as $scenario) {
            $form->addButton(($scenario->isEnabled() ? TextFormat::GREEN : TextFormat::RED) . $scenario->getName(), -1, "", $scenario->getId());
        }

        $player->sendForm($form);
    }


}