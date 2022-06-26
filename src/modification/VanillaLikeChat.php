<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\network\mcpe\protocol\TextPacket;
use pocketmine\player\Player;
use pocketmine\Server;

class VanillaLikeChat implements Listener{

	private Server $server;
	private ConsoleCommandSender $console;

	public function __construct(){
		$this->server = Server::getInstance();
		$admins = $this->server->getBroadcastChannelSubscribers(Server::BROADCAST_CHANNEL_ADMINISTRATIVE);
		foreach($admins as $admin){
			if($admin instanceof ConsoleCommandSender){
				$this->console = $admin;
				break;
			}
		}
	}

	/**
	 * FIXME?: 優先度MONITORでイベントを変更してはいけないという原則を破ってる
	 * @priority MONITOR
	 */
	public function onPlayerChat(PlayerChatEvent $event) : void{
		$packet = new TextPacket;
		$packet->type = TextPacket::TYPE_CHAT;
		$packet->sourceName = $event->getPlayer()->getDisplayName();
		$packet->message = $event->getMessage();

		foreach($event->getRecipients() as $recipient){
			if($recipient instanceof Player){
				$recipient->getNetworkSession()->sendDataPacket($packet);
			}
		}

		$event->setRecipients([$this->console]);
	}

	// TODO: /tell なども TextPacket::TYPE_WHISPER を使って送信する
}
