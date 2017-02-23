Simplette / Console
===================

[Symfony Console][1] is probably the most common console component for PHP language.
Thank to this library, you can simply use it in [Nette Framework][2] with composer command.

This library was inspired by [Symfony Console][1] implementation by [Kbyby][3] and [Joseki][4].


Requirements
------------
This library requires PHP 5.6 or higher. [Simplette Console][5] library is designed
for [Nette Framework][2] version 2.4 and higher.


Installation
------------
The best way to install this library is using [Composer](http://getcomposer.org/):

```sh
$ composer require simplette/console
```


Documentation
-------------
Firstly, register extension `Simplette\Console\DI\ConsoleExtension`. For more information
about configuration see the class definition. This library is meant to be simply as possible.
However, some features would be added in the future, so [stay tuned][4].

```yaml
extension:
    console: Simplette\Console\DI\ConsoleExtension
```

This console implementation support also `debugMode` and correct setting of it. For this
support, you have to call `Simplette\Console\DI\BootstrapHelper::setupMode` in your
`app/bootstrap.php`.

Callable is used for the web environment setting. In the console commands, the mode is
set by checking of the `--debug` parameter. For compatibility, there is defined more
parameters that can turn on debug mode.

```php
<?php

use Simplette\Console\DI\BootstrapHelper;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

BootstrapHelper::setupMode($configurator, function () use ($configurator) {
//  $configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
});
$configurator->enableTracy(__DIR__ . '/../log');
```

Do not forget to call `$configurator->enableTracy()` after `setupMode`. This will resolve
all your problems with logging.

Console commands can be defined as is described in [documentation][7]. Every command has
to be registered in your di services and identified by tag `console.command`.

```yaml
services:
	- class: App\Commands\TestCommand
	  tags: [console.command]
```

Name of the tag can be configured in extension. And you can even define your own console
application:

```yaml
console:
	application: App\Console\MyAwesomeConsoleApplication
	tag: mycommand
```


Best Practices
--------------
Command definition in services can be really annoying. You can simplify this step using
Nette Decorator, for more information read [this awesome article][8]. For simplifying
commands definition use this:

```yaml
decorator:
	Symfony\Component\Console\Command\Command:
		tags: [console.command]
		inject: yes

services:
	- App\Commands\MyCommand
```

[Simplette Console][5] has also implemented `bin` command for `composer`. So for run your
console command, you can simply type:

```bash
$ composer exec console mycommad
```


Contributing
------------

This is an open source, community-driven project. If you would like to contribute, please follow 
the code format as used in current sources and submit a pull request.


-----

Advanced documentation will be added in the future. But if you look on my source codes, you will understand what you 
can do with this small (but powerful) library.

See also [other libraries][9] and some [older work][10] if you are looking for inspiration.


[1]: https://github.com/symfony/console
[2]: https://github.com/nette/nette
[3]: https://github.com/kdyby/console
[4]: https://github.com/joseki/console
[5]: https://github.com/simplette/console
[6]: https://github.com/simplette/console/stargazers
[7]: http://symfony.com/doc/current/components/console.html
[8]: https://www.tomasvotruba.cz/blog/2016/12/24/how-to-avoid-inject-thanks-to-decorator-feature-in-nette/
[9]: https://github.com/simplette
[10]: https://github.com/sw2eu
