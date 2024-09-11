<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementAccountNumber extends Model
{
    use HasFactory;
    protected $fillable = ["account_number", "account_date", "weighinh_date"];
}
