<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'self_description',
        'marketing_plan',
        'status',
        'admin_note',
        'affiliate_code',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function affiliateRequest()
    {
        return $this->hasOne(AffiliateRequest::class, 'user_id', 'id');
    }
}
