<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'menu_id',
        'quantity',
        'total_price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        $this->belongsTo(Menu::class);
    }
}
