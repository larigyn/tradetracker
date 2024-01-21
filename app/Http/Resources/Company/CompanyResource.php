<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'user_id'       =>  $this->user_id,
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'address'       =>  $this->address,
            'logo'          =>  $this->logo,
        ];
    }
}
