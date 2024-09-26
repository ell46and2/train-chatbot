<?php

declare(strict_types=1);

namespace App\Services\IRail\ValueObjects;

class StationData
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
