<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorDataNh3 extends Model
{
    use HasFactory;

    protected $table = 'sensor_data_nh3';

    protected $fillable = [
        'batchNumber',
        'Date',
        'time',
        'sensorID',
        'nh3',
    ];
}
