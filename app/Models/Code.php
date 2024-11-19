<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public static function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(10));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
