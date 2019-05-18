<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
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
        $rate = new RateResource($this->actions()->ofType(config('constants.action.type.rate')));
        return [
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'category' => $this->product_able->getDescribe(),
            'bookmark' => Action::checkBookmark($this->actions(), $user_id) ? 1 : 0,
            'share_link' => "",
            'brand' => "سامسونگ",
            'exist' => 1,
            'rating' => $rate,
            'image' => FileResource::collection($this->files()->ofPosition(config('constants.file.position.productSliderFile'))->get() ?? []),
            'price' => new PriceResource($this->prices()->first() ?? ""),
            'warrantors' => WarrantorResource::collection($this->warrantors ?? []),
            'colors' => ColorResource::collection($this->colors),
            'sliders' => new ProductSliderResource($this),
            'similar' => ProductResource::collection($this->product_able->products()->where('id', '<>', $this->id)->get() ?? []),
            'action' => [
                [
                    'value' => 5,
                    'title' => 'ارزش خرید در برابر قیمت',
                    'count' => 5
                ],
                [
                    'value' => 3,
                    'title' => 'کیفیت ساخت"',
                    'count' => 5
                ],
                [
                    'value' => 1,
                    'title' => 'کارایی و عملکرد"',
                    'count' => 5
                ],
                [
                    'value' => 2,
                    'title' => 'طراحی و ظاهر"',
                    'count' => 5
                ],
            ]
        ];
    }
}
