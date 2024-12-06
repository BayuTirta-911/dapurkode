<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    use HasFactory;

    protected $fillable = ['installer_id', 'invoice_id', 'reason', 'status', 'rejection_reason'];

    public function installer()
    {
        return $this->belongsTo(User::class, 'installer_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}

