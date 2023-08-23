<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;

interface Module extends Listener{

	public function isLoadable() : bool;
}
