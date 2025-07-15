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
use pocketmine\utils\TextFormat;
use uhc\game\scenarios\ScenarioIds;
use uhc\libs\scoreboard\Scoreboard;
use uhc\listeners\custom\PvpEnabledEvent;
use uhc\listeners\custom\UPlayerDeathEvent;
use uhc\Main;
use uhc\UPlayer;

class PlayerListeners implements Listener {

    private Main $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $game = $this->main->getGame();

        if($player instanceof UPlayer) {

            if(!$game->hasStarted()) {
                $scoreboard = new Scoreboard("UHC Classic", "welcome_scoreboard");
                $game->addPlayer($player);
                /*$player->isHost() ||*/ $player->getServer()->isOp($player->getName()) ? $player->sendHostInventory() : $player->sendGuessInventory();

                $scoreboard->addLine(0, "+---------+");
                $scoreboard->addLine(1, "Online : " . count($player->getServer()->getOnlinePlayers()) . "/" . $player->getServer()->getMaxPlayers());
                $scoreboard->addLine(2, "Host : "/* . $this->game->getHost()*/);
                $scoreboard->addLine(3, "-----------");

                $player->teleport(Main::getInstance()->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            } else {
                if($game->isInGame($player)) {
                    $player->reconnectToGame();

                    if($game->getScenarios()->getById($game->getScenarios()::ANONYMOUS_ID)->isEnabled()) {
                        $player->setDisplayName(TextFormat::OBFUSCATED . "MONKEY");
                        //$player->setSkin(); TODO
                    }
                } else {
                    //Spec
                }

                $scoreboard = new Scoreboard("UHC Classic", "game_scoreboard");
                $scoreboard->addLine(0, "+--------------+");
                $scoreboard->addLine(1, "Timer : " . $game->getDuration()->getFormat());
                $scoreboard->addLine(2, "BorderSettings : ");
                $scoreboard->addLine(3, "Pvp : " /*TODO*/);
                //if($this->game->getTeams()->areEnabled()) $scoreboard->addLine(4, "Team : " . $player->getTeam()->getName());
                $scoreboard->addLine(5, "----------------");
            }

            $player->setScoreboard($scoreboard);
            $player->sendScoreboard();
        }
    }



    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
        $game = $this->main->getGame();

        if($player instanceof UPlayer) {
            if($game->hasStarted()) {
                $player->disconnectFromGame();
            } else {
                $game->removePlayer($player);
            }
        }
    }

    public function onTransit(InventoryTransactionEvent $event) : void {
        $player = $event->getTransaction()->getSource();

        if($player instanceof UPlayer) {
            if(!$this->main->getGame()->hasStarted() /* && !$player->isHost()*/ && !$player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();

        if($player instanceof UPlayer) {
            if(!$this->main->getGame()->hasStarted() /* && !$player->isHost()*/ && !$player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onDamage(EntityDamageEvent $event) : void {
        $player = $event->getEntity();

        if($player instanceof UPlayer) {
            if(!$this->main->getGame()->hasStarted() /* && !$player->isHost()*/ && !$player->isOp()) {
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
            if(!$this->main->getGame()->hasStarted() /* && !$player->isHost()*/ && !$player->isOp()) {
                $event->cancel();
            }
        }
    }

    public function onPvp(PvpEnabledEvent $event) : void {
        $this->main->getServer()->broadcastMessage("The pvp is now enabled !");

        $game = $this->main->getGame();
        if($game->getScenarios()->getById(ScenarioIds::FINAL_HEAL_ID)->isEnabled()) {
            Server::getInstance()->broadcastMessage("+ Final Heal");
            foreach($game->getPlayers() as $player) {
                $player->setHealth($player->getMaxHealth());
            }
        }
    }

    public function onCreation(PlayerCreationEvent $event) : void {
        $event->setPlayerClass(UPlayer::class);
    }
}