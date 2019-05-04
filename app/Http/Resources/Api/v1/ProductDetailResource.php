<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'attributes' => AttributeResource::collection($this->attributes ?? ""),
            'image' => FileResource::collection($this->files()->ofPosition(config('constants.file.position.productSliderFile'))->get() ?? ""),
        ];
    }
}
