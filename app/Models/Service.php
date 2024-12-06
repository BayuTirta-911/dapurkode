<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price_1',
        'price_2',
        'price_3',
        'status',
        'image',
        'admin_note',
        'installer_fee',
        'affiliator_fee',
        'other_fee',
    ];
    

    // Relasi ke user/vendor
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function group()
    {
        return $this->belongsTo(ServiceGroup::class, 'group_id', 'id');
    }
}