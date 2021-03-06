<?php

namespace App\Http\Resources\Api\v1;

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
        $describe = $this->describes()->ofType(config('constants.describe.type.text'))->first();
        return [
            'uuid' => $this->uuid ?? '',
            'title' => $describe->title ?? '',
            'path' => $this->file->path ?? config('constants.default.category.image'),
            'children' => ($this->children)  ? true : false
        ];
    }
}
