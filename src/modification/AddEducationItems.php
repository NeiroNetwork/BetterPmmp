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

		$hardenedGlassesKey = VanillaBlocks::TINTED_GLASS()->asItem();
		$hardenedGlasses = [VanillaBlocks::HARDENED_GLASS(), ...array_map(fn(DyeColor $color) => VanillaBlocks::STAINED_HARDENED_GLASS()->setColor($color), $colors)];
		$hardenedGlasses = array_map(fn(Block $block) => $block->asItem(), $hardenedGlasses);

		$hardenedGlassPanesKey = VanillaBlocks::STAINED_GLASS_PANE()->setColor(DyeColor::PINK())->asItem();
		$hardenedGlassPanes = [VanillaBlocks::HARDENED_GLASS_PANE(), ...array_map(fn(DyeColor $color) => VanillaBlocks::STAINED_HARDENED_GLASS_PANE()->setColor($color), $colors)];
		$hardenedGlassPanes = array_map(fn(Block $block) => $block->asItem(), $hardenedGlassPanes);

		$coloredTorchesKey = VanillaBlocks::SOUL_TORCH()->asItem();
		$coloredTorches = [VanillaBlocks::RED_TORCH(), VanillaBlocks::GREEN_TORCH(), VanillaBlocks::BLUE_TORCH(), VanillaBlocks::PURPLE_TORCH(), VanillaBlocks::UNDERWATER_TORCH()];
		$coloredTorches = array_map(fn(Block $block) => $block->asItem(), $coloredTorches);

		$underwaterTntKey = VanillaBlocks::TNT()->asItem();
		$underwaterTnt = [VanillaBlocks::TNT()->setWorksUnderwater(true)];

		$elementZeroItem = VanillaBlocks::ELEMENT_ZERO()->asItem();
		$remainingElementsCount = 0;
		$elementsKey = VanillaItems::SUSPICIOUS_STEW();
		$stringToItemParser = StringToItemParser::getInstance();
		$elements = array_map(fn(int $i) => $stringToItemParser->parse("element_$i"), range(0, 118));

		// ここからクリエイティブインベントリの再構築
		$creativeInventory = CreativeInventory::getInstance();
		$creativeContents = $creativeInventory->getAll();
		$creativeInventory->clear();

		foreach($creativeContents as $item){
			if($item->equals($elementZeroItem)){
				$remainingElementsCount = 118 + 1;
			}
			if($remainingElementsCount-- > 0){
				continue;
			}

			$creativeInventory->add($item);

			array_map(fn(Item $i) => $creativeInventory->add($i), match(true){
				$hardenedGlassesKey->equals($item) => $hardenedGlasses,
				$hardenedGlassPanesKey->equals($item) => $hardenedGlassPanes,
				$coloredTorchesKey->equals($item) => $coloredTorches,
				$underwaterTntKey->equals($item) => $underwaterTnt,
				$elementsKey->equals($item) => $elements,
				default => [],
			});
		}
	}
}
