<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'color' => new ColorResource($this->color),
            'warrantor' => new WarrantorResource($this->warrantor),
            'product' => new ProductResource($this->basket_able),
            'count' => $this->count
        ];
    }
}
