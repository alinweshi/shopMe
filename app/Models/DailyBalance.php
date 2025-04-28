<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyBalance extends Model
{
    protected $fillable = ['id', 'account_number', 'iban', 'date', 'account_number', 'name', 'currency', 'balance', 'created_at', 'updated_at'];
    protected $table = 'daily_balances';
}
