<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreedingStandard extends Model
{
    use HasFactory;

    protected $fillable = [
        'species',
        'standard_year',
        'age',
        'avg_year',
        'daily_gain',
    ];
}

