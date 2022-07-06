<?php

namespace App\Models;

use ReflectionClass;

abstract class AbstractRealDog implements DogInterface
{
    /**
     * @return string
     */
    protected function getClassName(): string
    {
        $reflection = new ReflectionClass($this);
        return $reflection->getShortName();
    }
}
