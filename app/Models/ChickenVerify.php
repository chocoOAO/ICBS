<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChickenVerify extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'contract_id',
        // 'date',
        // 'quantity',
        // 'gift_quantity',
        // 'amount',
        // 'price',
        // 'package_quantity',
        // 'package',
        // 'avg_weight',
        // 'total_weight',
        // 'picture_url',

        'contract_id',
        'customer_name',
        'date',
        'quantity',
        'gift',
        'disuse',
        // 'death_quantity',
        'price',
        'fee',
        'amount',
        'money1',
        'money2',
        'memo1',
        'creator',
        'last_editor',
        'modified_log',
    ];
}
