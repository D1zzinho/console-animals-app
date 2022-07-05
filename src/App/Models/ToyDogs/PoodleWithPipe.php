<?php

namespace App\Models\ToyDogs;

use App\Models\ToyDog;

class PoodleWithPipe extends ToyDog
{
    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking very loud!";
    }
}
