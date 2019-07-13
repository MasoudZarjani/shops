<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\PersianDateConvert;

class UserDetailResource extends JsonResource
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
            'first_name' => $this->profile->first_name ?? "",
            'last_name' => $this->profile->last_name ?? "",
            'mobile' => $this->mobile ?? "",
            'status' => $this->status ?? "",
            'reagent_code' => $this->reagent_code ?? "",
            'communication' => CommunicationResource::collection($this->communications) ?? "",
            'created_at' => $date ?? "",
            'avatar' => $this->avatar()->path ?? "",
            'social' => new UserSocialResource($this->social) ?? ""
        ];
    }
}
