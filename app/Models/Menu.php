<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
        'price',
        'priceOff'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
