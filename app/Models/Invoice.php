<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'id_service',
        'id_buyer',
        'service_name',
        'affiliate_code',
        'total_price',
        'discount_code',
        'address',
        'phone',
        'note',
        'bank_id',
        'status',
        'project_status',
        'progress_percentage',
        'log',
        'proof',
        'og_price',
        'og_disc',
    ];

    public function bank()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'id_buyer', 'id');
    }

    public function affiliateUser()
    {
        return $this->belongsTo(AffiliateRequest::class, 'affiliate_code', 'affiliate_code');
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }
    
    public function projectRequests()
    {
        return $this->hasMany(ProjectRequest::class, 'invoice_id');
    }

}

