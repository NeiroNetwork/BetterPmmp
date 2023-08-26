<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\block\Block;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;

class AddEducationItems extends ModuleBase{

	public function onEnabled() : void{
		$colors = [DyeColor::WHITE(), DyeColor::LIGHT_GRAY(), DyeColor::GRAY(), DyeColor::BLACK(), DyeColor::BROWN(), DyeColor::RED(), DyeColor::ORANGE(), DyeColor::YELLOW(), DyeColor::LIME(), DyeColor::GREEN(), DyeColor::CYAN(), DyeColor::LIGHT_BLUE(), DyeColor::BLUE(), DyeColor::PURPLE(), DyeColor::MAGENTA(), DyeColor::PINK()];
		$toItems = fn(array $blocks) => array_map(fn(Block $block) => $block->asItem(), $blocks);

		$insertItems = [
			VanillaBlocks::TINTED_GLASS()->asItem()->getStateId() => $toItems([VanillaBlocks::HARDENED_GLASS(), ...array_map(fn(DyeColor $color) => VanillaBlocks::STAINED_HARDENED_GLASS()->setColor($color), $colors)]),
			VanillaBlocks::STAINED_GLASS_PANE()->setColor(DyeColor::PINK())->asItem()->getStateId() => $toItems([VanillaBlocks::HARDENED_GLASS_PANE(), ...array_map(fn(DyeColor $color) => VanillaBlocks::STAINED_HARDENED_GLASS_PANE()->setColor($color), $colors)]),
			VanillaBlocks::SOUL_TORCH()->asItem()->getStateId() => $toItems([VanillaBlocks::RED_TORCH(), VanillaBlocks::GREEN_TORCH(), VanillaBlocks::BLUE_TORCH(), VanillaBlocks::PURPLE_TORCH(), VanillaBlocks::UNDERWATER_TORCH()]),
			VanillaBlocks::TNT()->asItem()->getStateId() => [VanillaBlocks::TNT()->setWorksUnderwater(true)->asItem()],
			VanillaItems::SUSPICIOUS_STEW()->getStateId() => array_map(fn(int $i) => StringToItemParser::getInstance()->parse("element_$i"), range(0, 118)),
		];

		$creativeInventory = CreativeInventory::getInstance();
		$creativeContents = $creativeInventory->getAll();
		$creativeInventory->clear();

		$elementZeroItem = VanillaBlocks::ELEMENT_ZERO()->asItem();
		$remainingElementsCount = 0;

		foreach($creativeContents as $item){
			if($item->equals($elementZeroItem)){
				$remainingElementsCount = 118 + 1;
			}
			if($remainingElementsCount-- > 0){
				continue;
			}

			$creativeInventory->add($item);
			array_map(fn(Item $i) => $creativeInventory->add($i), $insertItems[$item->getStateId()] ?? []);
		}
	}
}
