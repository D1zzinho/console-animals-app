<?php

namespace App\Models;

use ReflectionClass;

class PlushPug extends ToyDog
{
    /**
     * @return string
     */
    public function squeak(): string
    {
        return "{$this->getClassName()} is a toy which can't squeak...";
    }
}
