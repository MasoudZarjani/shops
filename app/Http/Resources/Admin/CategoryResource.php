<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id ?? "",
            'title' => $this->describes()->ofType(config('constants.describe.type.text'))->first()->title ?? "",
            'description' => $this->describes()->ofType(config('constants.describe.type.text'))->first()->description ?? "",
            'status' => $this->status ?? "",
            'sort' => $this->sort ?? "",
            'image' => $this->file()->path ?? "",
            'countChildren' => $this->children()->count(),
        ];
    }
}
