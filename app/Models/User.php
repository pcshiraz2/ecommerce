<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Conner\Tagging\Taggable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile'
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

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function getBalance()
    {
        return Transaction::balance()->where('user_id', $this->id)->sum('amount');
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getOrderNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }
}
