<?php

namespace App\Models;

use ReflectionClass;

abstract class AbstractToyDog implements DogInterface
{
    /**
     * @return string
     */
    public function hunt(): string
    {
        return "{$this->getClassName()} is a toy! It can't hunt...";
    }

    /**
     * @return string
     */
    public function bark(): string
    {
        return "{$this->getClassName()} is a toy! It can't bark...";
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        $reflection = new ReflectionClass($this);
        return $reflection->getShortName();
    }
}
