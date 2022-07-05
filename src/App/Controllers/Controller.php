<?php

namespace App\Controllers;

use App\Application;
use App\Console\CommandRequest;
use App\Console\Formatter;
use App\Models\Dog;

abstract class Controller
{
    protected Application    $application;
    protected Formatter      $formatter;
    protected CommandRequest $request;
    protected Dog            $dog;

    public function __construct()
    {
        $this->application = Application::getInstance();
        $this->formatter = Formatter::getInstance();
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @param  CommandRequest $request
     * @param  Dog            $dog
     *
     * @return void
     */
    public function run(CommandRequest $request, Dog $dog): void
    {
        $this->request = $request;
        $this->dog = $dog;
        $this->handle();
    }
}
