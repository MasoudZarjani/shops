<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Utility;
use App\Helpers\PersianDateConvert;
use Carbon\Carbon;

class UserResource extends JsonResource
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
        return [
            'id' => $this->id ?? "",
            'full_name' => $this->profile->full_name ?? "",
            'first_name'=> $this->profile->first_name ?? "",
            'last_name'=> $this->profile->last_name ?? "",
            'mobile' => Utility::convertMobileFormatToDefault($this->mobile) ?? "",
            'status' => $this->status ?? "",
            'created_at' => $date ?? "",
            'avatar' => $this->avatar()->path ?? ""
        ];
    }
}
