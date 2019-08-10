<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\PersianDateConvert;
use App\Category;

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
        
        $createdDate = Carbon::parse($this->created_at)->format('Y-m-d');
        $date = PersianDateConvert::gregorian_to_jalali($createdDate);
        
        $detail = $this->detail->properties;
        
        if($detail)
        {
            //$price = $detail['price'];
            $discount = $detail['discount'];
            $category_id = $detail['category_id'];
            $category = Category::find($category_id);
            if($category)
            {
                $category_name = $category->describes()->ofType(config("constants.describe.type.text"))->first()->title;
            }
        }
        $mainImage = $this->files()->where('position',2)->first();
        return [
            'id' => $this->id ?? "",
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'category' => $category_name ??  "",
            'status' =>  $this->status,
            //'price' => $price ?? 0,
            'discount' => $discount ?? 0,
            'mainImage' => $mainImage ? $mainImage->path : "",
            'gallery' => $this->files()->where('position',3)->get() ?? '',
        ];
    }
}
