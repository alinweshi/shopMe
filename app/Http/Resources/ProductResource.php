<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'categories' => $this->categories, // Assuming relationships are set up
            // 'slug' => $this->slug,
            // 'description' => $this->description,
            // // 'category_id' => $this->category_id,
            // 'brand' => $this->brand,
            // 'price' => $this->price,
            'final_price' => $this->final_price,
            // 'discount_type' => $this->discount_type,
            // 'discount' => $this->discount,
            'image' => $this->image,
        ];
    }
}
