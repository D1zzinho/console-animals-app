<?php

namespace App\Console;

class CommandRequest
{
    public string  $command;
    public ?string $secondCommand;
    public array   $argv   = [];
    public array   $params = [];

    public function __construct(array $argv)
    {
        $this->loadParams($argv);
    }

    /**
     * @param  string $param
     *
     * @return bool
     */
    public function hasParam(string $param): bool
    {
        return isset($this->params[$param]);
    }

    /**
     * @param  string $param
     *
     * @return string|null
     */
    public function getParam(string $param): ?string
    {
        return $this->params[$param] ?? null;
    }

    /**
     * @param  array $argv
     *
     * @return void
     */
    private function loadParams(array $argv): void
    {
        foreach ($argv as &$arg) {
            $pair = explode('=', $arg);
            if (count($pair) == 2) {
                $arg = $pair[0];
                $this->params[$pair[0]] = $pair[1];
            }
        }

        $this->argv = $argv;
        $this->command = $argv[1] ?? 'help';
        $this->secondCommand = $argv[2] ?? null;
    }
}
