<?php

namespace Simplette\ConsoleTests\DI;

use Mockery;
use Mockery\Mock;
use Nette\Configurator;
use PHPUnit\Framework\TestCase;
use Simplette\Console\DI\BootstrapHelper;

/**
 * Class BootstrapHelperTest
 *
 * @package Simplette\ConsoleTests\DI
 */
class BootstrapHelperTest extends TestCase
{

	public function useCases()
	{
		return [
			[['console', '--debug'], TRUE],
			[['console', '--debug-mode=yes'], TRUE],
			[['console', '--debug-mode=on'], TRUE],
			[['console', '--debug-mode=true'], TRUE],
			[['console', '--debug-mode=1'], TRUE],
			[['console', '--debug-mode=no'], FALSE],
			[['console', '--debug-mode=off'], FALSE],
			[['console', '--debug-mode=false'], FALSE],
			[['console', '--debug-mode=0'], FALSE],
			[['console'], FALSE],
		];
	}

	/**
	 * @dataProvider useCases
	 *
	 * @param array $argv
	 * @param bool $useDebugMode
	 */
	public function testSetupMode(array $argv, $useDebugMode)
	{
		$_SERVER['argv'] = $argv;
		/** @var Configurator|Mock $configurator */
		$configurator = Mockery::mock(Configurator::class);
		$configurator->shouldReceive('setDebugMode')
			->with($useDebugMode)
			->times($useDebugMode ? 1 : 0);

		$called = 0;
		BootstrapHelper::setupMode($configurator, function () use (&$called) {
			$called++;
		});
		self::assertEquals($useDebugMode ? 0 : 1, $called);
	}

	/**
	 * @dataProvider useCases
	 * @doesNotPerformAssertions
	 *
	 * @param array $argv
	 * @param bool $useDebugMode
	 */
	public function testSetupModeWithoutCallable(array $argv, $useDebugMode)
	{
		$_SERVER['argv'] = $argv;
		/** @var Configurator|Mock $configurator */
		$configurator = Mockery::mock(Configurator::class);
		$configurator->shouldReceive('setDebugMode')
			->with($useDebugMode)
			->times($useDebugMode ? 1 : 0);

		BootstrapHelper::setupMode($configurator);
	}

	protected function tearDown()
	{
		Mockery::close();
	}

}
