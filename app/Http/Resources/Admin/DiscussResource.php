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
            // 'file_user' => $this->file->ofPosition(config("constants.file.position.discussUser"))->first()->path ?? '',
            // 'file_admin' => $this->file->ofPosition(config("constants.file.position.discussAdmin"))->first()->path ?? '',
            'file_user' => $this->file->ofPosition(5)->first()->path ?? '',
            'file_admin' => $this->file->ofPosition(6)->first()->path ?? '',

        ];
    }
}
