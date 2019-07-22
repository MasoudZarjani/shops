<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscussResource extends JsonResource
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
            'user' => $this->user ? ($this->user->profile? $this->user->profile->full_name : '') : '',
            'product' => $this->message_able ? ($this->message_able->describe ? ($this->message_able->describe->title?? '') : '' ) : '',
            'title' => $this->describe ? $this->describe->title : '',
            'status' => $this->status,
            'file_user' => $this->file->path ?? '/images/login-background1.jpg',
            'file_admin' => $this->file->path ?? '/images/login-background1.jpg',
        ];
    }
}
