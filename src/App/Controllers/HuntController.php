<?php

namespace App\Controllers;

use App\Exceptions\DogTypeArgumentNotProvided;

class HuntController extends Controller
{
    /**
     * @param array $argv
     *
     * @return void
     * @throws DogTypeArgumentNotProvided
     */
    public function handle(array $argv): void
    {
        if (!isset($argv[2])) {
            throw new DogTypeArgumentNotProvided('You have to call specified dog. Type help for more info.');
        }

        $dog = $argv[2];
    }
}
