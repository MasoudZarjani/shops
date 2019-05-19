<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->colors->map(function($item) {
            return [
                'name' => $item->name,
                'code' => $item->code,
                'images' => FileResource::collection($item->files()->where('file_able_type', 'App\Product')->where('file_able_id', $item->id)->where('position', 3)->get()),
            ];
        });
    }
}
