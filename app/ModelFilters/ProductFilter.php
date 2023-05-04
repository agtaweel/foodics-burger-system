<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function name($name):ProductFilter
    {
        return $this->where('name','like',"%$name%");
    }

    public function id($id):ProductFilter
    {
        return $this->where('id','=',$id);
    }

    public function pricefrom($price_from):ProductFilter
    {
        return $this->where('price','>=',$price_from);
    }
    public function priceto($price_to):ProductFilter
    {
        return $this->where('price','<=',$price_to);
    }
    public function iningredients(array $in_ingredients):ProductFilter
    {
        return $this->whereHas('ingredients',function ($q)use ($in_ingredients){
            return $q->whereIn('ingredients.name',$in_ingredients);
        });
    }
}
