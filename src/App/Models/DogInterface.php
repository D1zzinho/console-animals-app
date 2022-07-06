<?php

namespace App\Models;

interface DogInterface
{
    public function bark(): string;
    public function squeak(): string;
    public function hunt(): string;
}
