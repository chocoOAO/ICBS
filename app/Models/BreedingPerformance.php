<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreedingPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'chicken_import_id',
        'breeding_rate',
        'avg_weight',
        'feeding_efficiency',
        'age',
    ];
}
