<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\JSONResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class AbstractController extends BaseController
{
    use JSONResponser;

    protected $headers = [];

    protected $meta = [];

    protected $data = null;

    protected $httpStatusCode = Response::HTTP_OK;

    public function __construct(Collection $collection)
    {
        $this->data = $collection;
    }

    protected function noContentResponse()
    {
        return $this->jsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function showAll(Collection $collection)
    {
        if ($collection->isEmpty()) {
            $collection = $this->paginate($collection);

            return $this->transformPaginated($collection);
        }

        // Get resource
        $resource = $this->getResource($collection);

        // filter data
        $collection = $this->filter($collection, $resource);

        // sort data
        $collection = $this->sort($collection, $resource);

        $collection = $this->paginate($collection);

        // transform
        $transformedData = $this->transform($collection, $resource);

        // ?cache
        return $this->jsonResponse($transformedData);
    }

    protected function showAllUnpaginated(Collection $collection)
    {
        if ($collection->isEmpty()) {
            $collection = $this->paginate($collection);

            return $this->jsonResponse([]);
        }

        // Get resource
        $resource = $this->getResource($collection);

        // filter data
        $collection = $this->filter($collection, $resource);

        // sort data
        $collection = $this->sort($collection, $resource);

        $data = !empty($resource) ? $resource::collection($collection) : $collection->toArray();
        // initially wrap to data because of debugbar issue
        if (config('app.debug')) {
            return $this->jsonResponse(['data' => $data]);
        }

        return $this->jsonResponse($data);
    }

    protected function showAllWithoutPaginate($collection)
    {
        if ($collection->isEmpty()) {
            return $this->jsonResponse(['data' => $collection]);
        }

        // Get resource
        $resource = $this->getResource($collection);

        // filter data
        $collection = $this->filter($collection, $resource);

        // sort data
        $collection = $this->sort($collection, $resource);

        // transform
        $transformedData = $this->transform($collection, $resource);

        // ?cache
        return $this->jsonResponse($transformedData);
    }

    protected function showOne($data): JsonResponse
    {
        if ($data instanceof Collection) {
            $data = $data->first();
        }

        if ($data instanceof Model) {
            $resource = $data->resource;
            $transformedData = $this->transform($data, $resource);
        } else {
            $transformedData = $data;
        }

        return $this->jsonResponse($transformedData);
    }

    protected function getResource(Collection $collection)
    {
        return !empty($collection->first()->resource) ? $collection->first()->resource : null;
    }

    protected function filter(Collection $collection, $resource)
    {
        $requestQueryString = $this->requestQueryString();
        $item = $collection->take(1)->toArray();

        foreach ($requestQueryString as $query => $value) {
            if (array_key_exists($query, $item)) {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    protected function requestQueryString()
    {
        $requestQuery = request()->query();

        return $requestQuery;
    }

    protected function sort($collection, $resource)
    {
        // We could put it on our api config later
        if (!request()->has('sort_by')) {
            return $collection;
        }

        if (request()->has('order_by') && request()->order_by === 'desc') {
            return  $collection->sortByDesc(request()->sort_by);
        }

        return  $collection->sortBy(request()->sort_by);
    }

    protected function paginate($collection)
    {
        $perPage = request()->limit ?: 10;

        $page = LengthAwarePaginator::resolveCurrentPage();

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $results,
            $collection->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function transformPaginated($data, $resource = null)
    {
        $results = Arr::except($data->toArray(), [
            'data',
            'first_page_url',
            'last_page_url',
            'next_page_url',
            'to',
            'from',
            'path',
            'prev_page_url',
        ]);

        $results['data'] = $resource ? $resource::collection($data) : $data->toArray()['data'];

        return $results;
    }

    protected function transform($data, $resource)
    {
        if ($data instanceof LengthAwarePaginator) {
            return $this->transformPaginated($data, $resource);
        }

        if ($data instanceof Model) {
            return new $resource($data);
        }

        return ['data' => !empty($resource) ? $resource::collection($data) : $data];
    }

    protected function okJsonResponse()
    {
        return $this->jsonResponse(null, $this->httpStatusCode);
    }
}
