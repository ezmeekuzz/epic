<?php

namespace App\Services;

use Square\SquareClient;

class SquareService
{
    public static function getClient()
    {
        $accessToken = config('Square.accessToken');
        $locationId = config('Square.locationId');

        $client = new SquareClient([
            'accessToken' => $accessToken,
        ]);

        return $client;
    }
}
