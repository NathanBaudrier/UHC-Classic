<?php

namespace uhc\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
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

    private function sendScenariosForm(UPlayer $player) : void {
        $form = new SimpleForm(function (UPlayer $player, $data) {
            if($data === null) return;
            if(($scenario = Main::getGame()->getScenarios()->getById($data))->isEnabled()) {
                $scenario->disable();
                $this->sendScenariosForm($player);

            } else {
                $scenario->enable();
                $this->sendScenariosForm($player);
            }

            var_dump(Main::getGame()->getScenarios()->getSorted());
            /*var_dump(Main::getGame()->getScenarios()->getAll());
            var_dump(Main::getGame()->getScenarios()->getEnabled());*/
        });

        $form->setTitle(TextFormat::YELLOW . "Scénarios de la partie");
        $form->setContent("Choisissez un scénarios à activer/désactiver :");
        foreach (Main::getGame()->getScenarios()->getSorted() as $scenario) {
            $form->addButton(($scenario->isEnabled() ? TextFormat::GREEN : TextFormat::RED) . $scenario->getName(), -1, "", $scenario->getId());
        }

        $player->sendForm($form);
    }
}