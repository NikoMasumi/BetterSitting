<?php
/**
 * Created by PhpStorm.
 * User: khoan
 * Date: 4/23/2016
 * Time: 9:48 PM
 */

namespace BetterSitting;


use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\network\protocol\AnimatePacket;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\updater\UpdateCheckTask;
use pocketmine\utils\TextFormat as Color;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\protocol\Info as ProtocolInfo;
use pocketmine\network\protocol\RemoveEntityPacket;
use pocketmine\network\protocol\SetEntityLinkPacket;
use pocketmine\network\protocol\PlayerActionPacket;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class BetterSitting extends PluginBase implements Listener{

    public $counter;
    public $count;

    public function onLoad()
    {
        $this->getLogger()->info(Color::LIGHT_PURPLE . "It has been a year, PocketMine, ImagicalMine,...");
        $this->getLogger()->info(Color::RED . "BetterSitting is preparing to be loaded in Himbeersaft's juicy bottle...");
        $this->getLogger()->info(Color::GOLD . "TESTING PLUGIN");
    }

    public function onEnable(){
        $svid = $this->getServer()->getIp();
        $this->getLogger()->info(Color::BLUE . "Connected to server " . Color::AQUA . $svid . Color::BLUE . ".");
        $this->getLogger()->info(Color::BLUE . "Commands, loggers! Loaded! Registering events...");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getLogger()->info(Color::BLUE . "Wow. That was fast. Now let's load for blocks. Custom blocks!");
        @mkdir($this->getDataFolder() . "blocks/");
        $this->getDataFolder();
        $this->getConfig()->getAll();

        $this->count = 10000;
        $this->getLogger()->warning(Color::RED . "WARNING! This plugin is still in development after a year inactivity. Any problems, please PM to the developer in " . Color::LIGHT_PURPLE . "ImagicalMine" . Color::RED . " for assistance, and we'll fix the problems ASAP. Thank you!");
        $this->getLogger()->info(Color::LIGHT_PURPLE . "Successfully loaded! Made by Niko (KhoaHoang), based on Seat Block by MineRourii.");
        $this->getLogger()->info(Color::GREEN . "'Best loading message ever' ~ Util");
    }

    #With some Ad5001 Support!
    ##Recieving Packets, begin! Woop.
    public function onPacketReceived(DataPacketReceiveEvent $event){
        $pk = $event->getPacket();
        switch($pk::NETWORK_ID){
            case ProtocolInfo::PLAYER_ACTION_PACKET;
                $player = $event->getPlayer();
                if(isset($this->counter[$player->getName()])){
                    if($pk->action === 8){$ppk = new SetEntityLinkPacket();
                        $ppk->from = $this->counter[$player->getName()];
                        $ppk->to = 0;$ppk->type = 0;
                        $player->dataPacket($ppk);
                        $pkc = new SetEntityLinkPacket();
                        $pkc->from = $this->counter[$player->getName()];
                        $pkc->to = $player->getId();$pkc->type = 0;
                        $ps=Server::getInstance()->getOnlinePlayers();
                        Server::getInstance()->broadcastPacket($ps,$pkc);
                        $pk0 = new RemoveEntityPacket();
                        $pk0->eid = $this->counter[$player->getName()];
                        $ps=Server::getInstance()->getOnlinePlayers();
                        Server::getInstance()->broadcastPacket($ps,$pk0);
                        unset($this->counter[$player->getName()]);
                    }
                }
        }
    }
    public function onTouch(PlayerInteractEvent $event)
    {
        if ($event->getBlock()->getId() === new Config($this->getDataFolder()."blocks/".strtolower($event->getBlock()->getId().".block").Config::YAML)) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }

        if ($event->getBlock()->getId() === 67) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }

        if ($event->getBlock()->getId() === 128) {
            $player = $event->getPlayer();
            if ($player->hasPermission("bettersit.op.sitonspecialblocks")) {
                $pk = new AddEntityPacket();
                $this->count = $this->count + 1;
                $pk->eid = $this->count;
                $pk->type = 84;
                $pk->x = $event->getBlock()->x + 0.6;
                $pk->y = $event->getBlock()->y + 0.6;
                $pk->z = $event->getBlock()->z + 0.5;
                $pk->speedX = 0;
                $pk->speedY = 0;
                $pk->speedZ = 0;
                $pk->yaw = $player->yaw;
                $pk->pitch = $player->pitch;
                $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                    Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
                $ps = Server::getInstance()->getOnlinePlayers();
                Server::getInstance()->broadcastPacket($ps, $pk);
                $ppk = new SetEntityLinkPacket();
                $ppk->from = $this->count;
                $ppk->to = 0;
                $ppk->type = 2;
                $player->dataPacket($ppk);
                $pkc = new SetEntityLinkPacket();
                $pkc->from = $this->count;
                $pkc->to = $player->getId();
                $pkc->type = 2;
                $ps = Server::getInstance()->getOnlinePlayers();
                Server::getInstance()->broadcastPacket($ps, $pkc);
                $this->counter[$player->getName()] = $this->count;
            }
        }

        if ($event->getBlock()->getId() === 114) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }

        if ($event->getBlock()->getId() === 44) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }

        if ($event->getBlock()->getId() === 45) {
            $player = $event->getPlayer();
            if ($player->hasPermission("bettersit.op.sitonspecialblocks")) {
                $pk = new AddEntityPacket();
                $this->count = $this->count + 1;
                $pk->eid = $this->count;
                $pk->type = 84;
                $pk->x = $event->getBlock()->x + 0.6;
                $pk->y = $event->getBlock()->y + 0.6;
                $pk->z = $event->getBlock()->z + 0.5;
                $pk->speedX = 0;
                $pk->speedY = 0;
                $pk->speedZ = 0;
                $pk->yaw = $player->yaw;
                $pk->pitch = $player->pitch;
                $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                    Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
                $ps = Server::getInstance()->getOnlinePlayers();
                Server::getInstance()->broadcastPacket($ps, $pk);
                $ppk = new SetEntityLinkPacket();
                $ppk->from = $this->count;
                $ppk->to = 0;
                $ppk->type = 2;
                $player->dataPacket($ppk);
                $pkc = new SetEntityLinkPacket();
                $pkc->from = $this->count;
                $pkc->to = $player->getId();
                $pkc->type = 2;
                $ps = Server::getInstance()->getOnlinePlayers();
                Server::getInstance()->broadcastPacket($ps, $pkc);
                $this->counter[$player->getName()] = $this->count;
            }
        }

        if ($event->getBlock()->getId() === 156) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }
        if ($event->getBlock()->getId() === 109) {
            $player = $event->getPlayer();
            $pk = new AddEntityPacket();
            $this->count = $this->count + 1;
            $pk->eid = $this->count;
            $pk->type = 84;
            $pk->x = $event->getBlock()->x + 0.6;
            $pk->y = $event->getBlock()->y + 0.6;
            $pk->z = $event->getBlock()->z + 0.5;
            $pk->speedX = 0;
            $pk->speedY = 0;
            $pk->speedZ = 0;
            $pk->yaw = $player->yaw;
            $pk->pitch = $player->pitch;
            $pk->metadata = [0 => [0, 1 << 5], 2 => [Entity::DATA_TYPE_STRING, ""],
                Entity::DATA_NAMETAG => [0, 1], 15 => [0, 1]];
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pk);
            $ppk = new SetEntityLinkPacket();
            $ppk->from = $this->count;
            $ppk->to = 0;
            $ppk->type = 2;
            $player->dataPacket($ppk);
            $pkc = new SetEntityLinkPacket();
            $pkc->from = $this->count;
            $pkc->to = $player->getId();
            $pkc->type = 2;
            $ps = Server::getInstance()->getOnlinePlayers();
            Server::getInstance()->broadcastPacket($ps, $pkc);
            $this->counter[$player->getName()] = $this->count;
        }
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args)
    {
        if(strtolower($command->getName()) == "bettersit"){
                if(isset($args[0])) {
                    if (strtolower($args[0]) == "list") {
                        $sender->sendMessage(Color::LIGHT_PURPLE . Color::BOLD . "You need a list? Here u go:");
                        $sender->sendMessage(Color::GREEN . "- Chairs:\n1.Oak Wood Stairs - Disabled\n2.Nether Stairs - For Everyone\n3.Sandstone Stairs - For OPs\n4.Stone Slab - For Everyone\n5.Brick Block - For OPs\n6.Quartz Stair - For Everyone\n7.Stone Brick Stair - For Everyone");
                    }elseif(strtolower($args[0]) == "help"){
                        if(!isset($args[1])) {
                            $sender->sendMessage(Color::GREEN . "BetterSitting - Type:\n/bettersit help howtosit - To see how to sit on a block\n/bettersit help info - To see the BetterSit plugin's information (for OPs only!)");
                        }elseif(strtolower($args[1]) == "howtosit"){
                            $sender->sendMessage(Color::GOLD . "To sit on a block(Type '/bettersit list' for a list of blocks you can sit on!), tap on a block and you will sit on it. That's easy!");
                        }elseif(strtolower($args[1]) == "info") {
                            $sender->sendMessage(Color::GOLD . "SOME CHEESY INFO:\n" . Color::GREEN . "Plugin BetterSitting made by Niko (KhoaHoang)\nVersion 1.1\nBased on " . Color::RED . "Seat Block " . Color::GREEN . "plugin made by MineRourii! :D" . Color::LIGHT_PURPLE . "\nPlugin uploaded on ImagicalMine Forums.\nAnd don't forget to check out my other pancake-plugins.");
                        }else{
                            $sender->sendMessage(Color::RED . "God Heavens, no! It should be /bettersit help <howtosit/info>");
                        }
                    }elseif(strtolower($args[0]) == "add") {
                        if($sender->hasPermission("bettersit.op") and $sender->isOp()) {
                            if (!isset($args[1])) {
                                $sender->sendMessage(Color::RED . "Wow. I cannot see which block would you like to add...");
                                $sender->sendMessage(Color::RED . "/bettersit add <blockid>"); //TODO: No idea to be honest.
                            }else{
                                $data = new Config($this->getDataFolder() . "blocks/" . strtolower(new Item($args[1]) . ".block"), Config::YAML);
                                $data->set(new Item($args[1]));
                                $data->save();
                            }
                        }else{
                            $sender->sendMessage(Color::RED . "Hey! It seems like you're not OP. This server has enough chairs, thank you very much.");
                        }
                    }else{
                        $sender->sendMessage(Color::RED . "This maybe handy: /bettersit <list/help/add/bottleofjuice>");
                    }
                }else{
                    $sender->sendMessage(Color::RED . "This maybe handy: /bettersit <list/help/add/bottleofjuice>");
                }
        }
    }
}
