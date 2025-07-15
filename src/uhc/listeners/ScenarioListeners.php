<?php

namespace uhc\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Event;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerItemEnchantEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerMoveEvent;
use uhc\listeners\custom\NewDamageCycleEvent;
use uhc\listeners\custom\UPlayerDeathEvent;
use uhc\Main;

class ScenarioListeners implements Listener {

    private Main $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onCraft(CraftItemEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onHeldItem(PlayerItemHeldEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onBreak(BlockBreakEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onDeath(UPlayerDeathEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onShoot(EntityShootBowEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onEnchant(PlayerItemEnchantEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onDamage(EntityDamageEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onDamageCycle(NewDamageCycleEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onPlace(BlockPlaceEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onConsume(PlayerItemConsumeEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    public function onMove(PlayerMoveEvent $event) : void {
        $this->handleScenarioEvents($event);
    }

    private function handleScenarioEvents(Event $event) : void {
        if(!($game = $this->main->getGame())->hasStarted()) return;

        foreach($game->getScenarios()->getAll() as $scenario) {
            if($scenario->isEnabled()) $scenario->onEvent($event);
        }
    }
}