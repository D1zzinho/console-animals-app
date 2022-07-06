<?php

namespace App\Controllers;

class HuntController extends Controller
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $dog = new (CONFIG['models'][$this->request->command]);
        $this->formatter->print($dog->hunt());
    }
}
