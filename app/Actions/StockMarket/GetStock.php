<?php

namespace App\Actions\StockMarket;

use Illuminate\Support\Facades\Http;


class GetStock
{
    public function execute()
    {
        $apiKey = env('STOCKMARKET_API_TOKEN');
        $stockSymbol = env('STOCKMARKET_APPL');
        $stockMarketEndpoint = "https://api.polygon.io/v2/aggs/ticker/$stockSymbol/range/1/day/2023-01-09/2023-01-09?apiKey=$apiKey";
        $apiResponse = Http::get($stockMarketEndpoint);

        if ($apiResponse->successful()) {
            $data = $apiResponse->json();
            return response()->json($data);
        }
    }
}
