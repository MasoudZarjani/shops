<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'user' => $this->user ? ($this->user->profile? $this->user->profile->full_name : '') : '',
            'product' => $this->product ? ($this->product->describe ? ($this->product->describe->title?? '') : '' ) : '',
            'title' => $this->describe ? $this->describe->title : '',
        ];
    }
}
