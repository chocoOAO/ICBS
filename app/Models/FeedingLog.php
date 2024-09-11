<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'chicken_import_id',
        'building_number',
        'm_KUNAG',
        'date',
        'feed_type',
        'feed_item',
        'feed_quantity',
        'feed_cumulant',
        'add_antibiotics',
        'feeding_efficiency',
    ];

    public static function creareUserSetting($user_id, $table_name, $column_name)
    {
        $userSetting = UserSetting::firstOrCreate(['user_id' => $user_id, 'table_name' => $table_name, 'column_name' => $column_name]);
    }
}
