<?php

namespace App\Models;

interface Dog
{
    public function bark(): string;
    public function squeak(): string;
    public function hunt(): string;
}
