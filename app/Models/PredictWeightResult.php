<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictWeightResult extends Model
{
    use HasFactory;
    protected $table = 'predict_weight_result';
    protected $fillable = [
        'contracts_id',
        'batchNumber',
        'sid',
        'title',
        'start',
    ];

    // 如果有需要，可以在這裡定義任何模型關聯
}

