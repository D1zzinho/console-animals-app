<?php

namespace App\Controllers;

use App\Application;
use App\Console\CommandRequest;
use App\Console\Formatter;

abstract class Controller
{
    protected Application    $application;
    protected Formatter      $formatter;
    protected CommandRequest $request;

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
     *
     * @return void
     */
    public function run(CommandRequest $request): void
    {
        $this->request = $request;
        $this->handle();
    }
}
