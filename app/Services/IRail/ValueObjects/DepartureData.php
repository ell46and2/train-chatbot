<?php

declare(strict_types=1);

namespace App\Services\IRail\ValueObjects;

use Carbon\Carbon;

class DepartureData
{
    public function __construct(
        public string $station,
        public Carbon $time,
        public string $platform,
    ) {
    }
}
