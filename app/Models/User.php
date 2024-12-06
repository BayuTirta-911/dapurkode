<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'last_balance_updated',
        'status',
    ];

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
    public function serviceGroups()
    {
        return $this->hasMany(ServiceGroup::class, 'vendor_id', 'id');
    }
    public function affiliateRequest()
    {
        return $this->hasOne(AffiliateRequest::class, 'user_id', 'id');
    }
    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class, 'user_id', 'id');
    }

    const ADMIN = 'admin';
    const VENDOR = 'vendor';
    const INSTALLER = 'installer';
    const AFFILIATOR = 'affiliator';
    const USER = 'user';
}
