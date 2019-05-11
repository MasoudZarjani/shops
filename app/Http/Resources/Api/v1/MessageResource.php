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
        $product = Product::getWithUuid()->product_able;

        $actions = $this->actions->map(function ($item) use ($product) {
            $describe = Describe::ofId($item->describe_id)->first();
            $checkParent = self::checkParent($product, $describe->describe_able ?? 0, $item->describe_id);
            return [
                'value' => $item->value ?? "",
                'title' => Describe::ofId($checkParent)->first()->title ?? ""
            ];
        });
        //$like = $this->actions->ofType(config('constants.action.type.like'));
        return [
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'actions' => $actions,
            //'like' => $like ?? 0,
        ];
    }

    public function checkParent($product, $category, $describe_id)
    {
        if ($category) {
            if ($product->id == $category->id) {
                return $describe_id;
            } else if ($product->parent) {
                return self::checkParent($product->parent, $category, $describe_id);
            } else {
                return 0;
            }
        }
        return 0;
    }
}
