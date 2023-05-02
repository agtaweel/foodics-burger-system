<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property \Illuminate\Database\Eloquent\Collection<Ingredient> $ingredients
 * @property int $id
 * @property string $name
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    public function ingredients():BelongsToMany{
        return $this->belongsToMany(Ingredient::class)->withPivot(['weight']);
    }

    public function orders():BelongsToMany{
        return $this->belongsToMany(Order::class)->withPivot(['quantity','price']);
    }
}
