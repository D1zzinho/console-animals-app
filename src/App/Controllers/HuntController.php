<?php

namespace App\Controllers;

class HuntController extends Controller
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->formatter->print($this->dog->hunt());
    }
}
