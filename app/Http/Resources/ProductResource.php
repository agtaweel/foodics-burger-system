<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'            =>  $this->id,
            'created'       =>  $this->created_at->timestamp,
            'updated'       =>  $this->updated_at->timestamp,
            'ingredients'   =>  IngredientResource::collection($this->ingredients),
        ];
    }
}
