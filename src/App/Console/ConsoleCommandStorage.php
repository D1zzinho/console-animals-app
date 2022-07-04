<?php

namespace App\Console;

use App\Controllers\Controller;
use App\Exceptions\CommandNotFoundException;
use Exception;

class ConsoleCommandStorage
{
    const COMMANDS_CONFIG_PATH = __DIR__ . '/../../config/commands.php';
    private static ConsoleCommandStorage $instance;

    /**
     * @var array<string, Controller>
     */
    private array $controllers = [];

    /**
     * @var array<string, callable>
     */
    private array $anonymousCommands = [];

    private function __construct()
    {
        $this->registerConfigCommands();
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

    /**
     * @return ConsoleCommandStorage
     */
    public static function getInstance(): ConsoleCommandStorage
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
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
     * @param  string $command
     *
     * @return Controller|null
     */
    private function getController(string $command): ?Controller
    {
        return new $this->controllers[$command] ?? null;
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
     * @param  string $command
     *
     * @return callable|null
     */
    private function getAnonymousCommand(string $command): ?callable
    {
        return $this->anonymousCommands[$command] ?? null;
    }

    /**
     * @param  string $command
     *
     * @return array|string
     * @throws CommandNotFoundException
     */
    public function getCommandCallback(string $command): array|string
    {
        $controller = $this->getController($command);
        if ($controller instanceof Controller) {
            return [
                $controller,
                'handle'
            ];
        }

        $anonymous = $this->getAnonymousCommand($command);
        if ($anonymous === null) {
            throw new CommandNotFoundException("Command \"$command\" not found. Type help for more info.");
        }

        return $command;
    }

    /**
     * @return void
     */
    private function registerConfigCommands(): void
    {
        $config = require self::COMMANDS_CONFIG_PATH;

        $this->addControllers($config['controllers']);
        $this->addAnonymousCommands($config['anonymous']);
    }
}
