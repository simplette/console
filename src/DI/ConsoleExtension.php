<?php

namespace Simplette\Console\DI;

use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\Utils\Validators;
use Simplette\Console\ConsoleApplication;

/**
 * Class ConsoleExtension
 *
 * @package Simplette\Console
 */
class ConsoleExtension extends CompilerExtension
{
	/** @var array */
	public $defaults = [
		'application' => ConsoleApplication::class,
		'tag' => 'console.command',
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		Validators::assertField($config, 'application', 'string|' . Statement::class);
		Validators::assertField($config, 'tag', 'string');
	}

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$definition = $builder->addDefinition('console.application');
		Compiler::loadDefinition($definition, $this->config['application']);
		$definition->setAutowired(FALSE);

		foreach ($builder->findByTag($this->config['tag']) as $name => $allowed) {
			$definition->addSetup('add', ["@$name"]);
		}
	}

}
