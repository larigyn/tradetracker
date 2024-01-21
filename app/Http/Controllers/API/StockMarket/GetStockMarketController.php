<?php

namespace App\Http\Controllers\API\StockMarket;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\StockMarket\GetStock;
use App\Http\Resources\User\UserResource;

class GetStockMarketController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param GetStock $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(GetStock $action): JsonResponse
    {
        try {
            $stockData = $action->execute();
            $this->response['data'] = new UserResource($stockData);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
