<?php namespace App\Filters;

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
    public function search($query)
    {
        return $this->whereLike('title', $query)
            ->whereLike('text', $query, 'or')
            ->whereLike('description', $query, 'or');
    }

    public function brands($types)
    {
        return $this->whereIn('brand_id', (array) $types);
    }
}
