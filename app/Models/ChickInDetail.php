<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["contract_id", "type", "data"];

    public function detailType() {
        return $this->belongsTo(DetailType::class, 'detail_type_id', 'id');
    }

    public static function createContractDetailByKey(Contract $contract, $key, $value)
    {
        $contractDetailType = DetailType::firstOrCreate(['name' => $key]);

        $contractDetail = ContractDetail::firstOrNew(['contract_id' =>  $contract->id, 'detail_type_id' => $contractDetailType->id]);
        $contractDetail->detail_type_id = $contractDetailType->id;
        $contractDetail->value = $value;
        $contractDetail->save();
    }

    public static function editContractDetailByKey(Contract $contract, $key, $value)
    {
        $contractDetailType = DetailType::firstOrCreate(['name' => $key]);

        $contractDetail = ContractDetail::where('contract_id', '=',  $contract->id)->where('detail_type_id', '=', $contractDetailType->id);
        $contractDetail->update(['value' => $value]);
    }

}
