<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'client_id' => $this->resource->client_id,
            'amount' => $this->resource->amount,
            'paid' => $this->resource->paid,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'client' => $this->whenLoaded('client'),
            'user' => $this->whenLoaded('user'),
            'detail' => $this->whenLoaded('detail'),
            'detailPayment' => $this->whenLoaded('detailPayment'),
        ];
    }
}
