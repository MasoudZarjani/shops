<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Action;
use App\Helpers\Utility;

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
        $rating = Utility::rounded($this->actions ?? []);
        $prices = $this->prices->map(function($item) {
            return [
                'price' => $item->price,
                'discount' => $item->discount,
            ];
        });
        return [
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'image' => FileResource::collection($this->files()->ofPosition(config('constants.file.position.productSliderFile'))->get() ?? []),
            'rating' => $rating,
            'price' => $prices,
            'warrantors' => $this->warrantors
        ];
    }
}
