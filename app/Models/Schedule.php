<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["m_NAME", "name_b", "type", "begin_date", "end_date", "bank_name", "bank_branch", "bank_account", "salary", "office_tel", "home_tel", "mobile_tel"];
    // protected $fillablea = ["Chick_in_number","Gift_number","Total_price","Average_weight_kg","Total_weight_kg"];

    // 供應廠商、批號、日期、項目[i]、客戶[i]、入雛時間[ｉ]、入雛量　贈送量　一周死亡　單價　手續費　總金額　備註　
    // 圖片：總經理簽名 副總簽名 協理簽名 經理簽名 課長簽名 業務人員簽名 客戶簽收



    /**
     * Get the type name.
     *
     * @return String
     */
    // protected function getTypeNameAttribute(): String
    // {
    //     if ($this->type == 1) return "保價計價";
    //     if ($this->type == 2) return "代養計價";
    //     if ($this->type == 3) return "合作飼養計價";
    // }
}
