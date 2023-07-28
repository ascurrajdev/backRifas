<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaffleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "description" => $this->resource->description,
            "amount" => $this->resource->amount,
            "created_at" => $this->resource->created_at->format("Y-m-d H:i:s"),
            "updated_at" => $this->resource->updated_at->format("Y-m-d H:i:s"),
            "users" => $this->whenLoaded("users"),
            "admin" => $this->whenLoaded("admin"),
            "numbers" => $this->whenLoaded("numbers")
        ];
    }
}
