<?php

declare(strict_types=1);

namespace App\Services\IRail;

use App\Services\IRail\ValueObjects\DepartureData;
use App\Services\IRail\ValueObjects\StationData;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class APIService implements IRailApi
{
    public function __construct(
        private readonly string $baseUri,
        private readonly int $timeout
    ) {
    }

    /**
     * @return Collection<int, \App\Services\IRail\ValueObjects\StationData>
     * @throws ConnectionException
     * @throws RequestException
     */
    public function stations(): Collection
    {
        $request = $this->buildRequest();

        $response = $request->withQueryParameters($this->getQueryParams())
            ->get('/stations');

        if ($response->failed()) {
            throw $response->toException();
        }

        $stationsData = collect($response->json()['station']);

        return $stationsData->map(fn (array $data) => new StationData(
            id: $data['id'],
            name: $data['name']
        ));
    }

    /**
     * @param  string  $stationName
     * @return Collection<int, \App\Services\IRail\ValueObjects\DepartureData>
     * @throws ConnectionException
     * @throws RequestException
     */
    public function stationDepartures(string $stationName): Collection
    {
        $request = $this->buildRequest();

        $response = $request->withQueryParameters($this->getQueryParams([
            'station' => $stationName,
            'arrdep' => 'departure'
        ]))
            ->get("/liveboard/");

        if ($response->failed()) {
            throw $response->toException();
        }

        $stationDepartures = collect($response->json()['departures']['departure']);

        return $stationDepartures->map(fn (array $data) => new DepartureData(
            station: $data['station'],
            time: Carbon::createFromTimestamp($data['time'], 'Europe/Brussels'),
            platform: $data['platform'],
        ));
    }

    private function buildRequest(): PendingRequest
    {
        return Http::timeout($this->timeout)
            ->baseUrl($this->baseUri);
    }

    private function getQueryParams(array $params = []): array
    {
        return [
            ...$params,
            'lang' => 'en',
            'format' => 'json',
        ];
    }
}
