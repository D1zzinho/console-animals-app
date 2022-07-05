<?php

namespace App\Models\RealDogs;

class GermanShepherd extends \App\Models\RealDog
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
