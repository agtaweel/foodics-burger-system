<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Ingredient
 */
class IngredientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         =>  $this->id,
            'name'       =>  $this->name,
            'stock'      =>  $this->stock,
            'percentage' =>  $this->percentage,
            'unit'       =>  $this->unit,
            'created'    =>  $this->created_at->timestamp,
            'updated'    =>  $this->updated_at->timestamp,
        ];
    }
}
