<?php

namespace App\Models;

use App\Traits\OrderOperations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<Product> $products
 */
class Order extends Model
{
    use HasFactory, OrderOperations;

    public function products():BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot(['quantity','price']);
    }
}
