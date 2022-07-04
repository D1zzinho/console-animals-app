<?php

namespace App;

use App\Console\ConsoleCommandStorage;
use App\Console\Formatter;
use App\Exceptions\NoArgumentsProvidedException;
use Throwable;

class Application
{
    private Formatter             $formatter;
    private ConsoleCommandStorage $consoleCommandStorage;

    public function __construct()
    {
        $this->formatter = new Formatter();
        $this->consoleCommandStorage = new ConsoleCommandStorage();
    }

    /**
     * @param  int   $argc
     * @param  array $argv
     *
     * @return void
     */
    public function bootstrap(int $argc, array $argv): void
    {
        $this->registerCommands();

        try {
            if ($argc === 1) {
                throw new NoArgumentsProvidedException('No arguments provided! Type help for more info.');
            }

            $this->formatter->print("Your argument is {$argv[1]}");
        } catch (Throwable $e) {
            $this->printThrowable($e);
        }
    }

    /**
     * @param  Throwable $throwable
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
