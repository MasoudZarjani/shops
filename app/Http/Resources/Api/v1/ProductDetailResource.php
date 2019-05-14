<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utility;
use App\User;
use App\Action;

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
        $user_id = 0;
        if (request('uuid') && request('api_token'))
            $user_id = User::getWithRequest()->id;
        $rating = Utility::rounded($this->actions ?? []);
        return [
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'category' => $this->product_able->getDescribe(),
            'bookmark' => Action::checkBookmark($this->actions(), $user_id) ? 1 : 0,
            'rating' => $rating,
            'image' => FileResource::collection($this->files()->ofPosition(config('constants.file.position.productSliderFile'))->get() ?? []),
            'price' => PriceResource::collection($this->prices ?? []),
            'warrantors' => WarrantorResource::collection($this->warrantors ?? []),
            'colors' => ColorResource::collection($this->colors),
        ];
    }
}
