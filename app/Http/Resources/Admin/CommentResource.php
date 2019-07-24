<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Describe;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $weaknesses = [];
        $strengths = [];
        $points = [];

        $detail = $this->detail->properties;
        
        if($detail)
        {
            $weaknesses = $detail['weaknesses'] ?? [];
            $strengths = $detail['strengths'] ?? [];
            if($detail['points'])
            {
                // $points = json_decode($detail['points']);
                $points = $detail['points'];
                foreach($points as $key=>$value)
                {
                    $describe = Describe::ofType(6)->ofId($value['id'])->first();
                    if($describe)
                        $points[$key]['description'] = $describe->title;
                    
                }
            }
            
        }
        return [
            'id' => $this->id ?? "",
            'user' => $this->user ? ($this->user->profile? $this->user->profile->full_name : '') : '',
            'product' => $this->message_able ? ($this->message_able->describe ? ($this->message_able->describe->title?? '') : '' ) : '',
            'title' => $this->describe ? $this->describe->title : '',
            'status' => $this->status,
            'file' =>  $this->file->path ?? '',

            'weaknesses' => $weaknesses ?? [],
            'strengths' => $strengths ?? [],
             'points' => $points,
        ];
    }
}
