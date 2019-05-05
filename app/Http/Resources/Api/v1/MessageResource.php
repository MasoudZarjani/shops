<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product;
use App\Describe;

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
        $product = Product::get()->product_able;
        $actions = $this->actions->map(function ($item) use ($product) {
            $describe = Describe::ofId($item->describe_id)->first();
            $checkParent = self::checkParent($product, $describe->describe_able, $item->describe_id);
            return [
                'value' => $item->value ?? "",
                'title' => Describe::ofId($checkParent)->first()->title ?? ""
            ];
        });
        return [
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'actions' => $actions ?? "",
        ];
    }

    public function checkParent($product, $category, $describe_id)
    {
        if ($product->id == $category->id) {
            return $describe_id;
        } else if ($product->parent) {
            return self::checkParent($product->parent, $category, $describe_id);
        } else {
            return 0;
        }
    }
}
