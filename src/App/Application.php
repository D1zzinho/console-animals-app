<?php

namespace App;

use App\Console\Formatter;
use App\Exceptions\NoArgumentsProvidedException;
use Throwable;

class Application
{
    private Formatter $formatter;

    public function __construct()
    {
        $this->formatter = new Formatter();
    }

    /**
     * @param  int   $argc
     * @param  array $argv
     *
     * @return void
     */
    public function bootstrap(int $argc, array $argv): void
    {
        try {
            if ($argc === 1) {
                throw new NoArgumentsProvidedException('No arguments provided! Try --help for more info.');
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

    /**
     * @param Formatter $formatter
     */
    public function setFormatter(Formatter $formatter): void
    {
        $this->formatter = $formatter;
    }
}
