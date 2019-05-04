<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'path' => $this->path ?? '',
            'size' => $this->size ?? '',
            'type' => $this->type ?? 0,
            'title' => ($this->describe) ? $this->describe->title : '',
            'description' => ($this->describe) ? $this->describe->description : '',
        ];
    }
}
