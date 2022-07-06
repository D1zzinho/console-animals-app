<?php

namespace App\Models\RealDogs;

use App\Models\AbstractRealDog;

class FoxTerrier extends AbstractRealDog
{
    /**
     * @return string
     */
    public function bark(): string
    {
        return "I'm a {$this->getClassName()} and I'm barking loudly!";
    }

    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking unpleasant!";
    }

    /**
     * @return string
     */
    public function hunt(): string
    {
        return "I'm a {$this->getClassName()} and I'm hunting precisely and successfully!";
    }
}
