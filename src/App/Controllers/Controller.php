<?php

namespace App\Controllers;

use App\Application;

abstract class Controller
{
    protected Application $application;

    /**
     * @param  array $argv
     *
     * @return void
     */
    abstract public function use(array $argv): void;

    /**
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return Application
     */
    protected function getApplication(): Application
    {
        return $this->application;
    }
}
