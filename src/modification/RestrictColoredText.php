<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\block\utils\SignText;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\permission\DefaultPermissions;
use pocketmine\utils\TextFormat;

class RestrictColoredText extends ModuleBase{

	/**
	 * @priority LOWEST
	 */
	public function onPlayerChat(PlayerChatEvent $event) : void{
		$player = $event->getPlayer();
		if(!$player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
			$event->setMessage(TextFormat::clean($event->getMessage()));
		}
	}

	/**
	 * @priority LOWEST
	 */
	public function onSignChange(SignChangeEvent $event) : void{
		$player = $event->getPlayer();
		if(!$player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
			$newLines = array_map(fn($line) => TextFormat::clean($line), $event->getNewText()->getLines());
			$event->setNewText(new SignText($newLines));
		}
	}
}
