<?php

namespace uhc\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use uhc\game\scenarios\ScenarioIds;
use uhc\libs\form\CustomForm;
use uhc\libs\form\SimpleForm;
use uhc\Main;
use uhc\UPlayer;

class ConfigItem extends Item {

    public function __construct() {
        parent::__construct(new ItemIdentifier(ItemTypeIds::NETHER_STAR), "Config");
    }

    public function getCustomName() : string {
        return "Config";
    }

    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult {
        if($player instanceof UPlayer /* && $player->isHost()*/ && !Main::getGame()->hasStarted()) {
            $this->sendMenuConfigForm($player);
            return ItemUseResult::SUCCESS;
        }

        return ItemUseResult::NONE;
    }

    private function sendMenuConfigForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if ($data === null) return;
            switch ($data) {
                case 0:
                    $this->sendMenuConfigForm($player);
                    break;
                case 1:
                    $this->sendScenariosForm($player);
                    break;
            }
        });

        $form->setTitle(TextFormat::YELLOW . "Configuration de la partie");
        $form->setContent("Choisissez une option à configurer :");
        $form->addButton("Paramètres");
        $form->addButton("Scénarios");
        $form->addButton("Résumé");
        $form->addButton(TextFormat::RED . "Quit");

        $player->sendForm($form);
    }

    private function sendSettingsForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if($data === null) return;
        });

        $form->setTitle(TextFormat::YELLOW . "Paramètres de la partie");
        $form->setContent(TextFormat::YELLOW . "Choisissez un paramètres à configurer :");
        $form->addButton("Bordure");
        $form->addButton("Equipes");
        $form->addButton("Limites");

        $player->sendForm($form);
    }

    private function sendTeamsForm(UPlayer $player) : void {
        $form = new CustomForm(function (UPlayer $player, $data) {
            if($data === null) {
                $this->sendSettingsForm($player);
                return;
            }


        });

        $form->setTitle("Paramètre des équipes Equipes");
    }

    private function sendScenariosForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if($data === null) return;

            $scenario = Main::getGame()->getScenarios()->getById($data);

            if($scenario->getId() == ScenarioIds::ASSAULT_AND_BATTERY_ID) {
                $player->sendMessage("Ce scénario ne peut être activé que si des équipes de 2 uniquement sont activées.");
                return;
            }

            $scenario->isEnabled() ? $scenario->disable() : $scenario->enable();

            $this->sendMenuConfigForm($player);
        });

        $form->setTitle(TextFormat::YELLOW . "Scénarios de la partie");
        $form->setContent("Choisissez un scénarios à activer/désactiver :");
        foreach (Main::getGame()->getScenarios()->getSorted() as $scenario) {
            $form->addButton(($scenario->isEnabled() ? TextFormat::GREEN : TextFormat::RED) . $scenario->getName(), -1, "", $scenario->getId());
        }

        $player->sendForm($form);
    }


}