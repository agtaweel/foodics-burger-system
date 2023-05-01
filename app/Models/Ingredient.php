<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int            $id
 * @property double         $percentage
 * @property string         $name
 * @property double         $stock
 * @property string         $unit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['stock','percentage'];
    public function products():BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot(['weight']);
    }
}
