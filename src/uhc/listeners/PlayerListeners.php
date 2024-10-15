<?php

namespace uhc\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;
use uhc\game\Game;
use uhc\game\scenarios\ScenarioIds;
use uhc\libs\scoreboard\Scoreboard;
use uhc\listeners\custom\PvpEnabledEvent;
use uhc\listeners\custom\UPlayerDeathEvent;
use uhc\UPlayer;

class PlayerListeners implements Listener {

    private Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function onJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {

            if(!$this->game->hasStarted()) {
                $scoreboard = new Scoreboard("UHC Classic", "welcome_scoreboard");
                $this->game->addPlayer($player);
                /*$player->isHost() ||*/ $player->getServer()->isOp($player->getName()) ? $player->sendHostInventory() : $player->sendGuessInventory();

                $scoreboard->addLine(0, "+---------+");
                $scoreboard->addLine(1, "Online : " . count($player->getServer()->getOnlinePlayers()) . "/" . $player->getServer()->getMaxPlayers());
                $scoreboard->addLine(2, "Host : "/* . $this->game->getHost()*/);
                $scoreboard->addLine(3, "-----------");
            } else {
                $scoreboard = new Scoreboard("UHC Classic", "game_scoreboard");
                $scoreboard->addLine(0, "+--------------+");
                $scoreboard->addLine(1, "Timer : " . $this->game->getDuration()->getFormat());
                $scoreboard->addLine(2, "Border : ");
                $scoreboard->addLine(3, "Pvp : " /*TODO*/ );
                if($this->game->getTeams()->areEnabled()) $scoreboard->addLine(4, "Team : " . $player->getTeam()->getName());
                $scoreboard->addLine(5, "----------------");
                var_dump("test");
            }

            $player->setScoreboard($scoreboard);
            $player->sendScoreboard();
        }
    }



    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {
            if(!$this->game->hasStarted() && $this->game->isInGame($player)) {
                $this->game->removePlayer($player);
            }
        }
    }

    public function onTransit(InventoryTransactionEvent $event) : void {
        $player = $event->getTransaction()->getSource();

        if($player instanceof UPlayer) {
            if(!$this->game->hasStarted() /* && !$player->isHost()*/ && $player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {
            if(!$this->game->hasStarted() /* && !$player->isHost()*/ && $player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onDamage(EntityDamageEvent $event) : void {
        $player = $event->getEntity();

        if($player instanceof UPlayer) {
            if(!$this->game->hasStarted() /* && !$player->isHost()*/ && $player->isOp()) {
                $event->cancel();
            }
        }

        if($event->getFinalDamage() >= $player->getHealth()) {
            if($event instanceof EntityDamageByEntityEvent) {
                $killer = $event->getDamager();
                if($killer instanceof UPlayer) {
                    $ev = new UPlayerDeathEvent($player, $killer);
                } else {
                    $ev = new UPlayerDeathEvent($player);
                }

                $ev->call();
            }

            $event->cancel();
        }
    }

    public function onInteract(PlayerInteractEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {
            if(!$this->game->hasStarted() /* && !$player->isHost()*/ && $player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onPvp(PvpEnabledEvent $event) : void {
        Server::getInstance()->broadcastMessage("The pvp is now enabled !");

        if($this->game->getScenarios()->getById(ScenarioIds::FINAL_HEAL_ID)->isEnabled()) {
            Server::getInstance()->broadcastMessage("+ Final Heal");
            foreach($this->game->getPlayers() as $player) {
                $player->setHealth($player->getMaxHealth());
            }
        }
    }

    public function onCreation(PlayerCreationEvent $event) : void {
        $event->setPlayerClass(UPlayer::class);
    }
}