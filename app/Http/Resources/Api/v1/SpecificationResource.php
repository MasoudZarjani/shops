<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utility;

class SpecificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rating = Utility::rounded($this->actions);
        return [
            'title' => $this->describe->title ?? "",
            'attributes' => AttributeResource::collection($this->attributes ?? ""),
            'rating' => $rating
        ];
    }
}
