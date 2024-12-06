<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_code',
        'user_id',
        'service_id',
        'total_price',
        'bank_id',
        'order_address',
        'backup_phone',
        'installer_note',
        'discount_code',
        'discount_amount',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function affiliateUser()
    {
        return $this->belongsTo(AffiliateRequest::class, 'affiliate_code', 'affiliate_code');
    }

}
