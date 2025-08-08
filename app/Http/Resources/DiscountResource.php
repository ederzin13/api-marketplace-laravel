<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            "activeOn" => new ProductResource($this->whenLoaded("product")),
            "description" => $this->description,
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "discountPercentage" => $this->discountPercentage
        ];
    }
}
