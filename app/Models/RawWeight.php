<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'batchNumber',
        'Date',
        'time',
        'sid',
        'sensorID',
        'weight',
    ];
    public static function getWeightData($importId, $startDates)
    {
        $result = collect();

        foreach ($startDates as $startDate) {
            $log = self::where('Date', $startDate)
                ->where('batchNumber', $importId)
                ->orderBy('weight') // 按weight升序排序
                ->select('Date', 'weight')
                ->first();

            if ($log) {
                $result->push($log);
            }
        }

        return $result;
    }
}
