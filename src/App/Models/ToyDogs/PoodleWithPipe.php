<?php

namespace App\Models\ToyDogs;

use App\Models\AbstractToyDog;

class PoodleWithPipe extends AbstractToyDog
{
    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking very loud!";
    }
}
