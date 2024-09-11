<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ["number","source","traceability","weighing_date","chicken_imports_id","account_number","breeder", "livestock_farm_name","batch","car_number","description","kilogram_weight","catty_weight","total_of_birds", "average_weight","down_chicken", "death", "discard", "stinking_claw", "dermatitis", "stinking_chest", "residue", "price_of_newspaper","unit_price","notes"];
}