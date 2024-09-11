<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = ["account_number", "account_date", "weighinh_date", "batch", "breeder", "livestock_farm_name", "shift", "total_of_kilogram", "total_of_birds", "quotation", "fee", "price", "down_chicken", "death", "discard", "stinking_claw", "stinking_chest", "dermatitis", "residue", "memo"];
}
