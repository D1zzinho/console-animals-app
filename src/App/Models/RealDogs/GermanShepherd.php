<?php

namespace App\Models\RealDogs;

use App\Models\AbstractRealDog;

class GermanShepherd extends AbstractRealDog
{
    /**
     * @return string
     */
    public function bark(): string
    {
        return "I'm a {$this->getClassName()} and I'm barking very loud when I see you!";
    }

    /**
     * @return string
     */
    public function squeak(): string
    {
        return "I'm a {$this->getClassName()} and I'm squeaking when I see my owner!";
    }

    /**
     * @return string
     */
    public function hunt(): string
    {
        return "I'm a {$this->getClassName()} and I'm hunting very fast and precisely!";
    }
}
