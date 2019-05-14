<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->files()->ofPosition(config('constants.file.position.productMainImage'))->first()->path;
        return [
            'uuid' => $this->uuid ?? "",
            'title' => $this->describe->title ?? "",
            'image' => $image ?? "",
            'price' => PriceResource::collection($this->prices ?? []),
        ];
    }
}
