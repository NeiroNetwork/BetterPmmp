<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\network\mcpe\protocol\TextPacket;
use pocketmine\player\Player;
use pocketmine\Server;

class VanillaLikeChat implements Listener, Module{

	public function isLoadable() : bool{
		return Server::getInstance()->getConfigGroup()->getPropertyBool("player.verify-xuid", true);
	}

	/**
	 * FIXME?: 優先度MONITORでイベントを変更してはいけないという原則を破ってる
	 *
	 * @priority MONITOR
	 */
	public function onPlayerChat(PlayerChatEvent $event) : void{
		$sender = $event->getPlayer();

		$packet = new TextPacket;
		$packet->type = TextPacket::TYPE_CHAT;
		$packet->sourceName = $sender->getDisplayName();
		$packet->message = $event->getMessage();
		$packet->xboxUserId = $sender->getXuid();

		$notPlayers = [];

		foreach($event->getRecipients() as $recipient){
			if($recipient instanceof Player){
				$recipient->getNetworkSession()->sendDataPacket($packet);
			}else{
				$notPlayers[] = $recipient;
			}
		}

		$event->setRecipients($notPlayers);
	}

	// TODO: /tell なども TextPacket::TYPE_WHISPER を使って送信する
}
