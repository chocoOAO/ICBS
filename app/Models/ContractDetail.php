<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function createContractDetailByKey(Contract $contract, $key, $value) // 創建新的合約和合約詳情。(所謂「創建」包含了 '複製合約' 或 '建立新合約'。)
    {
        $contractDetailType = DetailType::firstOrCreate(['name' => $key]);

        $contractDetail = ContractDetail::firstOrNew(['contract_id' =>  $contract->id, 'detail_type_id' => $contractDetailType->id]); // 取得或創建 ContractDetail
        $contractDetail->detail_type_id = $contractDetailType->id;
        $contractDetail->value = $value; // 更新或設置 ContractDetail 的屬性
        $contractDetail->save(); // 保存 ContractDetail
    }

    public static function editContractDetailByKey(Contract $contract, $key, $value) // 編輯修改合約
    {
        $Search_1 = DB::table('z_cus_kna1s')->where('m_KUNAG', '=', $contract['m_KUNAG'])->get()->toArray(); // 依靠m_KUNAG代號搜尋
        $Search_2 = DB::table('z_cus_kna1s')->where('m_NAME', '=', $contract['name_b'])->get()->toArray(); // 依靠m_NAME名稱搜尋
        // dd($Search_1, $Search_2, $contract['m_KUNAG'], $contract['name_b']);
        if (empty($Search_1) && empty($Search_2)){ // 利用m_KUNAG代號或m_NAME名稱都沒有從z_cus_kna1s資料庫中找到相對應的資料。
            $z_cus_kna1 = [
                "m_KUNAG" => $contract['name_b'], //暫時先m_KUNAG欄位替換成同乙方名稱。(當然也可以寫成null，但必須要再測試是否會有錯誤。)
                "m_NAME" => $contract['name_b'],
                "m_ADDSC" => null,
                "created_at" => date('Y-m-d H:i:s'), // 格式化为年-月-日 时:分:秒,
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $contract['name_b'] = $z_cus_kna1['m_NAME'];
        } else{
            if (!empty($Search_1)){
                $z_cus_kna1 = $Search_1;
            } elseif (!empty($Search_2)){
                $z_cus_kna1 = $Search_2;
            }
            $z_cus_kna1 = $z_cus_kna1[0]; //很特別
            $contract['name_b'] = $z_cus_kna1->m_NAME;
        }
        $contract->save();
        $contractDetailType = DetailType::firstOrCreate(['name' => $key]);
        $contractDetail = ContractDetail::where('contract_id', '=',  $contract->id)->where('detail_type_id', '=', $contractDetailType->id);
        $contractDetail->update(['value' => $value]);
    }

    public static function getAddress(Contract $contract)
    {
        $contractDetail = ContractDetail::where('contract_id', '=',  $contract->id)->where('detail_type_id', '=', 2)->get();
        return $contractDetail[0]->value;
    }
}
