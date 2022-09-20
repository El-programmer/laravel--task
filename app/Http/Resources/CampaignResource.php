<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name ,
            'from' => $this->from,
            'to' => $this->to,
            'total' => $this->total,
            'daily_budget' => $this->daily_budget,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'images' => $this->images
        ];
    }
}
