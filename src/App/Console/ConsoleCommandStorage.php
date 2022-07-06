<?php

namespace App\Console;

use App\Controllers\Controller;
use App\Exceptions\CommandNotFoundException;
use App\Exceptions\NoArgumentsProvidedException;
use App\Exceptions\WrongDogActionException;
use App\Models\Dog;
use Exception;
use Throwable;

class ConsoleCommandStorage
{
    const COMMANDS_CONFIG_PATH = __DIR__ . '/../../config/commands.php';

    private static ConsoleCommandStorage $instance;

    /**
     * @var array<string, Dog>
     */
    private array $dogs = [];

    /**
     * @var array<string, Controller>
     */
    private array $controllers = [];

    /**
     * @var array<string, Controller>
     */
    private array $otherCommandsControllers = [];

    /**
     * @var array<string, callable>
     */
    private array $anonymousCommands = [];

    private Formatter $formatter;

    private function __construct()
    {
        $this->formatter = Formatter::getInstance();
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
     * @param  string $name
     * @param  Dog    $dog
     *
     * @return void
     */
    public function addDog(string $name, Dog $dog): void
    {
        $this->dogs[$name] = $dog;
    }

    /**
     * @param  array<string, Dog> $dogs
     *
     * @return void
     */
    public function addDogs(array $dogs): void
    {
        $this->dogs = array_merge($this->dogs, $dogs);
    }

    /**
     * @param  string $command
     *
     * @return Dog|null
     */
    private function getDog(string $command): ?Dog
    {
        return isset($this->dogs[$command]) ? new $this->dogs[$command] : null;
    }

    /**
     * @return array
     */
    public function getDogs(): array
    {
        return $this->dogs;
    }

    /**
     * @param  string     $name
     * @param  Controller $controller
     * @param  array      $availableParams
     *
     * @return void
     */
    public function addController(string $name, Controller $controller, array $availableParams = []): void
    {
        $this->controllers[$name] = [
            'class'            => $controller,
            'available_params' => $availableParams
        ];
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
        return isset($this->controllers[$command]['class']) ? new $this->controllers[$command]['class'] : null;
    }

    /**
     * @param  array<string, Controller> $controllers
     *
     * @return void
     */
    public function addOtherCommandControllers(array $controllers): void
    {
        $this->otherCommandsControllers = array_merge($this->otherCommandsControllers, $controllers);
    }

    /**
     * @param  string $command
     *
     * @return Controller|null
     */
    private function getOtherCommandController(string $command): ?Controller
    {
        return isset($this->otherCommandsControllers[$command]) ? new $this->otherCommandsControllers[$command] : null;
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
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
     * @param  int   $argc
     * @param  array $argv
     *
     * @return void
     */
    public function callCommand(int $argc, array $argv): void
    {
        try {
            if ($argc < 2) {
                throw new NoArgumentsProvidedException('No arguments provided! Type help for more info.');
            }

            $request = new CommandRequest($argv);

            $dog = $this->getDog($request->command);
            if (!is_null($dog)) {
                $this->callDogAction($request, $dog);
            }

            $otherController = $this->getOtherCommandController($request->command);
            if (!is_null($otherController)) {
                $otherController->run($request);
                exit;
            }

            call_user_func($this->getAnonymousCallable($request->command), $request);
        } catch (Throwable $e) {
            $this->formatter->printThrowable($e->getMessage());
            exit;
        }
    }

    /**
     * @param  CommandRequest $request
     * @param  Dog            $dog
     *
     * @return void
     * @throws WrongDogActionException
     */
    private function callDogAction(CommandRequest $request, Dog $dog): void
    {
        if (!isset($request->secondCommand)) {
            throw new WrongDogActionException('Missing action for dog. Type help for more info.');
        }

        $action = $this->getController($request->secondCommand);

        if (is_null($action)) {
            throw new WrongDogActionException('Unknown action for dog. Type help for more info.');
        }

        $action->run($request, $dog);
        exit;
    }

    /**
     * @param  string $command
     *
     * @return callable
     * @throws CommandNotFoundException
     */
    public function getAnonymousCallable(string $command): callable
    {
        $anonymous = $this->getAnonymousCommand($command);
        if ($anonymous === null) {
            throw new CommandNotFoundException("Command \"$command\" not found. Type help for more info.");
        }

        return $anonymous;
    }

    /**
     * @return void
     */
    private function registerConfigCommands(): void
    {
        $config = require self::COMMANDS_CONFIG_PATH;

        $this->addDogs($config['dogs']);
        $this->addControllers($config['actions']);
        $this->addOtherCommandControllers($config['other_commands']);
        $this->addAnonymousCommands($config['anonymous']);
    }
}
