<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\SetPlayerGameTypePacket;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

class DisableBreakingBySpectator implements Listener{

	/**
	 * @priority LOWEST
	 */
	public function onPacketSend(DataPacketSendEvent $event){
		$pks = $event->getPackets();
		$sessions = $event->getTargets();

		foreach($pks as $pk){
			if(!$pk instanceof SetPlayerGameTypePacket) continue;
			foreach($sessions as $session){
				$player = $session->getPlayer();
				if(!$player instanceof Player) continue;
				if($player->getGamemode() === GameMode::SPECTATOR()){
					$pk->gamemode = GameMode::SPECTATOR()->id();
				}
			}
		}
	}
}
