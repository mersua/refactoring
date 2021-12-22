<?php

declare(strict_types=1);

namespace App\Model;

interface Model
{
    public static function fromOrigin(array $origin): self;
}