<?php

namespace App\Models;

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
