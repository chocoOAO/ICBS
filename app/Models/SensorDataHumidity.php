<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorDataHumidity extends Model
{
    use HasFactory;

    protected $table = 'sensor_data_humidity';

    protected $fillable = [
        'batchNumber',
        'Date',
        'time',
        'sensorID',
        'humidity',
    ];
}
