<?php

declare(strict_types=1);

namespace App\Http\Actions;

use App\Services\IRail\IRailApi;
use App\Services\IRail\ValueObjects\DepartureData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class ProcessChatBotMessage
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function execute(string $message): string
    {
        if ('stations' === $message) {
            return $this->listStations();
        }

        return $this->stationDepartures($message);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    private function listStations(): string
    {
        $stations = app(IRailApi::class)->stations();

        return $stations->pluck('name')->implode(', ');
    }

    /**
     * @throws ConnectionException
     */
    private function stationDepartures(string $message): string
    {
        try {
            $departures = app(IRailApi::class)->stationDepartures($message);

            if ( ! $departures->count()) {
                return "No departures for this station.";
            }

            $nextTwoDepartures = $departures->take(2);

            return $this->formatDepartures($nextTwoDepartures);
        } catch (RequestException $e) {
            if (404 === $e->response->status()) {
                return "Sorry, I don't know how to answer that.";
            }
            return 'Error fetching train times. Please try again later.';
        }
    }

    /**
     * @param  Collection<int, \App\Services\IRail\ValueObjects\DepartureData>  $departures
     * @return string
     */
    private function formatDepartures(Collection $departures): string
    {
        return $departures->map(function (DepartureData $departure) {
            $formattedTime = $departure->time->format('H:i');
            return "{$departure->station} at {$formattedTime} - Platform {$departure->platform}";
        })->join("\n");
    }
}
