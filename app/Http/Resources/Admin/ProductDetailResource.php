<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\PersianDateConvert;
use App\Category;
use App\Brand;
use App\Color;

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
        $colors = $this->colors;


        $createdDate = Carbon::parse($this->created_at)->format('Y-m-d');
        $date = PersianDateConvert::gregorian_to_jalali($createdDate);
        
        $detail = $this->detail->properties;
        
        if($detail)
        {
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
            'brand' =>  Brand::where('id',$this->brand)->first()->describe->title,
            'brandList' =>  Brand::with('describe')->get()->pluck('describe.title','id')->toArray(),
            'discount' => $discount ?? 0,
            'mainImage' => $mainImage ? $mainImage->path : "",
            'gallery' => $this->files()->where('position',3)->get() ?? '',
            'colors' => $colors,
            //'colorList' => Color::pluck('name','id')->toArray(),
            'colorList' => ColorResource::collection(Color::all()),
        ];
    }
}
