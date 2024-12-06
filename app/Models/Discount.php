<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'service_ids',
    ];

    // Decode service_ids saat diakses
    protected $casts = [
        'service_ids' => 'array',
    ];
}

