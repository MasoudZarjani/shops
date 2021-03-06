<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
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
            'uuid' => $this->uuid ?? "",
            'address' => $this->address ?? "",
            'phone' => $this->phone ?? "",
            'fax' => $this->fax ?? "",
            'postal_code' => $this->postal_code ?? "",
            'city' => $this->city->name ?? "",
            'province' => $this->city->province->name ?? ""
        ];
    }
}
