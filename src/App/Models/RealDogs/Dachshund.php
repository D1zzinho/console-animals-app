<?php

namespace App\Models\RealDogs;

use App\Models\AbstractRealDog;

class Dachshund extends AbstractRealDog
{
    /**
     * @return string
     */
    public function bark(): string
    {
        return "I'm a {$this->getClassName()} and I'm barking aggressively!";
    }

    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking sweetly!";
    }

    /**
     * @return string
     */
    public function hunt(): string
    {
        return "I'm a {$this->getClassName()} and I'm hunting for your dinner!";
    }
}
