<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKeyTrait;

class ChickenImport extends Model
{
    use HasFactory;
	use HasCompositePrimaryKeyTrait;//使用我们自己的复合索引

    // protected $primaryKey = ['id', 'm_KUNAG'];
    // public $incrementing = false;

    protected $fillable = [
        'id',
        'm_KUNAG',
        'contract_id',
        'date',
        'species',
        'quantity',
        'gift_quantity',
        'amount',
        'actual_quantity',
        'price',
        'package_quantity',
        'package',
        'avg_weight',
        'actual_avg_weight',
        'total_weight',
        'picture_url',
        'address',
        'building_number',
        'creator',
        'last_editor',
        'modified_log',
        'chicken_origin',
        'chicken_sid',
    ];

    public function feedingLogs()
    {
        return $this->hasMany(FeedingLog::class);
    }

    public function breedingLogs()
    {
        return $this->hasMany(BreedingLog::class);
    }

    public function breedingPerformances()
    {
        return $this->hasMany(BreedingPerformance::class);
    }

    public function chickenOuts()
    {
        return $this->hasMany(ChickenOut::class);
    }

}
