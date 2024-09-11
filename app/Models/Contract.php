<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["m_NAME", "name_b", "m_KUNAG", "type", "begin_date", "end_date", "bank_name", "bank_branch", "bank_account", "salary", "office_tel", "home_tel", "mobile_tel", "creator"];

    /**
     * Get the type name.
     *
     * @return String
     */
    protected function getTypeNameAttribute(): String
    {
        if ($this->type == 1) return "保價計價";
        if ($this->type == 2) return "代養計價";
        if ($this->type == 3) return "合作飼養計價";
    }

    public function chickenImports()
    {
        return $this->hasMany(ChickenImport::class);
    }

    public function chickenVerifies()
    {
        return $this->hasMany(ChickenVerify::class);
    }

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
