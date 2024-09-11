<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ZCusKna1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_KUNAG',
        'm_NAME',
        'm_ADDSC',
    ];
}
