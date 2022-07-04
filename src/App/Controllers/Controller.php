<?php

namespace App\Controllers;

use App\Application;
use Throwable;

abstract class Controller
{
    protected Application $application;

    public function __construct()
    {
        $this->application = Application::getInstance();
    }

    /**
     * @param  array $argv
     *
     * @return void
     * @throws Throwable
     */
    abstract public function handle(array $argv): void;
}
