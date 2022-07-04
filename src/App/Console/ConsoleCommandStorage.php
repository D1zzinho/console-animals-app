<?php

namespace App\Console;

use App\Controllers\Controller;

class ConsoleCommandStorage
{
    const COMMANDS_CONFIG = __DIR__ . '../../config/commands.php';

    /**
     * @var array<string, Controller>
     */
    private array $controllers = [];

    /**
     * @var array<string, callable>
     */
    private array $anonymousCommands = [];

    public function __construct()
    {
        $this->registerConfigCommands();
    }

    /**
     * @param  string     $name
     * @param  Controller $controller
     *
     * @return void
     */
    public function addController(string $name, Controller $controller): void
    {
        $this->controllers[$name] = $controller;
    }

    /**
     * @param  array<string, Controller> $controllers
     *
     * @return void
     */
    public function addControllers(array $controllers): void
    {
        $this->controllers = array_merge($this->controllers, $controllers);
    }

    /**
     * @param  string   $name
     * @param  callable $callback
     *
     * @return void
     */
    public function addAnonymousCommand(string $name, callable $callback): void
    {
        $this->anonymousCommands[$name] = $callback;
    }

    /**
     * @param  array<string, callable> $commands
     *
     * @return void
     */
    public function addAnonymousCommands(array $commands): void
    {
        $this->anonymousCommands = array_merge($this->anonymousCommands, $commands);
    }

    /**
     * @return void
     */
    private function registerConfigCommands(): void
    {
        $config = require self::COMMANDS_CONFIG;

        $this->addControllers($config['controllers']);
        $this->addAnonymousCommands($config['anonymous']);
    }
}
