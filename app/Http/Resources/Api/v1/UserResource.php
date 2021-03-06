<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->profile->name ?? "",
            'family' => $this->profile->family ?? "",
            'mobile' => $this->mobile ?? "",
            'phone' => $this->phone ?? "",
            'email' => $this->email ?? "",
            'addresses' => AddressResource::collection($this->addresses ?? []),
            'avatar' => $this->file->path ?? "",
        ];
    }
}
