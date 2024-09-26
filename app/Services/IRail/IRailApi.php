<?php

declare(strict_types=1);

namespace App\Services\IRail;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface IRailApi
{
    /**
     * @return Collection<int, \App\Services\IRail\ValueObjects\StationData>
     * @throws ConnectionException
     * @throws RequestException
     */
    public function stations(): Collection;

    /**
     * @param  string  $stationName
     * @return Collection<int, \App\Services\IRail\ValueObjects\DepartureData>
     * @throws ConnectionException
     * @throws RequestException
     */
    public function stationDepartures(string $stationName): Collection;
}
