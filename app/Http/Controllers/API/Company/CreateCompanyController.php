<?php

namespace App\Http\Controllers\API\Company;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Company\CreateCompany;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Requests\Company\CreateCompanyRequest;


class CreateCompanyController extends Controller
{
    public function __invoke(CreateCompanyRequest $request, CreateCompany $action): JsonResponse
    {
        $request->validated();

        try {
            $companyData = $action->execute($request->all());
            $this->response['data'] = new CompanyResource($companyData);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
