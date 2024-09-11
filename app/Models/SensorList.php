<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorList extends Model
{
    use HasFactory;

    // 因為資料表名稱不符合預設，所以要另外指定
    protected $table = 'sensorlist'; // 資料表名稱

    //'batchNumber' => $batchNumber,
    //'sensorType' => $data['sensorType'],
    //'sensorID' => $data['sensorID'],
    protected $fillable = ['batchNumber', 'sensorType', 'sensorID', 'sid', 'date'];
}
