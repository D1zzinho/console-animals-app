<?php

namespace App\Controllers;

use App\Application;
use Throwable;

abstract class Controller
{
    protected Application $application;

    /**
     * @param  array $argv
     *
     * @return void
     * @throws Throwable
     */
    abstract public function handle(array $argv): void;

    /**
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }
}
