<?php namespace App\Filters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($query)
    {
        return $this->orWhere('title', 'LIKE', '%' . $query . '%');
    }

    public function types($types)
    {
        return $this->whereIn('type', (array) $types);
    }
}
