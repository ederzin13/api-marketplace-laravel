<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "userId" => $this->userId,
            "addressId" => $this->addressId,
            "orderDate" => $this->orderDate,
            "couponId" => $this->couponId,
            "status" => $this->status,
            "totalAmount" => $this->totalAmount,
            "items" => OrderItemResource::collection($this->whenLoaded("orderItems"))
        ];
    }
}
