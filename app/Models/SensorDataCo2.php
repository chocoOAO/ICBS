<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorDataCo2 extends Model
{
    use HasFactory;

    protected $table = 'sensor_data_co2';

    protected $fillable = [
        'batchNumber',
        'Date',
        'time',
        'sensorID',
        'co2',
    ];
}
