<?php

namespace App\Models\RealDogs;

use App\Models\AbstractRealDog;

class Pug extends AbstractRealDog
{
    /**
     * @return string
     */
    public function bark(): string
    {
        return "I'm a {$this->getClassName()} and I'm barking through my nose!";
    }

    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking silently, but obtrusive!";
    }

    /**
     * @return string
     */
    public function hunt(): string
    {
        return "I'm a {$this->getClassName()} and I'm to lazy for hunting...";
    }
}
