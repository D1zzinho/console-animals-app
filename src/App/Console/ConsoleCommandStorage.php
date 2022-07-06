<?php

namespace App\Console;

use App\Controllers\Controller;
use App\Exceptions\CommandNotFoundException;
use App\Exceptions\NoArgumentsProvidedException;
use App\Exceptions\WrongDogActionException;
use App\Models\DogInterface;
use Exception;
use Throwable;

class ConsoleCommandStorage
{
    private static ConsoleCommandStorage $instance;

    /**
     * @var array<string, DogInterface>
     */
    private array $models = [];

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
     * @param  string       $name
     * @param  DogInterface $model
     *
     * @return void
     */
    public function addModel(string $name, DogInterface $model): void
    {
        $this->models[$name] = $model;
    }

    /**
     * @param  array<string, DogInterface> $models
     *
     * @return void
     */
    public function addModels(array $models): void
    {
        $this->models = array_merge($this->models, $models);
    }

    /**
     * @param  string $command
     *
     * @return DogInterface|null
     */
    private function getModel(string $command): ?DogInterface
    {
        return isset($this->models[$command]) ? new $this->models[$command] : null;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return $this->models;
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

            $dog = $this->getModel($request->command);
            if (!is_null($dog)) {
                $this->callAction($request);
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
     *
     * @return void
     * @throws WrongDogActionException
     */
    private function callAction(CommandRequest $request): void
    {
        if (!isset($request->secondCommand)) {
            throw new WrongDogActionException('Missing action for dog. Type help for more info.');
        }

        $action = $this->getController($request->secondCommand);

        if (is_null($action)) {
            throw new WrongDogActionException('Unknown action for dog. Type help for more info.');
        }

        $action->run($request);
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
        $this->addModels(CONFIG['models']);
        $this->addControllers(CONFIG['actions']);
        $this->addOtherCommandControllers(CONFIG['other_commands']);
        $this->addAnonymousCommands(CONFIG['anonymous']);
    }
}
