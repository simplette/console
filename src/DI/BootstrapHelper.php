<?php

namespace Simplette\Console\DI;

use Nette\Configurator;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * Class BootstrapHelper
 *
 * @package Simplette\Console\DI
 */
class BootstrapHelper
{
	/** @var array */
	private static $debugParam = [
		'--debug-mode=yes',
		'--debug-mode=on',
		'--debug-mode=true',
		'--debug-mode=1',
		'--debug',
	];

	/**
	 * @param Configurator $configurator
	 * @param callable $setupFunction
	 */
	public static function setupMode(Configurator $configurator, callable $setupFunction = NULL)
	{
		$argvInput = new ArgvInput();
		if (PHP_SAPI === 'cli' && $argvInput->hasParameterOption(self::$debugParam)) {
			$configurator->setDebugMode(TRUE);
		}
		elseif ($setupFunction !== NULL) {
			$setupFunction();
		}
	}

}
