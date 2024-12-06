<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    protected $fillable = ['vendor_id', 'name', 'description'];
    public function services()
    {
        return $this->hasMany(Service::class, 'group_id', 'id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
    
}
