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
            'name' => $this->name ?? "",
            'family' => $this->family ?? "",
            'tel' => $this->tel ?? "",
            'avatar' => $this->file->path ?? "",
        ];
    }
}
