<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\ContractDetail;
use App\Models\Test;
use App\Models\ChickenOut;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Settlement extends Component
{

    public $settlementData; //只讀test資料庫的第一筆
    public $settlementData2; //讀test資料庫全部
    //*---------------

    public Collection $inputs;
    public Collection $tests;
    public Collection $tests1;

    public Collection $importData;
    public Contract $contract;

    public $contract_data;
    public $address;
    public $Breeding_cost = [];
    public $tmpdata = [];

    public $contractDetails;
    public $total_percentage_product;

    public $importNum = -1;
    public int $stincky_claw;
    public $stincky_opai;
    public $skin_disease;

    public $total_weight = 0;
    public $total_catty_weight = 0;
    public $total_amount = 0;
    public $total_avg_weight = 0;
    public $total_down_chicken = 0;
    public $total_death_chicken = 0;
    public $total_abandoned_weight = 0;
    public $total_loan = 0;
    // -----------------------------%
    public $total_stinking_claw = 0; //臭爪%
    public $total_stinking_chest = 0; //臭胸%
    public $total_dermatitis = 0; //皮膚炎%

    public $chick_discount = 0; //雛雞折扣
    public $eliminate_chicken_deductions = 0; //剔除雞扣款
    public $dead_chickens_deductions = 0; //死雞扣款
    public $stinky_claw_deduction = 0; //臭爪扣款
    public $stinky_stinking_chest = 0; //臭胸扣款
    public $stinky_dermatitis = 0; //皮膚炎扣款
    public $maoji_car_subsidies = 0; //毛雞車越縣補助
    public $extra_large_chicken = 0 ; //超大雞
    public $total_deduction_amount = 0; //總扣款
    public $deductions = [];//部分扣款
    public $deductions_absorb = [];//部分扣款吸收
    public $numbers = [];//
    //------------------------------------------------------
    // 新增"額外扣除金額"、"額外加項金額"與"說明"項目
    public $Extra_Deduction_inputs;
    public $Extra_Plus_inputs;
    public $Extra_Note_inputs;
    //------------------------------------------------------
    public $batch_showOptions_array = array('breeder' => false, 'weighing_date' => false); # 用來控制 飼養主 及 過磅日期 的下拉式選單，預設值為關閉。
    public $BatchOptions = []; # 批次選單
    public $WeighingDateOptions = array(); # 過磅日期選單
    public $breeder = -1;

    public $Unselection_AccountNumber = [];
    public $Selected_AccountNumber = [];

    // 以下這邊是要刪除的假資料、假參數，先暫時借用，與學長學姊討論後再刪除。
    public $account_number = "未選擇";
    public $account_date = "2024/01/12";
    public $livestock_farm_name = "假資料";
    public $quotation = "假資料";
    public $fee = "假資料";
    public $weighing_date = "假資料";
    public $death = "假資料";
    public $discard = "假資料";
    public $stinking_claw = "假資料";
    public $stinking_chest = "假資料";
    public $dermatitis = "假資料";
    public $residue = "假資料";

    public function render()
    {
        $show_flag = in_array($this->account_number, $this->Selected_AccountNumber);
        return view('livewire.settlement', [
            'settlementData' => $this->settlementData,  // 傳遞 settlementData 到視圖中
            'settlementData2'=> $this->settlementData2,
            'address' => $this->address,
            'show_flag' => $show_flag,
        ]);
    }

    public function mount(Contract $contract, Request $request)
    {

         $this->settlementData2 = Test::get();
        if (session()->has('settlementData') && session('settlementData') !== null) {
            $this->settlementData = session('settlementData');
            $this->settlementData2 = DB::table('tests')
                                ->select('*')
                                ->where('account_number', '=', $this->settlementData->account_number)
                                ->get();
            if (isset($this->settlementData->notes) && $this->settlementData->notes !== null) {
                $contract_id = DB::table('contracts')
                    ->select('id')
                    ->where('m_KUNAG', '=', $this->settlementData->notes)
                    ->value('id');
            } else {
                $contract_id = null; // 或者設置一個預設值
            }
        } else {
            $this->settlementData = Test::where('id', '1')->first();
            $contract_id = null; // 初始化 $contract_id 為 null 或其他適當的預設值
        }
        $specificContractId = $contract_id;
        $this->contract_data = DB::table('contract_details')
                                ->join('contracts', 'contract_details.contract_id', '=', 'contracts.id')
                                ->select('contract_details.*')
                                ->where('contracts.id', '=', $specificContractId)
                                ->get();
        
        $this->Breeding_cost = array_fill(0, 10, 0);
        $this->tmpdata = array_fill(0, 50, 0);

        $this->stincky_claw = 0;
        $this->stincky_opai = 0;
        $this->skin_disease = 0;
        $this->contract = $contract;
        $this->weighing_date = $request->weighing_date;

        if ($request->import != -1 && $request->import != null) { #當使用者已經輸入資料時
            $this->account_number = $request->import;
            $this->breeder = $request->breeder;
            $this->Unselection_AccountNumber = $request->Unselection_AccountNumber;
            $this->Selected_AccountNumber = $request->Selected_AccountNumber;
            $this->batch_showOptions_array = $request->batch_showOptions_array;
        } else {
            // 從chickenOuts找出這筆合約的第一筆資料時，卻為null，推測在chickenOuts(抓雞派車單)沒有資料，更甚者可能連chickenImports(飼養入雛表)也沒有資料。
            if ($contract->chickenOuts->where('contract_id', $contract->id)->first() == null) {
                $errorMessage = '請您再次確認 抓雞派車單 或 飼養入雛表 是否已確實填寫資料！';
                $this->addError('No_ImportNum', $errorMessage); // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('No_ImportNum')來顯示。
                return;
            }
            $this->importNum = $contract->chickenOuts->where('contract_id', $contract->id)->first()->chicken_import_id; # chickenImports
            $this->breeder = '請先選擇飼主';

            // $this->Unselection_chickenImportId =  $contract->chickenOuts->where('contract_id', $contract->id)->pluck('chicken_import_id')->unique()->toArray(); # 從chickenOuts資料表中，抓取這筆合約(contract_id)下的所有批號，並顯示在列表。
        }

        $this->BatchOptions = DB::table('tests')->select('breeder')->distinct()->get()->toArray(); // 抓取tests資料庫中的所有breeder號碼。
        $this->BatchOptions = json_decode(json_encode($this->BatchOptions), true); // 轉格式不轉的話不是一般的array前面會多帶一個+號
        $this->WeighingDateOptions = DB::table('tests')->where('breeder', $this->breeder)->select('weighing_date')->distinct()->get()->toArray(); // 根據breeder號碼，抓取tests資料庫中的所有breeder號碼。
        $this->WeighingDateOptions = json_decode(json_encode($this->WeighingDateOptions), true);

        if ($request->breeder != null && $request->weighing_date != null){
            $this->Unselection_AccountNumber = DB::table('tests')->where('breeder', $this->breeder)->where('weighing_date', $this->weighing_date)->select('account_number')->distinct()->get()->toArray(); // 根據breeder及weighing_date過磅日期，抓取tests資料庫中的所有account_number。
        }
        else{
            $this->Unselection_AccountNumber = DB::table('tests')->select('account_number')->distinct()->get()->toArray(); # 從settlements資料表中，抓取所有account_number結帳單號，並顯示在列表。
        }

        $this->Unselection_AccountNumber = array_column($this->Unselection_AccountNumber, 'account_number');
        $this->Unselection_AccountNumber = array_unique($this->Unselection_AccountNumber); # array_unique:移除陣列中重複的值並回傳新的陣列
        if ($this->Selected_AccountNumber == null) {$this->Selected_AccountNumber = [];}
        $this->Selected_AccountNumber = array_unique($this->Selected_AccountNumber); # array_unique:移除陣列中重複的值並回傳新的陣列
        $this->Unselection_AccountNumber = array_diff($this->Unselection_AccountNumber, $this->Selected_AccountNumber);

        $this->importData = $contract->chickenImports->where('contract_id', $contract->id); # 因為下面要計算amount，sum(amount)，所以這裡一定要用chickenImports。
        $this->inputs = collect($contract->chickenOuts->where('contract_id', $contract->id)->where('chicken_import_id', $this->importNum)); # 我在這邊新增contract_id的檢查，從chickenOuts撈取資料。

        $this->tests = collect($contract->chickenOuts->where('contract_id', $contract->id)->where('chicken_import_id', $this->importNum));

        if ($this->inputs->count() == 0) {
            $this->addInput();
        }

        // 小計：各欄位加總
        //----------------------------------------------------------------------
        $total_percentage_stinking_claw = 0;
        $total_percentage_stinking_chest = 0;
        $total_percentage_dermatitis = 0;
        $total_birds = 0;
        // 小計：各欄位加總
        foreach ($this->settlementData2 as $value){
            $percentage_stinking_claw = ($value->stinking_claw ?? 0) / 100; //如果提取值是null就設定為0
            $percentage_stinking_chest = ($value->stinking_chest ?? 0) / 100;
            $percentage_dermatitis = ($value->dermatitis ?? 0) / 100;

            $number_of_birds = $value->total_of_birds; 
            $total_percentage_stinking_claw += $percentage_stinking_claw * $number_of_birds;
            $total_percentage_stinking_chest += $percentage_stinking_chest * $number_of_birds;
            $total_percentage_dermatitis += $percentage_dermatitis * $number_of_birds;
            $total_birds += $number_of_birds;
        }
        $this->total_weight = $this->settlementData2->sum('kilogram_weight');
        $this->total_catty_weight = $this->settlementData2->sum('catty_weight');
        // 小計：總隻數、平均重量
        $this->total_amount =  $total_birds;
        if($this->total_amount==0){$this->total_amount=1;}//保護機制

        $this->total_avg_weight = $this->total_weight / $this->total_amount;
        $this->total_down_chicken = $this->settlementData2->sum('down_chicken');
        $this->total_death_chicken = $this->settlementData2->sum('death');
        $this->total_abandoned_weight = $this->settlementData2->sum('discard');

        //雛雞折扣
        $reward = intval(optional(ContractDetail::where('detail_type_id', 115)
                ->where('value', '<', 20)
                ->first())->value);
        $this->chick_discount=round(($this->total_amount-$this->total_death_chicken- $this->total_abandoned_weight)*$reward);
        // $this->chick_discount=$this->chick_discount+1;
        //雛雞折扣  
        $this->total_stinking_claw = round(($total_percentage_stinking_claw/$this->total_amount), 2)*100;
        $this->total_stinking_chest = round(($total_percentage_stinking_chest/$this->total_amount), 2)*100;
        $this->total_dermatitis = round(($total_percentage_dermatitis/$this->total_amount), 2)*100;
        
        // 剔除雞扣款-------------------------------------------
        $this->eliminate_chicken_deductions = round($this->total_abandoned_weight * round($this->total_avg_weight,2) / 0.6  * $this->settlementData2->first()->unit_price);
        // 剔除雞扣款-------------------------------------------
        
        // 死雞扣款-------------------------------------------
        $this->dead_chickens_deductions = 0;
        $month = date('m', strtotime($this->weighing_date));
        if($month>= optional(ContractDetail::where('detail_type_id', 197)->first())->value && $month<=optional(ContractDetail::where('detail_type_id', 198)->first())->value){
            $Allowance = optional(ContractDetail::where('detail_type_id', 199)->first())->value; //容許量
        }
        else{
            $Allowance = optional(ContractDetail::where('detail_type_id', 202)->first())->value; //容許量
        }
        
        foreach ($this->settlementData2 as $value){
            if($value->death>$Allowance){
                //dd(round($value->average_weight,2));
                $this->dead_chickens_deductions = $this->dead_chickens_deductions + (($value->death- $Allowance)*round($this->total_avg_weight,2))/0.6*$value->unit_price;
            }
        }
        $this->dead_chickens_deductions=round($this->dead_chickens_deductions);

        // 死雞扣款-------------------------------------------
        
        // 超大雞扣款-------------------------------------- -----
        $this->extra_large_chicken = 0;
        $this->total_avg_weight = round($this->total_avg_weight, 2);
        if ($this->total_avg_weight >= (float)(optional(ContractDetail::where('detail_type_id', 121)->first())->value ?? 0) && 
            $this->total_avg_weight <= (float)(optional(ContractDetail::where('detail_type_id', 122)->first())->value ?? 0)) {
            
            $this->extra_large_chicken = $this->extra_large_chicken + ($this->total_catty_weight * (float)(optional(ContractDetail::where('detail_type_id', 123)->first())->value ?? 0));
        } elseif ($this->total_avg_weight >= (float)(optional(ContractDetail::where('detail_type_id', 124)->first())->value ?? 0) && 
                $this->total_avg_weight <= (float)(optional(ContractDetail::where('detail_type_id', 125)->first())->value ?? 0)) {
            
            $this->extra_large_chicken = $this->extra_large_chicken + ($this->total_catty_weight * (float)(optional(ContractDetail::where('detail_type_id', 126)->first())->value ?? 0));
        } elseif ($this->total_avg_weight >= (float)(optional(ContractDetail::where('detail_type_id', 127)->first())->value ?? 0) && 
                $this->total_avg_weight <= (float)(optional(ContractDetail::where('detail_type_id', 128)->first())->value ?: 99999999)) { //999999是為了確保最大。

            $this->extra_large_chicken = $this->extra_large_chicken + ($this->total_catty_weight * (float)(optional(ContractDetail::where('detail_type_id', 129)->first())->value ?? 0)); 
        }
        $this->extra_large_chicken = round($this->extra_large_chicken); 

        // 超大雞扣款-------------------------------------------
        // 越縣補助---------------------------------------------
        $detail = $this->contract_data->firstWhere('detail_type_id', 2);
        if ($detail) {
            $this->address = $detail->value;
        } else {
            $this->address = 0; // 或者設置為其他適當的預設值
        }
        $this->maoji_car_subsidies = 0; 
        $subsidies = [
            "新竹" => 500,
            "桃園" => 1000,
            "雲林" => 500,
            "嘉義" => 1000,
            "台南" => 1500,
            "屏東" => 2500,
            "南投" => 300, 
        ]; 
        $this->maoji_car_subsidies = $this->getSubsidyAmount($this->address, $subsidies);   
        $this->maoji_car_subsidies = $this->maoji_car_subsidies*$this->settlementData2->count();
        // 越縣補助---------------------------------------------

        //額外的扣除金額(由使用者輸入的資料)---------------------------------------------   
        // 存取資料庫: settlements---------------------------------------------  
        try {
            // MySQL查詢代碼
            $this->Extra_Deduction_inputs = DB::table('settlements')
                                                ->select('id', 'account_number', 'deduction_note', 'user_deduction_amount')
                                                ->where('account_number', '=', $this->account_number)
                                                ->whereNotNull('deduction_note')  // 确保deduction_note不是NULL
                                                ->whereNotNull('user_deduction_amount')  // 确保user_deduction_amount不是NULL
                                                ->where('deduction_note', '!=', '')  // 确保deduction_note不是空字符串
                                                ->where('user_deduction_amount', '!=', '')  // 确保deduction_note不是空字符串
                                                ->get();
        } catch (\Exception $e) {
            // 處理錯誤，如記錄或顯示錯誤消息
            dd('查詢錯誤', 'An error occurred while reading from MySQL: ' . $e->getMessage());
            // Log::error($e->getMessage());
            // return back()->withErrors('查詢錯誤');
        }

        // 讓使用者新增資訊的資料
        $Deduction_Data = [
            "account_number" => $this->account_number,
            "deduction_note" => "",  // 请输入内容
            "user_deduction_amount" => 0,
        ];
        $this->Extra_Deduction_inputs->push($Deduction_Data);
        //額外的扣除金額----------------------------------------------------------------    

        //加項金額(由使用者輸入的資料)--------------------------------------------- 
        try {
            // MySQL查詢代碼
            $this->Extra_Plus_inputs = DB::table('settlements')
                                                ->select('id', 'account_number', 'plus_note', 'plus_amount')
                                                ->where('account_number', '=', $this->account_number)
                                                ->whereNotNull('plus_note')  // 确保plus_note不是NULL
                                                ->whereNotNull('plus_amount')  // 确保plus_amount不是NULL
                                                ->where('plus_note', '!=', '')  // 确保plus_note不是空字符串
                                                ->where('plus_amount', '!=', '')  // 确保plus_amount不是空字符串
                                                ->get();
        } catch (\Exception $e) {
            // 處理錯誤，如記錄或顯示錯誤消息
            dd('查詢錯誤', 'An error occurred while reading from MySQL: ' . $e->getMessage());
            // Log::error($e->getMessage());
            // return back()->withErrors('查詢錯誤');
        }

        // 讓使用者新增資訊的資料
        $Plus_Data = [
            "account_number" => $this->account_number,
            "plus_note" => "",  // 请输入内容
            "plus_amount" => 0,
        ];
        $this->Extra_Plus_inputs->push($Plus_Data);
        //加項金額
        
        //補充說明事項(由使用者輸入的資料)---------------------------------------------   
        // 存取資料庫: settlements--------------------------------------------- 
        try {
             // MySQL查詢代碼
            $this->Extra_Note_inputs = DB::table('settlements')
                                            ->select('id', 'account_number', 'other_note')
                                            ->where('account_number', '=', $this->account_number)
                                            ->whereNotNull('other_note')  // 确保livestock_farm_name不是NULL
                                            ->where('other_note', '!=', '')  // 确保livestock_farm_name不是空字符串
                                            ->get();
        } catch (\Exception $e) {
            // 處理錯誤，如記錄或顯示錯誤消息
            dd('查詢錯誤', 'An error occurred while reading from MySQL: ' . $e->getMessage());
            // Log::error($e->getMessage());
            // return back()->withErrors('查詢錯誤');
        }
        // 讓使用者新增資訊的資料
        $Note_Data = [
            "account_number" => $this->account_number,
            "other_note" => "", 
        ];
        $this->Extra_Note_inputs->push($Note_Data);
        //補充說明事項---------------------------------------------   
        //臭爪
        foreach ($this->settlementData2 as $value){
            //dd(optional(ContractDetail::where('detail_type_id', 156)->first())->value);
            if($value->stinking_claw <= doubleval(optional(ContractDetail::where('detail_type_id', 132)->first())->value ?? 0)){
                $this->stinky_claw_deduction += 0;
            }
            elseif($value->stinking_claw >= doubleval(optional(ContractDetail::where('detail_type_id', 133)->first())->value ?? 0) &&  $value->stinking_claw <= doubleval(optional(ContractDetail::where('detail_type_id', 134)->first())->value ?? 0)){
                $this->stinky_claw_deduction += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 137)->first())->value ?? 0;
            }
            elseif($value->stinking_claw >= doubleval(optional(ContractDetail::where('detail_type_id', 138)->first())->value ?? 0) &&  $value->stinking_claw <= doubleval(optional(ContractDetail::where('detail_type_id', 139)->first())->value ?? 0)){
                $this->stinky_claw_deduction += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 142)->first())->value ?? 0;
            }
            elseif($value->stinking_claw >= doubleval(optional(ContractDetail::where('detail_type_id', 143)->first())->value ?? 0) &&  $value->stinking_claw <= doubleval(optional(ContractDetail::where('detail_type_id', 144)->first())->value ?? 0)){
                $this->stinky_claw_deduction += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 147)->first())->value ?? 0;
            }
            elseif($value->stinking_claw >= doubleval(optional(ContractDetail::where('detail_type_id', 148)->first())->value ?? 0) &&  $value->stinking_claw <= doubleval(optional(ContractDetail::where('detail_type_id', 149)->first())->value ?? 0)){
                $this->stinky_claw_deduction += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 152)->first())->value ?? 0;
            }
            elseif($value->stinking_claw >= doubleval(optional(ContractDetail::where('detail_type_id', 153)->first())->value ?? 0 )){
                $this->stinky_claw_deduction += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 156)->first())->value ?? 0;
            }
            else{
                $this->stinky_claw_deduction = 0;
            }
        }
        //dd($this->stinky_claw_deduction);
        $this->stinky_claw_deduction = round($this->stinky_claw_deduction);
        //皮膚炎
        foreach ($this->settlementData2 as $value){
            //dd($value->dermatitis);
            if($value->dermatitis <= doubleval(optional(ContractDetail::where('detail_type_id', 157)->first())->value ?? 0)){
                $this->stinky_dermatitis += 0;
            }
            elseif($value->dermatitis >= doubleval(optional(ContractDetail::where('detail_type_id', 158)->first())->value ?? 0) &&  $value->dermatitis <= doubleval(optional(ContractDetail::where('detail_type_id', 159)->first())->value ?? 0)){
                $this->stinky_dermatitis += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 162)->first())->value ?? 0;
            }
            elseif($value->dermatitis >= doubleval(optional(ContractDetail::where('detail_type_id', 163)->first())->value ?? 0) &&  $value->dermatitis <= doubleval(optional(ContractDetail::where('detail_type_id', 164)->first())->value ?? 0)){
                $this->stinky_dermatitis += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 167)->first())->value ?? 0;
            }
            elseif($value->dermatitis >= doubleval(optional(ContractDetail::where('detail_type_id', 168)->first())->value ?? 0) &&  $value->dermatitis <= doubleval(optional(ContractDetail::where('detail_type_id', 169)->first())->value ?? 0)){
                $this->stinky_dermatitis += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 172)->first())->value ?? 0;
            }
            elseif($value->dermatitis >= doubleval(optional(ContractDetail::where('detail_type_id', 173)->first())->value ?? 0) &&  $value->dermatitis <= doubleval(optional(ContractDetail::where('detail_type_id', 174)->first())->value ?? 0)){
                $this->stinky_dermatitis += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 177)->first())->value ?? 0;
            }
            elseif($value->dermatitis >= doubleval(optional(ContractDetail::where('detail_type_id', 178)->first())->value ?? 0 )){
                $this->stinky_dermatitis += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 181)->first())->value ?? 0;
            }
            else{
                $this->stinky_dermatitis = 0;
            }
        }
        $this->stinky_dermatitis = round($this->stinky_dermatitis);
        //臭胸
        foreach ($this->settlementData2 as $value){
            //dd(optional(ContractDetail::where('detail_type_id', 156)->first())->value);
            if($value->stinking_chest <= doubleval(optional(ContractDetail::where('detail_type_id', 182)->first())->value ?? 0)){
                $this->stinky_stinking_chest += 0;
            }
            elseif($value->stinking_chest >= doubleval(optional(ContractDetail::where('detail_type_id', 183)->first())->value ?? 0) &&  $value->stinking_chest <= doubleval(optional(ContractDetail::where('detail_type_id', 184)->first())->value ?? 0)){
                $this->stinky_stinking_chest += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 185)->first())->value ?? 0;
            }
            elseif($value->stinking_chest >= doubleval(optional(ContractDetail::where('detail_type_id', 186)->first())->value ?? 0) &&  $value->stinking_chest <= doubleval(optional(ContractDetail::where('detail_type_id', 187)->first())->value ?? 0)){
                $this->stinky_stinking_chest += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 188)->first())->value ?? 0;
            }
            elseif($value->stinking_chest >= doubleval(optional(ContractDetail::where('detail_type_id', 189)->first())->value ?? 0) &&  $value->stinking_chest <= doubleval(optional(ContractDetail::where('detail_type_id', 190)->first())->value ?? 0)){
                $this->stinky_stinking_chest += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 191)->first())->value ?? 0;
            }
            elseif($value->stinking_chest >= doubleval(optional(ContractDetail::where('detail_type_id', 192)->first())->value ?? 0) &&  $value->stinking_chest <= doubleval(optional(ContractDetail::where('detail_type_id', 193)->first())->value ?? 0)){
                $this->stinky_stinking_chest += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 194)->first())->value ?? 0;
            }
            elseif($value->stinking_chest >= doubleval(optional(ContractDetail::where('detail_type_id', 195)->first())->value ?? 0 )){
                $this->stinky_stinking_chest += $value->kilogram_weight/0.6*optional(ContractDetail::where('detail_type_id', 196)->first())->value ?? 0;
            }
            else{
                $this->stinky_stinking_chest = 0;
            }
        }
        $this->stinky_stinking_chest = round($this->stinky_stinking_chest);
        foreach($this->settlementData2 as $key => $stData){
            $this->total_loan += (round($stData->catty_weight * $stData->unit_price));
        }
        $this->total_deduction_amount = $this->stinky_dermatitis + $this->stinky_stinking_chest + $this->stinky_claw_deduction + $this->eliminate_chicken_deductions + $this->dead_chickens_deductions + $this->chick_discount;

        //說明-臭爪讀取
        $distinctStinkingClawValues = $this->settlementData2->pluck('stinking_claw')->unique()->sortByDesc(function ($value) {
            return $value;      // 根据 stinking_claw 的值从大到小排序
        })->take(2)->values();
        
        for($i = 0; $i < count($distinctStinkingClawValues); $i++){
            $numbers_each = $this->settlementData2->whereIn('stinking_claw', $distinctStinkingClawValues[$i])->pluck('number');
            array_push($this->numbers, $numbers_each);
        }
        //dd($distinctStinkingClawValues);
        $stinky_claw_deduction_tmp;
        $deductions_deduction_absorb_tmp;
        foreach ($distinctStinkingClawValues as $value){
            if($value <= doubleval(optional(ContractDetail::where('detail_type_id', 132)->first())->value ?? 0)){
                $stinky_claw_deduction_tmp='不扣款';
                $deductions_deduction_absorb_tmp='公司全部吸收';
            }
            elseif($value >= doubleval(optional(ContractDetail::where('detail_type_id', 133)->first())->value ?? 0) &&  $value <= doubleval(optional(ContractDetail::where('detail_type_id', 134)->first())->value ?? 0)){
                $stinky_claw_deduction_tmp='扣'.optional(ContractDetail::where('detail_type_id', 137)->first())->value.'元/斤';
                $deductions_deduction_absorb_tmp='吸收'.optional(ContractDetail::where('detail_type_id', 136)->first())->value.'元/斤';
            }
            elseif($value >= doubleval(optional(ContractDetail::where('detail_type_id', 138)->first())->value ?? 0) &&  $value <= doubleval(optional(ContractDetail::where('detail_type_id', 139)->first())->value ?? 0)){
                $stinky_claw_deduction_tmp='扣'.optional(ContractDetail::where('detail_type_id', 142)->first())->value.'元/斤';
                $deductions_deduction_absorb_tmp='吸收'.optional(ContractDetail::where('detail_type_id', 141)->first())->value.'元/斤';
            }
            elseif($value >= doubleval(optional(ContractDetail::where('detail_type_id', 143)->first())->value ?? 0) &&  $value <= doubleval(optional(ContractDetail::where('detail_type_id', 144)->first())->value ?? 0)){
                $stinky_claw_deduction_tmp='扣'.optional(ContractDetail::where('detail_type_id', 147)->first())->value.'元/斤';
                $deductions_deduction_absorb_tmp='吸收'.optional(ContractDetail::where('detail_type_id', 146)->first())->value.'元/斤';
            }
            elseif($value >= doubleval(optional(ContractDetail::where('detail_type_id', 148)->first())->value ?? 0) &&  $value <= doubleval(optional(ContractDetail::where('detail_type_id', 149)->first())->value ?? 0)){
                $stinky_claw_deduction_tmp='扣'.optional(ContractDetail::where('detail_type_id', 152)->first())->value.'元/斤';
                $deductions_deduction_absorb_tmp='吸收'.optional(ContractDetail::where('detail_type_id', 151)->first())->value.'元/斤';
            }
            elseif($value >= doubleval(optional(ContractDetail::where('detail_type_id', 153)->first())->value ?? 0 )){
                $stinky_claw_deduction_tmp='扣'.optional(ContractDetail::where('detail_type_id', 156)->first())->value.'元/斤';
                $deductions_deduction_absorb_tmp='吸收'.optional(ContractDetail::where('detail_type_id', 155)->first())->value.'元/斤';
            }
            else{
                $stinky_claw_deduction_tmp='';
                $deductions_deduction_absorb_tmp='';
            }
            array_push($this->deductions,$stinky_claw_deduction_tmp);
            array_push($this->deductions_absorb,$deductions_deduction_absorb_tmp);    
            //dump($this->deductions);
            //dump($this->deductions_absorb);
        }
    }

    public function addInput()
    {
        $this->inputs->push([]);
    }

// 額外的扣除金額(由使用者輸入的資料)---------------------------------------------   
    // 存取資料庫: settlements--------------------------------------------- 
    public function addInput_Deduction() // 扣除金額的額外事項  // 新增使用者新增資訊的資料
    {
        try {
            $Deduction_Data = $this->Extra_Deduction_inputs->last();  // 获取最后一个元素  // $Deduction_Data = $this->Extra_Deduction_inputs[count($this->Extra_Deduction_inputs)-1];
            if (!isset($Deduction_Data['account_number'])) {$Deduction_Data['account_number'] = $this->account_number;} 
            if (!empty($Deduction_Data['deduction_note']) && !blank($Deduction_Data['deduction_note']) && trim($Deduction_Data['deduction_note']) !== ""){ // 防止輸入無效數據
                DB::table('settlements')->insert($Deduction_Data);
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        } catch (\Exception $e) {
            // 处理错误，如记录日志、显示错误消息等
            dd('error', 'An error occurred while saving data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'An error occurred while saving data: ' . $e->getMessage());
            // return redirect()->back()->withInput();
        }
    }

    public function update_Deduction() // 扣除金額的額外事項  // 更新使用者輸入的資訊
    {
        try {
            // 批量更新：參考chicken-out的component，就直接整批更新吧~ (當然可以改得更好，但考慮到版面，就先這樣寫吧~)
            foreach ($this->Extra_Deduction_inputs as $Deduction_input) {
                if (isset($Deduction_input['id']) && !empty($Deduction_input['id'])) {
                    DB::table('settlements')->where('id', $Deduction_input['id'])->update($Deduction_input); //  使用 DB::table() 是一种直接且有效的方法来处理数据库操作，尤其适用于不需要使用模型的场合。通过这种方式，可以保持代码简洁，并且直接控制数据库操作。
                }
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        }   catch (\Exception $e) {
            dd('error', 'Failed to update data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'Failed to update deductions: ' . $e->getMessage());
            // return redirect()->back();
        }
    }

    public function delete($index) // 指定settlements資料庫中的id進行刪除
    {
        try {
            if (isset($index) && !empty($index)  && $index > 0){
                DB::transaction(function () use ($index) { // 如果操作失败，整个事务将回滚，数据库状态保持不变，从而防止数据损坏或不一致。
                    DB::table('settlements')->where('id', $index)->delete(); //
                });
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        } catch (\Exception $e) {
            dd('error', 'Error deleting data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'Error deleting deduction: ' . $e->getMessage());  // 错误消息
            // return redirect()->back();  // 发生错误时重定向回原页面
        }
    }
// 額外的扣除金額(由使用者輸入的資料)---------------------------------------------

// 額外的加項金額 (由使用者輸入的資料)---------------------------------------------   
    // 存取資料庫: settlements--------------------------------------------- 
    public function addInput_Plus() // 加項金額的額外事項  // 新增使用者新增資訊的資料
    {
        try {
            $Plus_Data = $this->Extra_Plus_inputs->last();  // 获取最后一个元素  // $Deduction_Data = $this->Extra_Deduction_inputs[count($this->Extra_Deduction_inputs)-1];
            if (!isset($Plus_Data['account_number'])) {$Plus_Data['account_number'] = $this->account_number;} 
            if (!empty($Plus_Data['plus_note']) && !blank($Plus_Data['plus_note']) && trim($Plus_Data['plus_note']) !== ""){ // 防止輸入無效數據
                DB::table('settlements')->insert($Plus_Data);
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        } catch (\Exception $e) {
            // 处理错误，如记录日志、显示错误消息等
            dd('error', 'An error occurred while saving data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'An error occurred while saving data: ' . $e->getMessage());
            // return redirect()->back()->withInput();
        }
    }

    public function update_Plus() // 加項金額的額外事項  // 更新使用者輸入的資訊
    {
        try {
            foreach ($this->Extra_Plus_inputs as $Plus_input) {
                if (isset($Plus_input['id']) && !empty($Plus_input['id'])) {
                    DB::table('settlements')->where('id', $Plus_input['id'])->update($Plus_input); //  使用 DB::table() 是一种直接且有效的方法来处理数据库操作，尤其适用于不需要使用模型的场合。通过这种方式，可以保持代码简洁，并且直接控制数据库操作。
                }
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        }   catch (\Exception $e) {
            dd('error', 'Failed to update data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'Failed to update deductions: ' . $e->getMessage());
            // return redirect()->back();
        }
    }
// 額外的加項金額 (由使用者輸入的資料)---------------------------------------------  

//  補充說明事項(由使用者輸入的資料)---------------------------------------------   
    public function addInput_OtherNotes() // 說明的額外事項  // 新增使用者新增資訊的資料
        {
            try {
                $Note_Data = $this->Extra_Note_inputs->last();  // 获取最后一个元素 
                if (!empty($Note_Data['other_note']) && !blank($Note_Data['other_note']) && trim($Note_Data['other_note']) !== ""){ // 防止无效数据被存储。
                    if (!isset($Note_Data['account_number'])) {$Note_Data['account_number'] = $this->account_number;} 
                    DB::table('settlements')->insert($Note_Data) ;
                }
                return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
            } catch (\Exception $e) {
                // 处理错误，如记录日志、显示错误消息等
                dd('error', 'An error occurred while saving data: ' . $e->getMessage()); // 错误消息
                // session()->flash('error', 'An error occurred while saving data: ' . $e->getMessage());
                // return redirect()->back()->withInput();
            }
        }
    

    public function update_OtherNotes()  // 更新使用者指定的資訊   // 目前僅供"扣除金額的額外事項"使用！  
    {
        try {
            // 批量更新：參考chicken-out的component，就直接整批更新吧~ (當然可以改得更好，但考慮到版面，就先這樣寫吧~)
            foreach ($this->Extra_Note_inputs as $update_input) {
                if (isset($update_input['id']) && !empty($update_input['id'])) {
                    DB::table('settlements')->where('id', $update_input['id'])->update($update_input); //  使用 DB::table() 是一种直接且有效的方法来处理数据库操作，尤其适用于不需要使用模型的场合。通过这种方式，可以保持代码简洁，并且直接控制数据库操作。
                }
            }
            return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        }   catch (\Exception $e) {
            dd('error', 'Failed to update data: ' . $e->getMessage()); // 错误消息
            // session()->flash('error', 'Failed to update deductions: ' . $e->getMessage());
            // return redirect()->back();
        }
    }
//  補充說明事項(由使用者輸入的資料)---------------------------------------------   

    //計算越縣補助
    public function getSubsidyAmount($address, $subsidies){
        foreach ($subsidies as $district => $amount) {
            if (strpos($address, $district) !== false) {
                return $amount;
            }
        }
        return 0; // 如果沒有地區匹配，則返回 0
    }
    //計算等地
    public function grade()
    {
        $stincky_claw = $this->total_stinking_claw;
        $stincky_opai = $this->total_stinking_chest;
        $skin_disease = $this->total_dermatitis;

        $total = 0;
        //先計算臭爪的分數
        if ($stincky_claw <= 10) {
            $total = $total + 50;
        } elseif ($stincky_claw <= 15) {
            $total = $total + 40;
        } elseif ($stincky_claw <= 20) {
            $total = $total + 30;
        } elseif ($stincky_claw <= 25) {
            $total = $total + 20;
        } elseif ($stincky_claw <= 30) {
            $total = $total + 10;
        } else {
            $total = $total + 0;
        }
        //計算臭胸的分數
        if ($stincky_opai <= 1) {
            $total = $total + 35;
        } elseif ($stincky_opai <= 2) {
            $total = $total + 28;
        } elseif ($stincky_opai <= 3) {
            $total = $total + 21;
        } elseif ($stincky_opai <= 4) {
            $total = $total + 14;
        } elseif ($stincky_opai <= 5) {
            $total = $total + 7;
        } else {
            $total = $total + 0;
        }
        //計算皮膚炎的分數
        if ($skin_disease <= 1) {
            $total = $total + 15;
        } elseif ($skin_disease <= 2) {
            $total = $total + 12;
        } elseif ($skin_disease <= 3) {
            $total = $total + 9;
        } elseif ($skin_disease <= 4) {
            $total = $total + 6;
        } elseif ($skin_disease <= 5) {
            $total = $total + 3;
        } else {
            $total = $total + 0;
        }
        //把分數轉換成等第
        if ($total == 100) {
            $grade = '甲';
        } elseif ($total >= 80) {
            $grade = '乙';
        } elseif ($total >= 60) {
            $grade = '丙';
        } elseif ($total >= 40) {
            $grade = '丁';
        } elseif ($total >= 20) {
            $grade = '戊';
        } else {
            $grade = '己';
        }
        return $grade;
    }

    // 留意錯誤: The PHP GD extension is required, but is not installed.
    public function exportPDF()
    {
        
        //dd($this->settlementData2);
        // 儲存數據至 Session
        session([
            'exportData' => [
                'settlementData2' => $this->settlementData2,
                'grade' => $this->grade(),
                'type' => 'settlement',
                'contract_id' => $this->contract->id,
                'total_weight' => $this->total_weight,
                'total_amount' => $this->total_amount,
                'total_avg_weight' => $this->total_avg_weight,
                'total_down_chicken' => $this->total_down_chicken,
                'total_death_chicken' => $this->total_death_chicken,
                'total_abandoned_weight' => $this->total_abandoned_weight,
                'total_loan' => $this->total_loan,
                'settlementData2' => $this->settlementData2->toArray(),
                'account_number' => $this->account_number,
                'Selected_AccountNumber' => $this->Selected_AccountNumber,
                'total_catty_weight' => $this->total_catty_weight,
                'eliminate_chicken_deductions' => $this->eliminate_chicken_deductions,
                'dead_chickens_deductions' => $this->dead_chickens_deductions,
                'stinky_claw_deduction' => $this->stinky_claw_deduction,
                'maoji_car_subsidies' => $this->maoji_car_subsidies,
                'extra_large_chicken' => $this->extra_large_chicken,
                'Extra_Deduction_inputs' => $this->Extra_Deduction_inputs->toArray(),
                'weighing_date' => $this->settlementData->weighing_date,
                'm_NAME' => $this->contract->m_NAME,
                'breeder' => $this->settlementData->breeder,
                'livestock_farm_name' => $this->settlementData->livestock_farm_name,
                'price_of_newspaper' => $this->settlementData->price_of_newspaper,
                //'fee' => $this->fee,
                'total_stinking_claw' => $this->total_stinking_claw,
                'total_stinking_chest' => $this->total_stinking_chest,
                'total_dermatitis' => $this->total_dermatitis,
                'Extra_Note_inputs' => $this->Extra_Note_inputs->toArray(),
                'Extra_Plus_inputs' => $this->Extra_Plus_inputs,
                'address' => $this->address,
                'fee' => $this->settlementData->price_of_newspaper-$this->settlementData->unit_price,
                'stinky_dermatitis' => $this->stinky_dermatitis,
                'stinky_stinking_chest' => $this->stinky_stinking_chest,
                'deductions_absorb' => $this->deductions_absorb,
                'deductions' => $this->deductions,
                'numbers' => $this->numbers,
                'chick_discount' => $this->chick_discount,
            ]
            ]);

       
        return redirect()->route('export-pdf',['type' => 'settlement']);
    }

    public function SettleUp_SelectOption($option , Contract $contract, Request $request) //$option（用户选择的选项的值）
    // 當客戶選擇特定的結帳單號，會先透過這個function，將客戶的選擇回傳到settlement，重新顯示網頁資訊。
    {
        $this->account_number = $option;
        return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
    }

    public function AddIntoSelectedArea(Contract $contract, Request $request) //$option（用户选择的选项的值）
    {
        // 在$this->Selected_AccountNumber中新增這筆的account_number結帳單號
        array_push($this->Selected_AccountNumber, $this->account_number);

        $this->settlementData = Test::where('breeder', $this->breeder)->where('weighing_date', $this->weighing_date)->first();
        // 檢查是否成功獲取數據
        if ($this->settlementData == null){
            throw new \Exception("請先選擇「福壽批次」及「過磅日期」，然後再點選單號。"); 
        }

        $this->account_number = $this->settlementData->account_number;
        $this->breeder = $this->settlementData->breeder;
        $this->livestock_farm_name = $this->settlementData->livestock_farm_name;
        $this->quotation = $this->settlementData->quotation;
        $this->fee = $this->settlementData->fee;
        $this->death = $this->settlementData->death;
        $this->discard = $this->settlementData->discard;
        $this->stinking_claw = $this->settlementData->stinking_claw;
        $this->stinking_chest = $this->settlementData->stinking_chest;
        $this->dermatitis = $this->settlementData->dermatitis;
        $this->residue = $this->settlementData->residue;
        session([
            'settlementData' => $this->settlementData,
        ]);
        return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
    }

    public function RetrieveSelectedArea(Contract $contract, Request $request) //$option（用户选择的选项的值）
    {
        // 在$this->Selected_AccountNumber中刪除這筆的AccountNumber結帳單號
        $key = array_search($this->account_number, $this->Selected_AccountNumber);
        if ($key !== false) {unset($this->Selected_AccountNumber[$key]);}
        return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
    }

    public function Batch_ShowOptions($column_name, $key, Contract $contract, Request $request) # 留意括弧內參數的擺放
    // 當用戶點擊批次或過磅日期，會傳回settlement blade，告訴settlement blade要顯示哪一個下拉式選單。
    {
        $this->batch_showOptions_array[$column_name] = $key;
        return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder,'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
    }

    public function Batch_SelectOption($option, $key, $column_name, Contract $contract, Request $request) // $option（用户选择的选项的值），$key（与选项相关联的键）。
    // 用戶在下拉式選單選擇後，經由這個Batch_SelectOption function，重新顯示網頁資訊。
    {
        $this->batch_showOptions_array[$column_name] = false; // 用戶點選後自動關閉下拉式選單。
        if ($column_name == 'breeder') {
            $this->breeder = $option; // 用户选择的 $option 值
            $this->weighing_date = "請再選擇過磅日期";
        }

        if ($column_name == 'weighing_date') {
            $this->weighing_date = $option; // 用户选择的 $option 值
            
        }
        return redirect()->route('settlement', ['contract' => $this->contract->id, 'import' => $this->account_number, 'Unselection_AccountNumber' => $this->Unselection_AccountNumber, 'Selected_AccountNumber' => $this->Selected_AccountNumber, 'breeder' => $this->breeder, 'weighing_date'=> $this->weighing_date, 'batch_showOptions_array' => $this->batch_showOptions_array]);
        // Suggestion建議之後新增"關閉"功能
    }

    public function clear_DB_Settlement()
    {
        // Test
        Settlement::truncate();
        dd('請重新登出再登入後測試');
    }
    
}