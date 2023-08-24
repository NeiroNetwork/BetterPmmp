<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerEmoteEvent;
use pocketmine\network\mcpe\protocol\EmotePacket;
use pocketmine\network\mcpe\protocol\TextPacket;
use pocketmine\player\Player;
use pocketmine\Server;

class VanillaLikeChat implements Listener, Module{

	public function isLoadable() : bool{
		return Server::getInstance()->getConfigGroup()->getPropertyBool("player.verify-xuid", true);
	}

	/**
	 * @priority HIGHEST
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


	/**
	 * @priority HIGHEST
	 */
	public function onPlayerEmote(PlayerEmoteEvent $event) : void{
		$event->cancel();

		$player = $event->getPlayer();
		$packet = EmotePacket::create($player->getId(), $event->getEmoteId(), $player->getXuid(), "", EmotePacket::FLAG_SERVER | EmotePacket::FLAG_MUTE_ANNOUNCEMENT);
		$recipients = array_map(fn(Player $player) => $player->getNetworkSession(), $player->getViewers());
		$player->getNetworkSession()->getBroadcaster()->broadcastPackets($recipients, [$packet]);
	}
}
