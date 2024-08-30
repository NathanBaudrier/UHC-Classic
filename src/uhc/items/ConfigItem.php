<?php

namespace uhc\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class ConfigItem extends Item {

    public function __construct() {
        parent::__construct(new ItemIdentifier(ItemTypeIds::NETHER_STAR), "Config");
    }

    public function getCustomName() : string {
        return "Config";
    }

    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult {
        return parent::onClickAir($player, $directionVector, $returnedItems);
    }
}