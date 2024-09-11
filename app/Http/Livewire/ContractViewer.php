<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Models\ContractDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ContractViewer extends Component
{
    public $data;
    public $extraData;
    public $contractType;
    public $isView;
    public $isEdit;
    public $isCopy;

    // 外面進來的資料
    public $contract;
    public $contract_details;
    public $RemindMessage = null; # 預設值


    public function mount(Contract $contract, Request $request)
    {
        if (!isset($contract) || $contract == null) {
            return;
        }

        $this->isEdit = isset($request->isEdit) ? $request->isEdit : false;

        $this->isCopy = isset($request->isCopy) ? $request->isCopy : false;

        $this->contract = $contract;

        // 重新組合細節資料
        $contractDetails = ContractDetail::with('detailType')->where('contract_id', $contract->id)->get();

        $this->contract_details = $contractDetails->mapWithKeys(function ($item) {
            return [$item->detailType->name => $item->value];
        });

        $this->data = $this->contract->toArray();
        $this->extraData = $this->contract_details->toArray();
        $this->isView = $this->contract->type;
        $this->contractType = $this->contract->type;
    }

    public function submit()
    {
        // 確認當前用戶是否有權限編輯合約。
        if (!Gate::allows('edit-contract', $this->contract)) {
            Gate::authorize('edit-contract', $this->contract);
        }

        if ($this->data['end_date'] < $this->data['begin_date']){
            throw new \Exception(sprintf("合約的有效期限要求「結束日期」必須在「開始日期」之後。您目前輸入的結束日期為%s、開始日期則為%s，這是不符合要求的。請重新設定以保證結束日期晚於開始日期。", $this->data['end_date'], $this->data['begin_date']));
        }

        if ($this->contractType == 3){
            // 專為 contractType == 3 設計，用來檢查使用者輸入的乙方名稱是否存在於z_cus_kna1s資料庫中。
            $this->contract->name_b = $this->data['name_b'];
            if (DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->exists()){ 
                $this->data['m_KUNAG'] = DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->first('m_KUNAG')->m_KUNAG; // 能根據乙方名稱從z_cus_kna1s找到資料，將m_KUNAG根據所找到的資料替換成代號。
            } else{
                $this->data['m_KUNAG'] =  $this->data['name_b']; // 否則就將m_KUNAG欄位替換成同乙方名稱。(當然也可以寫成null，但必須要再測試是否會有錯誤。)
            }
        } else{
            // $contractType == 1保價計價(停用) 或 $contractType == 2代養計價時，從z_cus_kna1s資料庫中，根據 m_KUNAG 獲取 m_NAME，然後將其賦值給 $this->data['name_b]。
            if ( !isset($this->data['m_KUNAG']) ) { dd('沒有選擇乙方對象。請按一下畫面繼續編輯。'); }
            $this->data['name_b'] = DB::table('z_cus_kna1s')->where('m_KUNAG', $this->data['m_KUNAG'])->first('m_NAME')->m_NAME;
        }

        $Verification = $this->VerifyData_numeric($this->extraData); //這段主要是檢查extraData資料是否符合數字格式
        if ($Verification != '所有數據都有效。'){dd($Verification);}

        // 如果是複製操作，創建新的合約和合約詳情。
        if ($this->isCopy) {

            try{
                $contract = Contract::Create($this->data);
            } catch (QueryException $e) {
                // 检查 SQLSTATE 错误代码
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1406) {                
                    throw new \Exception('乙方名稱過長，請簡化輸入！'); // 发生数据过长的错误
                }
                dd('error', '数据库错误！', $e->getMessage()); // 处理其他类型的数据库错误
            }
            
            foreach ($this->extraData as $key => $value) {
                ContractDetail::createContractDetailByKey($contract, $key, $value);
            }
        }
        // 如果是編輯操作，更新現有合約和合約詳情。
        else if ($this->isEdit) {
            $this->contract->update($this->data);
            foreach ($this->extraData as $key => $value) {
                ContractDetail::editContractDetailByKey($this->contract, $key, $value);
            }
        }
        return redirect('contracts'); // 重定向到合約列表頁面。
    }

    public function render()
    {
        return view('livewire.contract-viewer');
    }

    public function exportPDF()
    {
        // $this->data 會對應到 contracts;
        return redirect()->route('export-pdf', [
            'type' => 'contract',
            'contract' => $this->contract->id,
            'contract_details' => $this->contract_details->toArray(),
        ]);
    }

    public function Verify_m_KUNAG() // 專為 contractType == 3 設計，用來檢查使用者輸入的乙方名稱是否存在於z_cus_kna1s資料庫中。
    {
        if (isset($this->data['name_b']) && !empty($this->data['name_b'])) {
            $RemindMessage = DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->exists();  // 要注意是m_NAME，用名字來找資料。
            if (!$RemindMessage) {
                $this->RemindMessage = '未能從資料庫中找到对应的乙方对象，請留意對象是否輸入正確。'; // 设置错误消息提醒使用者
            } else{
                $this->RemindMessage = null;
            }
        } else {
            $this->RemindMessage = '未輸入乙方对象。'; // 设置错误消息提醒使用者
        }
    }

    public function VerifyData_numeric($extraData) //這段主要是檢查extraData資料是否符合數字格式
    {
        foreach ($extraData as $key => $value) {
        // 检查$key是否包含'chicken_weight'這個字眼 且 $value是否为数字
            if (strpos($key, 'chicken_weight_kg') !== false && !is_numeric($value) && trim($value) !== '') {
                return '飼養報酬對照表的毛雞規格(KG)欄位' . $key . '發生錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'chicken_allowance_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '飼養報酬對照表的飼養報酬(元/羽)欄位' . $key . '發生錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'trading_market_table') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第四點毛雞每斤計價方式' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'discount_reward') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第七點雛雞折扣回饋' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'Feedback') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第八點' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_big_chicken_wieght') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超大雞部份的公斤數(kg)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_big_chicken_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超大雞部份的價格(元/台斤)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_little_chicken_wieght') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超小雞部份的公斤數(kg)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_little_chicken_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超小雞部份的價格(元/台斤)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_SmellyClaw') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]3.1臭爪部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_Dermatitis') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]3.2皮膚炎部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_smelly_breasts') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]臭胸部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
        }
        return '所有數據都有效。'; // 如果所有的值都是数字
    }
}
