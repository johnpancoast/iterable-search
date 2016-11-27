<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor;

use Pancoast\DataProcessor\Command\Command;
use Pancoast\DataProcessor\Command\CsvCommand;
use Symfony\Component\Console\Application;

/**
 * Console helper provides methods for console commands
 *
 * This provides helpers for you to either start a symfony/console application and/or load the available commands that
 * this lib provides.
 *
 * @see http://symfony.com/doc/current/components/console.html
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ConsoleHelper
{
    /**
     * Get commands this library provides
     *
     * @return Command[] An array of symfony/console commands.
     */
    public static function getCommands()
    {
        return [
            new CsvCommand(),
        ];
    }

    /**
     * Load available commands into an application and return it
     *
     * @param Application $consoleApp
     *
     * @return Application
     */
    public static function load(Application $consoleApp)
    {
        foreach (self::getCommands() as $command) {
            $consoleApp->add($command);
        }

        return $consoleApp;
    }

    /**
     * Create application and load available commands
     *
     * @return Application
     */
    public static function createAndLoad()
    {
        return self::load(self::create());
    }

    /**
     * Create application
     *
     * @return Application
     */
    public static function create()
    {
        return new Application();
    }
}
