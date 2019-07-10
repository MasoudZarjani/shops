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
            'status' => $this->status ?? "",
            'image' => $this->file()->path ?? "",
            'countChildren' => $this->children()->count(),
        ];
    }
}
