<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvgWeight extends Model
{
    use HasFactory;

    // "Date", "weightFieldAvg", "weightFieldEvenness", 和 "growthRate"
    protected $fillable = [
        'batchNumber',
        'Date',
        'weightFieldAvg',
        'weightFieldEvenness',
        'growthRate',
    ];
}
