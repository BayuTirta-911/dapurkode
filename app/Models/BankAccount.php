<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    protected $fillable = ['bank_name', 'account_number', 'description', 'image'];
}
