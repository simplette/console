<?php

namespace Simplette\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ConsoleApplication
 *
 * @package Simplette\Console
 */
class ConsoleApplication extends Application
{

	/**
	 * @inheritdoc
	 */
	protected function getDefaultInputDefinition()
	{
		$definition = parent::getDefaultInputDefinition();
		$definition->addOption(new InputOption('--debug', NULL, InputOption::VALUE_NONE, 'Enable debug mode in console'));

		return $definition;
	}

}
