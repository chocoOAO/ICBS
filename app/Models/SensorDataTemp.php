<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorDataTemp extends Model
{
    use HasFactory;

    protected $table = 'sensor_data_temp';

    protected $fillable = [
        'batchNumber',
        'Date',
        'time',
        'sensorID',
        'temperature',
    ];
}
