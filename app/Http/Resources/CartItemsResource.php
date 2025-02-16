<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return
            [
                'id' => $this->id,
                'product_id' => $this->product_id,
                'product_name' => $this->product->name,
                'quantity' => $this->quantity,
                'price' => $this->product->final_price,
                'image' => $this->product->image,
                'total_price' => $this->quantity * $this->product->final_price
            ];
    }
}
