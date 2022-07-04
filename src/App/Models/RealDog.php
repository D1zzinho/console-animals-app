<?php

namespace App\Models;

use ReflectionClass;

abstract class RealDog implements Dog
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
