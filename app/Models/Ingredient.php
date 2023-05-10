<?php

namespace App\Models;

use App\Traits\IngredientOperations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int            $id
 * @property double         $percentage
 * @property string         $name
 * @property double         $stock
 * @property string         $unit
 * @property boolean        $has_low_stock_email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Ingredient extends Model
{
    use HasFactory, IngredientOperations;

    protected $fillable = ['stock','percentage','has_low_stock_email'];
    public function products():BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot(['weight']);
    }
}
