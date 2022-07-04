<?php

namespace App;

use App\Console\ConsoleCommandStorage;
use App\Console\Formatter;
use App\Exceptions\NoArgumentsProvidedException;
use Exception;
use Throwable;

class Application
{
    private static Application    $instance;
    private Formatter             $formatter;
    private ConsoleCommandStorage $consoleCommandStorage;

    private function __construct()
    {
        $this->consoleCommandStorage = ConsoleCommandStorage::getInstance();
        $this->formatter = Formatter::getInstance();
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
     * @param int   $argc
     * @param array $argv
     *
     * @return void
     */
    public function bootstrap(int $argc, array $argv): void
    {
        $command = 'help';

        try {
            if ($argc === 1) {
                throw new NoArgumentsProvidedException('No arguments provided! Type help for more info.');
            }

            if (isset($argv[1])) {
                $command = $argv[1];
            }

            call_user_func($this->consoleCommandStorage->getCommandCallback($command), $argv);
        } catch (Throwable $e) {
            $this->printThrowable($e);
        }
    }

    /**
     * @param Throwable $throwable
     *
     * @return void
     */
    public function printThrowable(Throwable $throwable): void
    {
        $this->formatter->printThrowable($throwable->getMessage());
    }

    /**
     * @return Formatter
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }
}
