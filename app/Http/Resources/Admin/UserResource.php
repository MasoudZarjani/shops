<?php

namespace App\Http\Resources\Admin;

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
            'id' => $this->id ?? "",
            'full_name' => $this->profile->full_name ?? "",
            'mobile' => $this->mobile ?? "",
            'status' => $this->status ?? "",
            'avatar' => $this->avatar()->path ?? ""
        ];
    }
}
