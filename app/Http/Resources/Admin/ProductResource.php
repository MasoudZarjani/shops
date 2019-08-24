<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category;
use App\Brand;

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
        $brand_name = '';
        $brand = Brand::find($this->brand);
        if($brand)
        {
            $brand_name = $brand->describe()->ofType(config("constants.describe.type.text"))->first()->title;
        }
        $category_name = '';
        if($this->detail)
        {
            $detail = $this->detail->properties;
            if($detail)
            {
                //$price = $detail['price'];
                $category_id = $detail['category_id'];
                $category = Category::find($category_id);
                if($category)
                {
                    $category_name = $category->describes()->ofType(config("constants.describe.type.text"))->first()->title;
                }
            }
        }

        return [
            'id' => $this->id ?? "",
            'title' => $this->describe->title ?? "",
            'category' => $category_name ??  "",
            'status' =>  $this->status,
            'image' => $this->files()->where('position',2)->first()->path ?? '',
            'brand' => $brand_name,
        ];
        
    }
}
