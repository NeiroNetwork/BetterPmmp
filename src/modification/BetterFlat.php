<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use InvalidArgumentException;
use pocketmine\world\generator\GeneratorManager;
use ReflectionClass;

class BetterFlat extends ModuleBase{

	public function onLoad() : void{
		$this->overwriteGenerator("flat", FlatGenerator::class);
	}

	private function overwriteGenerator(string $name, string $class) : void{
		$generatorManager = GeneratorManager::getInstance();
		$entry = $generatorManager->getGenerator($name) ?? throw new InvalidArgumentException("Unknown generator: $name");
		$validator = (new ReflectionClass($entry))->getProperty("presetValidator")->getValue($entry);
		$generatorManager->addGenerator($class, $name, $validator, true);
	}
}
