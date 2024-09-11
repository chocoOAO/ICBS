<?php

namespace App\Http\Livewire;

use App\Models\BreedingLog;
use App\Models\ChickenOut;
use App\Models\Contract;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ChickenOutComponent extends Component
{
    public Collection $inputs;
    public Contract $contract;
    public $importNum = -1; # 宣告變數(批號)
    public $building_number = -1; # 宣告變數(棟舍)
    public $m_KUNAG = "";  # 宣告變數(客戶主檔代號)
    public $m_NAME = ""; # 宣告變數(乙方客戶主檔名稱)

    public $data = [];

    public $importNumOptions = [];

    public $showOptions = array('importNum' => false, 'building_number' => false); #批號&棟舍的下拉式選單預設值

    public $buildingNumOptions = [];

    public function render()
    {
        return view('livewire.chicken-out');
    }

    public function mount(Contract $contract, Request $request)
    {
        $this->contract = $contract;

        $this->importNumOptions = DB::table('chicken_imports')
        ->select('id')
        ->where('contract_id', $contract->id)
        ->distinct()
        ->get()
        ->toArray();

        if ($request->import != -1 && $request->import != null) { #當使用者已經輸入資料時
            $this->importNum = $request->import;
            $this->building_number = $request->building_number; # 抓取chickenImports中的building_number棟舍
        } else {
            if ($contract->chickenImports->where('contract_id', $contract->id)->isEmpty())
                {
                    $errorMessage = '逆還沒有填寫入雛資訊！！！';
                    $this->addError('No_ImportNum', $errorMessage); // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('No_ImportNum')來顯示。                
                    $this->inputs = collect();
                    return; 
                }
            $this->importNum = $contract->chickenImports->where('contract_id', $contract->id)->first()->id; # 抓取chickenImports中的id
            $this->building_number = $contract->chickenImports->where('contract_id', $contract->id)->first()->building_number; # 抓取chickenImports中的building_number棟舍
        }
        
        $this->m_KUNAG = $contract->m_KUNAG; // m_KUNAG客戶代號
        $this->m_NAME =  $contract->name_b; // m_NAME客戶名稱

        $this->inputs = collect($contract->chickenOuts()->where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number)->orderBy('date')->orderBy('quantity', 'desc')->get());

        // 轉格式不轉的話不是一般的array前面會多帶一個+號
        $this->importNumOptions = json_decode(json_encode($this->importNumOptions), true);

        // 抓取棟別
        $this->buildingNumOptions = $contract->chickenImports->where('contract_id', $contract->id)->where('id', $this->importNum)->pluck('building_number')->toArray();

        if ($this->inputs->count() == 0) {
            $this->addInput();
        }
    }

    private function calculateSurvivors()
    {
        $totalDisuse = BreedingLog::where('chicken_import_id', $this->importNum)->where('building_number', $this->building_number)->sum('disuse'); // 總淘汰數
        $chickenImport = $this->contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->building_number)->first(); 
        
        if (!$chickenImport) {
            throw new \Exception("查無符合條件的飼養入雛資料。您所查詢的批號為「{$this->importNum}」，棟舍為「{$this->building_number}」。"); 
        }

        $total_num = intval($chickenImport->quantity + $chickenImport->gift_quantity); // 總數
        return $total_num - $totalDisuse; // 剩存羽數
    }

    private function saveChickenOut($input) // 如果存在 id，则更新记录；否则，创建新记录。
    {
        $input['contract_id'] = $this->contract->id;
        $input['chicken_import_id'] = $this->importNum; # 將"批號"送入資料庫
        $input['building_number'] = $this->building_number; # 將"棟舍"送入資料庫
        
        if (isset($input['id'])) { 
            ChickenOut::find($input['id'])->update($input); // 更新資料。
        } else { 
            if (is_array($input) && isset($input['date'], $input['time']) && !empty($input['quantity'])) {
                ChickenOut::Create($input); // 新增資料。
            }
        }
    }

    public function submit()
    {
        $total_survivors = $this->calculateSurvivors(); // 剩存羽數
        $totalChickenOut = $this->inputs->sum('quantity'); // 計算總抓雞數量
        
        // 如果多個加總起來超過剩下餘數就不行，要修改加總起來，超過剩下就error
        if ($totalChickenOut > $total_survivors){
            $err_msg = sprintf('【Error錯誤】所設定的抓雞總隻數（%d）超過當前剩存羽數（%d）。', $totalChickenOut, $total_survivors);
            $this->addError('exceedTotalSurvivors', $err_msg);
            return;
        }

        foreach ($this->inputs as $input) {
            if ($input['quantity'] > $total_survivors) {
                $err_msg = sprintf('【Error錯誤】所設定的抓雞隻數（%d）超過當前剩存羽數（%d）。', $input['quantity'], $total_survivors);
                $this->addError('exceedTotalSurvivors', $err_msg);
                return;
            }
            $this->saveChickenOut($input); // 更新或儲存資料
        }
        return redirect()->route('chicken-out.create', ['contract' => $this->contract->id, 'import' => $this->importNum, 'building_number' => $this->building_number, 'm_KUNAG' => $this->m_KUNAG]);
    }

    public function addInput()
    {
        // 優化資料查詢，減少重複查詢
        $contract = $this->contract;
        $phone_number = $contract->mobile_tel;

        $total_survivors = $this->calculateSurvivors(); // 剩存羽數
        $totalChickenOut = $this->inputs->sum('quantity'); // 計算總抓雞數量
        $remaining = $total_survivors - $totalChickenOut; // 剩餘可以抓雞的數量

        $chickenImport = $contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->building_number)->first();
        $origin = $chickenImport->address; // 抓雞地點

        $taiwanTime = Carbon::now('Asia/Taipei');
        $currentDate = $taiwanTime->toDateString();
        $currentTime = $taiwanTime->format('H:i');

        $this->data = [
            "date" => $currentDate,
            "time" => $currentTime,
            "origin" => $origin,
            "owner" => $this->m_NAME,
            "phone_number" => $phone_number,
            "quantity" => $remaining,
        ];

        // 如果已經有資料，則抓取上一筆資料的一些欄位資料來使用，方便使用者填寫。
        if ($this->inputs->isNotEmpty()) { 
            $last_input = $this->inputs->last();
            $this->data["date"] = $last_input['date'];
            $this->data["time"] = $last_input['time'];
        }        
        $this->inputs->push($this->data);
    }

    public function delete($index)
    {
        if (!isset($this->inputs[$index]['id'])) {
            $this->inputs->forget($index);
            return;
        }

        ChickenOut::findOrFail($this->inputs[$index]['id'])->delete();
        $this->inputs->forget($index);
        return;
    }

    public function exportPDF()
    {
        // 確保資料存在並有效
        if (!$this->contract || !$this->importNum || !$this->building_number || !$this->m_KUNAG || !$this->m_NAME) {
            throw new \Exception("【ERROR】缺少必要的資料。"); 
        }

        $exportData = [
                'contract_id' => $this->contract->id, 
                'import' => $this->importNum, 
                'type' => 'chicken-out', 
                'building_number' => $this->building_number, 
                'm_KUNAG' => $this->m_KUNAG,
                'm_NAME' => $this->m_NAME,
        ];
        return redirect()->route('export-pdf', $exportData);
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
            $this->buildingNumOptions = $this->contract->chickenImports->where('contract_id', $this->contract->id)->where('id', $this->importNum)->pluck('building_number')->toArray();
            //我去contract裡面找chickenImports資料，再去chickenImports裡面找contract_id的資料，再找id等於importNum的資料。
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
