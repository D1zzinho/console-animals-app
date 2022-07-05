<?php

namespace App;

use App\Console\ConsoleCommandStorage;
use Exception;

class Application
{
    private static Application    $instance;
    private ConsoleCommandStorage $consoleCommandStorage;

    private function __construct()
    {
        $this->consoleCommandStorage = ConsoleCommandStorage::getInstance();
    }

    private function __clone()
    {

    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception(get_class($this) . ' cannot be unserialized.');
    }

    public static function getInstance(): Application
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param  int   $argc
     * @param  array $argv
     *
     * @return void
     */
    public function bootstrap(int $argc, array $argv): void
    {
        $this->consoleCommandStorage->callCommand($argc, $argv);
    }
}
