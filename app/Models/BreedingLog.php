<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreedingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'chicken_import_id',
        'date',
        'age',
        'disuse',
        'breeding_rate',
        'am_avg_weight',
        'pm_avg_weight',
        'building_number',
        'creator',
        'last_editor',
        'modified_log',
    ];

    public static function creareUserSetting($user_id, $table_name, $column_name)
    {
        $userSetting = UserSetting::firstOrCreate(['user_id' => $user_id, 'table_name' => $table_name, 'column_name' => $column_name]);
    }
}
