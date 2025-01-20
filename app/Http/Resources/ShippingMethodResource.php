<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cost' => $this->cost,
            'delivery_time' => $this->delivery_time,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_free' => $this->is_free,
            'image' => $this->image,
            'slug' => $this->slug,
            'is_default' => $this->is_default,
            'is_pickup' => $this->is_pickup,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
