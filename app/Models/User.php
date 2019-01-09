<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Conner\Tagging\Taggable;
use Kyslik\ColumnSortable\Sortable;
use EloquentFilter\Filterable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, Taggable, Sortable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'password', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public $sortable = ['last_name','mobile', 'credit', 'email', 'enabled'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function getBalance()
    {
        return Transaction::balance()->where('user_id', $this->id)->sum('amount');
    }

    public function getNavNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function getNameAttribute()
    {
        if($this->title) {
            return "{$this->first_name} {$this->last_name} ({$this->title})";
        }
        return "{$this->first_name} {$this->last_name}";
    }

    public function getOrderNameAttribute()
    {
        if($this->title) {
            return "{$this->last_name} {$this->first_name} ({$this->title})";
        }
        return "{$this->last_name} {$this->first_name}";
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', 1);
    }

    public function scopeCollect($query, $sort = 'id')
    {
        $request = request();
        $input = $request->input();
        if(session('per-page')) {
            $limit = $request->get('limit', session('per-page'));
        } else {
            $limit = $request->get('limit', config('platform.per-page'));
        }
        return $query->filter($input)->sortable($sort)->paginate($limit);
    }
}
