<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ChickenImport;

class TraceabilityComponent extends Component
{
    public Collection $inputFeeding;
    public Collection $inputBreedingLog;
    public Collection $inputBreedingPerf; # 這個變數似乎沒再用到了!?
    public Contract $contract;

    // 入雛日期與數量
    public string $importDate = "";
    public string $importQuantity = "";

    public $importNum = -1;
    public $accumulatedWeight = [];
    public int $accumulatedWeight_len = 0;
    public string $m_KUNAG = "111c71008"; //客戶主檔(代碼， EX.AE0160AG00)
    public string $m_NAME = "AcerPing"; //客戶主檔(名稱， EX.廖允右-代)
    public string $chicken_origin = "天龍國"; 

    // 飼養行為的類別(根據键值获取对应的值)
    public $typeOptions = ['A' => 'A-飼料', 'B' => 'B-疫苗', 'C' => 'C-藥品', 'D' => 'D-消毒', 'E' => 'E-清理雞舍', 'F' => 'F-清理雞糞'];

    public $breeding_rate = 0;
    public $feeding_efficiency = 0;
    public $last_avg_weight = 0;
    public $age = 0;

    public $building_number = "北科A號"; # 宣告變數(棟舍)
    public $showOptions = array('importNum' => false, 'building_number' => false); #批號&棟舍的下拉式選單預設值
    public $importNumOptions = [];
    public $buildingNumOptions = [];

    public function render()
    {
        return view('livewire.traceability');
    }

    public function mount(Contract $contract, Request $request)
    {
        $this->contract = $contract;

        $this->importNumOptions = DB::table('feeding_logs')
        ->select('chicken_import_id')
        ->where('contract_id', $contract->id)
        ->distinct()
        ->get()
        ->toArray();
        // 轉格式不轉的話不是一般的array前面會多帶一個+號
        $this->importNumOptions = json_decode(json_encode($this->importNumOptions), true); 

        if ($request->import != -1 && $request->import != null) { #當使用者已經輸入資料時
            $this->importNum = $request->import;
            $this->building_number = $request->building_number;
        } else {
            if ($contract->feedingLogs->where('contract_id', $contract->id)->first() == null) {
                $errorMessage = '請您再次確認 農戶飼養紀錄表 的所有欄位皆已確實填寫資料！';
                $this->addError('No_ImportNum', $errorMessage); // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('No_ImportNum')來顯示。                
                return; 
            }
            $this->importNum = $contract->feedingLogs->where('contract_id', $contract->id)->first()->chicken_import_id; # 抓取feedingLogs中，屬於這一筆合約(contract_id)的第一筆的chicken_import_id
            $this->building_number = $contract->feedingLogs()->where('contract_id', $contract->id)->orderBy('building_number', 'asc')->first()->building_number; # 抓取feedingLogs中，屬於這一筆合約(contract_id)的第一筆的building_number棟舍
        }

        // 抓取棟別
        $this->buildingNumOptions = $contract->feedingLogs()->where('contract_id', $contract->id)->where('chicken_import_id', $this->importNum)->orderBy('building_number', 'asc')->pluck('building_number')->unique()->toArray(); # ->unique(): 这个方法会过滤掉集合中的重复项。
        $this->buildingNumOptions = array_unique($this->buildingNumOptions); # array_unique:移除陣列中重複的值並回傳新的陣列

        $this->inputFeeding = collect($contract->feedingLogs()->where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number)->orderBy('date', 'asc')->get()); 
        $this->inputBreedingLog = collect($contract->breedingLogs()->where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number)->orderBy('date', 'asc')->get());
        $this->inputBreedingPerf = collect($contract->breedingPerformances->where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number));
        $this->importDate = $contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->building_number)->first()->date;
        $this->importQuantity = ($contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->building_number)->first()->actual_quantity)*1.02; // 入雛表實際數量x1.02

        //抓取"客戶主檔"資料  
        $this->m_KUNAG = $this->inputFeeding->first()->m_KUNAG;
        $this->m_NAME = $contract->name_b; // 乙方客戶名稱

        //抓取"雛雞來源"資料
        $this->chicken_origin = $contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->building_number)->value('chicken_origin') ?? '未知來源';  // 取出資料庫'chicken_imports'中欄位名稱為'chicken_origin'的資料         

        // 育成率(%)
        $this->breeding_rate = $this->inputBreedingLog->last()->breeding_rate; // 取inputBreedingLog最後一筆的育成率
        $pm_avg_weight = $this->inputBreedingLog->last()->pm_avg_weight ?? null; // 最後一筆資料的下午均重。
        $am_avg_weight = $this->inputBreedingLog->last()->am_avg_weight ?? null; // 最後一筆資料的上午均重。
        // 設置 last_avg_weight，如果 pm_avg_weight 存在且非空，否則使用 am_avg_weight，否則設置為 0
        $this->last_avg_weight = !empty($pm_avg_weight) ? $pm_avg_weight : (!empty($am_avg_weight) ? $am_avg_weight : 0);
        // 日齡，同樣是最後一筆的資料。
        $this->age = $this->inputBreedingLog->last()->age;
        // 飼效 (*飼養行為要為A"飼料")
        $this->feeding_efficiency = collect($contract->feedingLogs->where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number)->where('feed_type', 'A'))->last(); # 取資料表中feeding_logs中飼養行為要為A，且最後一筆的飼效。
        // 要留意會有錯誤，所有要先判斷是否為null
        if (!is_null($this->feeding_efficiency)){
            $this->feeding_efficiency = $this->feeding_efficiency->feeding_efficiency;
        }
        else{
            $this->feeding_efficiency = 0;
        }
        
        if ($this->inputBreedingPerf->count() == 0) {
            $this->addInputBreedingPerf();
        }
        if ($this->inputBreedingLog->count() == 0) {
            $this->addInput();
        }
        if ($this->inputFeeding->count() == 0) {
            $this->addInputFeed();
        }
    }

    public function submit()
    {
        foreach ($this->inputFeeding as $input) {
            $input['contract_id'] = $this->contract->id;
            $input['chicken_import_id'] = $this->importNum; # 將"批號"送入資料庫
            $input['building_number'] = $this->building_number; # 將"棟舍"送入資料庫
        }

        return redirect()->route('traceability', ['contract' => $this->contract->id, 'import' => $this->importNum, 'building_number' => $this->building_number, 'm_KUNAG' => $this->m_KUNAG, 'm_NAME' => $this->m_NAME]);
    }

    public function addInput()
    {
        $this->inputBreedingLog->push([]);
    }

    public function addInputFeed()
    {
        $this->inputFeeding->push([]);
    }

    public function addInputBreedingPerf()
    {
        $this->inputBreedingPerf->push([]);
    }

    public function exportPDF()
    {
        return redirect()->route('export-pdf', [
            'importNum' => $this->importNum,
            'type' => 'traceability',
            'contract_id' => $this->contract->id,
            'importDate' => $this->importDate,
            'importQuantity' => $this->importQuantity,
            'm_NAME' => $this->m_NAME,
            'chicken_origin' => $this->chicken_origin,
            'building_number' => $this->building_number,
            'inputBreedingLog' => $this->inputBreedingLog,
            'typeOptions' => $this->typeOptions,
            'breeding_rate' => $this->breeding_rate,
            'feeding_efficiency' => $this->feeding_efficiency,
            'age' => $this->age,
            'last_avg_weight' => $this->last_avg_weight,            
        ]);
        // 'accumulatedWeight_len' => 0,
    }

    public function showOptions($table_name, $key)
    {
        $this->showOptions[$table_name] = $key;
    }

    public function selectOption($option, $key, $column_name) //$option（用户选择的选项的值），$key（与选项相关联的键），$column_name（相关联的数据库列名）。
    {
        $this->showOptions[$column_name] = false;

        // 处理 importNum 相关的逻辑。它更新了 importNum 属性
        if ($column_name == 'importNum') {
            $this->importNum = $option; // 用户选择的 $option 值
            $this->buildingNumOptions = $this->contract->feedingLogs()->where('contract_id', $this->contract->id)->where('chicken_import_id', $this->importNum)->orderBy('building_number', 'asc')->pluck('building_number')->unique()->toArray();
            $this->buildingNumOptions = array_unique($this->buildingNumOptions); # array_unique:移除陣列中重複的值並回傳新的陣列
            //我去contract裡面找feedingLogs資料，再去feedingLogs裡面找contract_id的資料，再找chicken_import_id等於importNum的資料。
            //pluck 方法類似於集合，用於從集合或者數據庫查詢結果中提取出一列的值
            $this->building_number = "請選擇";
            //如果只有一個直接跳轉
            if (count($this->buildingNumOptions) == 1) {
                $this->building_number = $this->buildingNumOptions[0];
                $this->mount($this->contract, request()->merge(['import' => $this->importNum, 'building_number' => $this->building_number]));
            } else {
                $this->showOptions('building_number', 1);
            }
        }

        if ($column_name == 'building_number') {
            $this->building_number = $option;
            $this->mount($this->contract, request()->merge(['import' => $this->importNum, 'building_number' => $this->building_number])); // request()->merge([...]) 是 Laravel 中的一个方法，用于合并新的参数到当前请求中
        }
    }

}
