<?php namespace App\Filters;

use EloquentFilter\ModelFilter;

class TransactionFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function createStart($date)
    {
        $date .= ' 00:00:00';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('created_at', '>=', $date);
    }

    public function createFinish($date)
    {
        $date .= ' 23:59:59';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('created_at', '<=', $date);
    }

    public function dueStart($date)
    {
        $date .= ' 00:00:00';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('due_at', '>=', $date);
    }

    public function dueFinish($date)
    {
        $date .= ' 23:59:59';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('due_at', '<=', $date);
    }

    public function paidStart($date)
    {
        $date .= ' 00:00:00';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('paid_at', '>=', $date);
    }

    public function paidFinish($date)
    {
        $date .= ' 23:59:59';
        $date = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d H:i:s', $date);
        return $this->where('paid_at', '<=', $date);
    }
}
