<?php

declare(strict_types=1);

namespace NeiroNetwork\BetterPmmp\modification;

use pocketmine\event\Listener;

abstract class ModuleBase implements Listener{

	final public function __construct(){
		// Do not use and override the constructor
	}

	public function onLoad() : void{
	}

	public function canEnable() : bool{
		return true;
	}

	/**
	 * ワールドが読み込まれ、このクラスをイベントリスナーとして登録した後に呼び出されます。
	 */
	public function onEnabled() : void{
	}
}
