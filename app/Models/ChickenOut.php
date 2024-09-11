<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ChickenOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'chicken_import_id',
        'building_number',
        'm_KUNAG',
        'date',
        'weight',
        'time',
        'car_code',
        'origin',
        'weight_bridge',
        'assistant',
        'worker',
        'owner',
        'supplier',
        'phone_number',
        'note',
        'quantity',
    ];
}
