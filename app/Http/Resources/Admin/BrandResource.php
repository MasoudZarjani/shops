<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'status' => $this->status ?? "",
            'image' => $this->file->path ?? '' ,
        ];
    }
}
