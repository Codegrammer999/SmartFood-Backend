<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'payment_receipt',
        'referral_id',
        'referred_by',
        'role',
        'registration_status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user){
            $user->referral_id = substr(Hash::make(uniqid()), 0, 10);
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function mainwallet()
    {
        return $this->hasOne(MainWallet::class);
    }

    public function bonuswallet()
    {
        return $this->hasOne(BonusWallet::class);
    }

    public function referrer()
    {
        return $this->BelongsTo(Referral::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredUsers()
    {
        return $this->hasMany(Referral::class, 'referred_by');
    }

    public function ownedCodes()
    {
        $this->hasMany(Code::class, 'user_id');
    }

    public function usedCodes()
    {
        $this->hasMany(Code::class, 'used_by');
    }
}
