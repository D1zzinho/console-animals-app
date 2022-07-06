<?php

namespace App\Models\ToyDogs;

use App\Models\AbstractToyDog;

class PlushPug extends AbstractToyDog
{
    /**
     * @return string
     */
    public function squeak(): string
    {
        return "{$this->getClassName()} is a toy which can't squeak...";
    }
}
