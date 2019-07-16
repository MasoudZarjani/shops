<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSocialResource extends JsonResource
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
            'telegram' => $this->telegram ?? "",
            'twitter' => $this->twitter ?? "",
            'instagram' => $this->instagram ?? "",
            'facebook' => $this->facebook ?? ""
        ];
    }
}
