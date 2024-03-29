<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                    =>  $this->id,
            'first_name'            =>  $this->first_name,
            'last_name'             =>  $this->last_name,
            'email'                 =>  $this->email,
            'roles'                 =>  $this->roles,
            'created_at'            =>  is_null($this->created_at) ? null : $this->created_at->toDateTimeString(),
            'updated_at'            =>  is_null($this->updated_at) ? null : $this->updated_at->toDateTimeString(),
            'deleted_at'            =>  is_null($this->deleted_at) ? null : $this->deleted_at->toDateTimeString()
        ];
    }
}
