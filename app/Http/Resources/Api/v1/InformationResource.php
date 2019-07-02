<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
            'full_name' => $this->profile->full_name ?? "",
            'avatar' => "",
            'wallet' => $this->account->wallet ?? "",
            'score' => $this->account->score ?? "",
            'coin' => $this->account->coin ?? "",
            'correct_answer' => $this->account->correct_answer ?? "",
            'wrong_answer' => $this->account->wrong_answer ?? "",
            'level' => $this->account->level ?? "",
        ];
    }
}
