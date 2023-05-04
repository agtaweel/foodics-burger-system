<?php

namespace App\Models;

use App\ModelFilters\ProductFilter;
use EloquentFilter\Filterable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    use HasFactory,Filterable;

    public function ingredients():BelongsToMany{
        return $this->belongsToMany(Ingredient::class)->withPivot(['weight']);
    }

    public function orders():BelongsToMany{
        return $this->belongsToMany(Order::class)->withPivot(['quantity','price']);
    }
    public function modelFilter(): string
    {
        return $this->provideFilter(ProductFilter::class);
    }
    public function scopeActive(Builder $query)
    {
        $query->raw("SELECT * FROM `products`, `ingredient_product`, `ingredients`
            WHERE EXISTS(
                SELECT * FROM `ingredients`
                    INNER JOIN `ingredient_product` ON `ingredients`.`id` = `ingredient_product`.`ingredient_id`
                    WHERE `products`.`id` = `ingredient_product`.`product_id`
                        ) AND `ingredient_product`.`weight` <= `ingredients`.`stock`");
    }
}
