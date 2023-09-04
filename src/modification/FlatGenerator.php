<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\world\format\Chunk;
use pocketmine\world\format\SubChunk;
use pocketmine\world\generator\Flat;
use pocketmine\world\generator\FlatGeneratorOptions;
use pocketmine\world\World;
use ReflectionClass;

class FlatGenerator extends Flat{

	public function __construct(int $seed, string $preset){
		parent::__construct($seed, $preset);
	}

	protected function generateBaseChunk() : void{
		$parent = (new ReflectionClass($this))->getParentClass();
		/** @var FlatGeneratorOptions $options */
		$options = $parent->getProperty("options")->getValue($this);

		$chunk = new Chunk([], false);
		$parent->getProperty("chunk")->setValue($this, $chunk);

		$structure = $options->getStructure();
		$count = count($structure);
		for($sy = 0; $sy < $count; $sy += SubChunk::EDGE_LENGTH){
			$subChunk = $chunk->getSubChunk(($sy + World::Y_MIN) >> SubChunk::COORD_BIT_SIZE);
			for($y = 0; $y < SubChunk::EDGE_LENGTH && isset($structure[$y | $sy]); ++$y){
				$id = $structure[$y | $sy];
				for($z = 0; $z < SubChunk::EDGE_LENGTH; ++$z){
					for($x = 0; $x < SubChunk::EDGE_LENGTH; ++$x){
						$subChunk->setBlockStateId($x, $y, $z, $id);
					}
				}
			}
		}

		foreach($chunk->getSubChunks() as $y => $subChunk){
			$subChunk->getBiomeArray()->replaceAll(0, $options->getBiomeId());
		}
	}
}
