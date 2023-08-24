<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\block\VanillaBlocks;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\player\Player;
use pocketmine\Server;

class FixGhostWater implements Module{

	public function isLoadable() : bool{
		return is_null(Server::getInstance()->getPluginManager()->getPlugin("WaterLogging"));
	}

	/**
	 * @priority MONITOR
	 */
	public function onPlayerInteract(PlayerInteractEvent $event) : void{
		$player = $event->getPlayer();
		$blockClicked = $event->getBlock();
		$blockReplace = $blockClicked->getSide($event->getFace());

		$this->removeWaterFrom($player, $blockClicked->getPosition());
		$this->removeWaterFrom($player, $blockReplace->getPosition());
	}

	private function removeWaterFrom(Player $player, Vector3 $position) : void{
		$packet = UpdateBlockPacket::create(
			BlockPosition::fromVector3($position),
			TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId(VanillaBlocks::AIR()->getStateId()),
			UpdateBlockPacket::FLAG_NETWORK,
			UpdateBlockPacket::DATA_LAYER_LIQUID
		);
		$player->getNetworkSession()->sendDataPacket($packet);
	}
}
