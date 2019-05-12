<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'city_id' => $this->city_id,
            'type' => $this->type
        ];
    }
}
