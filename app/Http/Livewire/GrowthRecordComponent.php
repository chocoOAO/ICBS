<?php

namespace App\Http\Livewire;

use App\Models\BreedingLog;
use App\Models\ChickenImport;
use App\Models\ChickenOut;
use App\Models\Contract;
use App\Models\FeedingLog;
use App\Models\RawWeight;
use App\Models\UserSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Carbon;
use Livewire\Component;

class GrowthRecordComponent extends Component
{
    public Collection $inputFeeding;
    public Collection $inputBreedingLog;
    public Contract $contract;

    // 總重
    public Collection $raw_weight;

    // 用來儲存輸入值，因為不能直接動到資料庫，所以轉成array存起來
    public $inputBreedingLogArray;
    public $inputFeedingArray;
    public $antibioticArray;

    public $morning_weight_array;
    public $evening_weight_array;

    // 入雛日期與數量
    public string $importDate = "";
    public string $importQuantity = "";

    // 入雛批號與棟別，用來抓唯一值
    public $importNum = "-1";
    public $buildingNum = "A";

    public $species = "";

    //倖存羽數
    public $survivors = 0;
    public $totalDisuse = 0;

    // 入雛均重
    public $import_avg_weight = 0;
    public $last_avg_weight = 0;

    // 沒有資料先用假資料模擬小雞成長每個禮拜增重，單位是禮拜/g
    public $average_weight_gain = array(
        '0' => 23.5, //第一個禮拜1~7天，平均每天增重23.5g
        '1' => 44.46, //第二個禮拜8~14天，平均每天增重44.46g
        '2' => 66.55,
        '3' => 84.07,
        '4' => 94.47,
        '5' => 97.67,
    );

    //飼料量, 在這裡先宣告，在blade不加this->的話這裡的值不會動到
    public $total_feed_quantity = 0;
    public $A_accumulated_weight = 0;
    public $B_accumulated_weight = 0;
    public $C_accumulated_weight = 0;
    public $D_accumulated_weight = 0;

    // 用來儲存查詢值
    public $select_start_date = "";
    public $select_end_date = "";
    public $keyword = "";
    public $checkbox_value;
    public $checkbox_name;

    // 變數選單
    public $options = [];
    public $importNumOptions = [];
    public $buildingNumOptions = [];
    public $newOption = '';
    public $showOptions = [];
    public $isOptionOpen = array(
        'vaccine' => true,
        'pharmaceutical' => true,
        'add_antibiotics' => true,
        'feed_pharm' => true,
        'importNum' => true,
        'feed_type' => true,
        'buildingNum' => true,
    );

    public $typeOptions = ['A' => 'A-飼料', 'B' => 'B-疫苗', 'C' => 'C-藥品', 'D' => 'D-消毒', 'E' => 'E-清理雞舍', 'F' => 'F-清理雞糞'];

    // 用來檢查在抓雞派車單是否有資料
    public $DataInChickenOut = 0;

    public $dates;
    public $chicken_sid;
    public $morningWeights;
    public $eveningWeights;
    public function render()
    {
        return view('livewire.growth-record');
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

        // 轉格式不轉的話不是一般的array前面會多帶一個+號
        $this->importNumOptions = json_decode(json_encode($this->importNumOptions), true);

        //切換批號，這裡的$request裡的參數要對應你在request()->merge裡傳的名稱歐
        if ($request->import != "-1" && $request->import != null) {
            $this->importNum = $request->import;
            $this->buildingNum = $request->buildingNum;
        } else {
            $this->importNum = $contract->chickenImports->where('contract_id', $contract->id)->first()->id;
            $this->buildingNum = $contract->chickenImports->where('contract_id', $contract->id)->first()->building_number;
            if ($this->importNum == null) {
                $this->importNum = "A";
            }
        }

        // 抓取棟別
        $this->buildingNumOptions = $contract->chickenImports->where('contract_id', $contract->id)->where('id', $this->importNum)->pluck('building_number')->toArray();

        // 抓取倖存羽數
        $this->survivors = ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->quantity;
        $this->survivors=$this->survivors+(0.02*$this->survivors);
        $this->import_avg_weight = ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->actual_avg_weight;
        $this->last_avg_weight = $this->import_avg_weight;

        // 抓取RawWeight, 還未加入棟別
        // $this->raw_weight = collect(RawWeight::where('batchNumber', $this->importNum)
        //         ->select('Date', 'batchNumber', 'weight')
        //         ->get());
        $this->chicken_sid = ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->chicken_sid;

        $this->raw_weight = RawWeight::where('batchNumber', $this->importNum)
                ->where('sid', $this->chicken_sid)
                ->select('Date','time', 'batchNumber', 'weight')
                ->orderBy('date', 'asc')
                ->get();

        $this->morningWeights = $this->raw_weight->where('time', '06:00:00');
        $this->eveningWeights = $this->raw_weight->where('time', '18:00:00');
        $this->morning_weight_array = $this->raw_weight
                ->where('time', '06:00:00')
                ->mapWithKeys(function ($item) {
                    return [$item['Date'] => $item['weight']];
                })->toArray();

        $this->evening_weight_array = $this->raw_weight
            ->where('time', '18:00:00')
            ->mapWithKeys(function ($item) {
                return [$item['Date'] => $item['weight']];
            })->toArray();

        $this->updateAverageWeights();

        // 依棟數顯示不同雞種
        $selectedImport = $contract->chickenImports
                ->where('contract_id', $contract->id)
                ->where('id', $this->importNum)
                ->where('building_number', $this->buildingNum)
                ->first();

        if ($selectedImport) {
            $this->species = $selectedImport->species;
        }

        $this->inputFeeding = collect($contract->feedingLogs()->where('chicken_import_id', $this->importNum)->where('building_number', $this->buildingNum)->orderBy('date', 'asc')->get()); // 為了對date進行升冪排序，改用關聯方法。
        $this->inputFeedingArray = $this->inputFeeding->toArray();

        $this->inputBreedingLog = collect($contract->breedingLogs()->where('chicken_import_id', $this->importNum)->where('building_number', $this->buildingNum)->orderBy('date', 'asc')->get()); // 為了對date進行升冪排序，使用查詢構建器（Query Builder）進行查詢和排序。
        $this->inputBreedingLogArray = $this->inputBreedingLog->toArray();

        // 清空antibioticArray陣列內容
        $this->antibioticArray = [];

        // 設定抗生素Y/N顯示
        foreach ($this->inputFeedingArray as $key => $value) {
            $this->antibioticArray[$key] = $this->inputFeedingArray[$key]["add_antibiotics"] == '1' ? "YES" : "NO";
        }

        foreach ($this->inputBreedingLogArray as $key => $value) {
            $this->inputBreedingLogArray[$key]['disuse'] = $value['disuse'] ?? 0;
        }

        $this->importDate = $contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->date;
        $this->select_start_date = $this->importDate;
        $this->importQuantity = $contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->quantity;

        $this->auto_add_input(1);

        $this->checkbox_value = array(
            'feed_type' => false,
            'feed_item' => false,
            'age' => false,
            'disuse' => false,
            'add_antibiotics' => false,
            'feed_quantity' => false);

        $this->checkbox_name = array(
            'feed_type' => '飼養行為',
            'feed_item' => '投物名稱',
            'age' => '日齡',
            'disuse' => '淘汰數',
            'add_antibiotics' => '抗生素',
            'feed_quantity' => '飼料量',
        );

        $this->showOptions = array('vaccine' => false, 'pharmaceutical' => false, 'add_antibiotics' => false, 'feed_pharm' => false, 'importNum' => false, 'buildingNum' => false, 'feed_type' => false);

        // 取出使用者的設定table_name跟column_name
        $this->options = UserSetting::where('user_id', auth()->user()->id)->select('table_name', 'column_name')->get()->toArray();

        // 檢查入雛資料是否完整
        if ($this->survivors == 0) {
            $errorMessage = '入雛 ' . $this->importNum . '_' .$this->buildingNum . ' 未輸入實際入雛量。';
            // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('duplicate_date')來顯示
            $this->addError('actual_quantity_is_zero', $errorMessage);
            return;
        }

        $this->DataInChickenOut = 0; // 用來檢查在抓雞派車單是否有資料，每次調回預設值0。
    }

    protected function checkForDuplicates($input, &$visitedDates) { // 用於檢查生長記錄表中的日期是否重複。
        if (isset($input['date']) && in_array($input['date'], $visitedDates)) { // in_array() 函數用來檢查某個值是否存在於一個陣列中。
            $this->addError('duplicate_date', '日期 ' . $input['date'] . ' 重複，請修改日期。'); // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('duplicate_date')來顯示
            return true;
        }
        $visitedDates[] = $input['date'];
        return false;
    }

    public function submit()
    {
        $visitedDates = [];

        if (!Gate::allows('edit-growth', $this->contract)) {
            Gate::authorize('edit-growth', $this->contract);
        }
        $this->inputFeeding = collect($this->inputFeedingArray);
        $this->inputBreedingLog = collect($this->inputBreedingLogArray);

    // 飼養記錄表
        foreach ($this->inputFeeding as $input) {
            $input['contract_id'] = $this->contract->id;
            $input['chicken_import_id'] = $this->importNum;
            $input['building_number'] = $this->buildingNum;
            if (isset($input['feed_quantity']))
                $input['feed_quantity'] = $input['feed_quantity'] == '----' ? 0 : $input['feed_quantity'];
            $input['m_KUNAG'] = $this->contract->m_KUNAG;
            if (isset($input['feed_type'])) {
                $input['feeding_efficiency'] = $input['feed_type'] != 'A'? 0:$input['feeding_efficiency'];
            }
            if (isset($input['id'])) {
                FeedingLog::find($input['id'])->update($input);
            } else {
                if (!is_array($input)) {
                    continue;
                }
                $bypass = false;
                foreach ($input as $value) {
                    if ($value == "") {
                        $bypass = true;
                        break;
                    }
                }
                if ($bypass) {
                    continue;
                }
                FeedingLog::Create($input);
            }
        }

    // 生長記錄表
        foreach ($this->inputBreedingLog as $input) {
            // 初始化默认值和关键变量
            $input['disuse'] = $input['disuse'] ?? 0; // 设定disuse 属性默认值为 0 ，檢查$input['disuse']，如果不存在或其值为 null，则将其设置为 0。
            $input['contract_id'] = $this->contract->id;
            $input['chicken_import_id'] = $this->importNum;
            $input['building_number'] = $this->buildingNum;

            // 日期重复检查
            if ($this->checkForDuplicates($input, $visitedDates)) return;

            if (!empty($this->morning_weight_array) & count($this->morning_weight_array) != 0) { // 若$this->morning_weight_array是一個空数组，將導致count($this->morning_weight_array) - 1為-1。由于数组索引不能是负数，因此將發生錯誤"Undefined array key -1"。
                $lastDate = array_keys($this->morning_weight_array)[count($this->morning_weight_array) - 1];
            } else {
                $lastDate = null;  // 处理数组为空的情况
            }

            // 如果是最後一天的資料，直接存入 BreedingLog -> 這裡有可能發生錯誤，導致重複日期的錯誤。
            // if (isset($input['date']) && $input['date'] == $lastDate) {
            //     BreedingLog::create($input);
            //     continue;
            // }

            // 更新或创建记录
            if (isset($input['id'])) {
                BreedingLog::find($input['id'])->update($input); // 如果输入中包含 id，则查找并更新对应的 BreedingLog 记录。
            } else {
                if (!is_array($input)) {
                    continue;
                }

                if (!isset($input['age'])) { // 形同虛設！
                    continue;
                }

                // 如果日齡為0，就新增
                if ($input['age'] == 0) {
                    BreedingLog::create($input);
                    continue;
                }

                // 直接將所有生長記錄存入資料庫，即使使用者尚未填寫資料，仍先存入資料庫！
                BreedingLog::Create($input);
            }
        }

        return redirect()->route('growth-record.create', ['contract' => $this->contract->id, 'import' => $this->importNum, 'buildingNum' => $this->buildingNum]); // 'importDate' => $this->importDate,
    }

    public function search(Request $request)
    {
        //dd($request->all(), $this->checkbox_value, $this->keyword, $this->select_start_date, $this->select_end_date,$this->contract->chickenImports,$this->contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->date);
        // 更新入雛日期
        $this->importDate = $this->contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->date;
        $this->importQuantity = $this->contract->chickenImports->where('id', $this->importNum)->first()->quantity;

        //在資料庫進行累加的功能
        $this->inputFeeding = DB::table('feeding_logs')
            ->select('feeding_logs.*')
            ->where('contract_id', $this->contract->id)
            ->where('chicken_import_id', $this->importNum)
            ->where('building_number', $this->buildingNum)
            ->where('date', '>=', $this->select_start_date)
        
        // 根據選擇的checkbox_value來決定要搜尋的欄位
            ->where(function ($query) {
                $checkbox_no_true = true;
                foreach ($this->checkbox_value as $key => $value) {
                    //判斷是否全部都沒有勾選
                    $checkbox_no_true = $value ? false : $checkbox_no_true;

                    // 判斷是否為true與是否為資料庫欄位
                    if ($value && Schema::hasColumn('feeding_logs', $key)) {
                        if ($key == 'add_antibiotics') {
                            if ($this->keyword == 'YES') {
                                $query->orWhere($key, 'like', '%' . '1' . '%');
                            } else if ($this->keyword == 'NO') {
                                $query->orWhere($key, 'like', '%' . '0' . '%');
                            }
                        } else {
                            $query->orWhere($key, 'like', '%' . $this->keyword . '%');
                        }
                    }
                }

                //如果checkbox都沒有勾選，就搜尋全部欄位
                if ($checkbox_no_true) {
                    foreach ($this->checkbox_value as $key => $value) {
                        if (Schema::hasColumn('feeding_logs', $key)) {
                            if ($key == 'add_antibiotics') {
                                if ($this->keyword == 'YES') {
                                    $query->orWhere($key, 'like', '%' . '1' . '%');
                                } else if ($this->keyword == 'NO') {
                                    $query->orWhere($key, 'like', '%' . '0' . '%');
                                }
                            } else {
                                $query->orWhere($key, 'like', '%' . $this->keyword . '%');
                            }
                        }
                    }
                }
            })
            ->get();
        
        $this->inputBreedingLog = DB::table('breeding_logs')
            ->select('breeding_logs.*')
            ->where('contract_id', $this->contract->id)
            ->where('chicken_import_id', $this->importNum)
            ->where('building_number', $this->buildingNum)
            ->where('date', '>=', $this->select_start_date)
        // 根據選擇的checkbox_value來決定要搜尋的欄位
            ->where(function ($query) {
                $checkbox_no_true = true;
                foreach ($this->checkbox_value as $key => $value) {
                    //判斷是否全部都沒有勾選
                    $checkbox_no_true = $value ? false : $checkbox_no_true;

                    // 判斷是否為true與是否為資料庫欄位
                    if ($value && Schema::hasColumn('breeding_logs', $key)) {
                        $query->orWhere($key, 'like', '%' . $this->keyword . '%');
                    }
                }

                //如果checkbox都沒有勾選，就搜尋全部欄位
                if ($checkbox_no_true) {
                    foreach ($this->checkbox_value as $key => $value) {
                        if (Schema::hasColumn('breeding_logs', $key)) {
                            $query->orWhere($key, 'like', '%' . $this->keyword . '%');
                        }
                    }
                }
            })
            ->orderBy('date', 'asc')
            ->get();
        $this->inputBreedingLog = $this->inputBreedingLog->map(function ($item) {
            return (array) $item;
        });
        if ($this->select_end_date != "") {
            $this->inputFeeding = $this->inputFeeding->where('date', '<=', $this->select_end_date);
            $this->inputBreedingLog = $this->inputBreedingLog->where('date', '<=', $this->select_end_date);
        }
        $this->importDate = $this->contract->chickenImports->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->date;

        $this->inputFeedingArray = $this->inputFeeding->toArray();
        $this->inputFeedingArray = json_decode(json_encode($this->inputFeedingArray), true);

        foreach ($this->inputFeedingArray as $key => $value) {
            $this->antibioticArray[$key] = $this->inputFeedingArray[$key]["add_antibiotics"] == '1' ? "YES" : "NO";
        }

        $this->inputBreedingLogArray = $this->inputBreedingLog->toArray();
        $this->inputBreedingLogArray = json_decode(json_encode($this->inputBreedingLogArray), true);
        $this->auto_add_input();
    }

    public function delete($key, $table_name = null)
    {
        // dd(auth()->user()->permissions[2] < 4 && !isset($this->inputFeedingArray[$key]['new_data']));
        if ($table_name == 'breeding_log') {
            if (isset($this->inputBreedingLogArray[$key]['id'])) {
                BreedingLog::where('chicken_import_id', '=', $this->importNum)->where('building_number', $this->buildingNum)->where('id', '=', $this->inputBreedingLogArray[$key]['id'])->delete();
            }
            $this->import_avg_weight = ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->actual_avg_weight;
            $this->last_avg_weight = $this->import_avg_weight;
            unset($this->inputBreedingLogArray[$key]);
        } else if ($table_name == 'feeding_log') {
            if (isset($this->inputFeedingArray[$key]['id'])) {
                FeedingLog::where('chicken_import_id', '=', $this->importNum)->where('building_number', $this->buildingNum)->where('id', '=', $this->inputFeedingArray[$key]['id'])->delete();
            }

            unset($this->inputFeedingArray[$key]);
        }
        return;

    }

    public function addInput($date = 0)
    {
        // 去抓雞派車單查看是否有這筆的資料
        $this->DataInChickenOut = ChickenOut::where('chicken_import_id', $this->importNum)->where('building_number', $this->buildingNum)->first() != null;
        if ($this->DataInChickenOut != null) {
            $this->DataInChickenOut = '抓雞派車單已經有資料！！！';
            return $this->DataInChickenOut;}
        // 查看日齡，若日齡超過40天就不顯示。
        else if ($this->getAge(now()->toDateString(), $this->importDate) >= 40) {
            $this->DataInChickenOut = '日齡超過40天！！！';
            return $this->DataInChickenOut;}

        //為了避免新增空欄位時，尚未儲存之資料要重打，所以先將陣列轉成collection，再新增空欄位，再轉回陣列
        $this->inputBreedingLog = collect($this->inputBreedingLogArray);
        if ($date == 1) {
            $this->inputBreedingLog->push([
                'date' => now()->toDateString(),
                'age' => $this->getAge(now()->toDateString(), $this->importDate, ),
                'avg_weight' => ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->actual_avg_weight,
                'new_data' => 1]);
        } else {
            $this->inputBreedingLog->push(['avg_weight' => ChickenImport::where('id', $this->importNum)->where('building_number', $this->buildingNum)->first()->actual_avg_weight]);
        }
        $this->inputBreedingLogArray = $this->inputBreedingLog->toArray();
    }

    public function addInputFeed($date = 0)
    {
        $this->inputFeeding = collect($this->inputFeedingArray);

        if ($date == 1) {
            $this->inputFeeding->push([
                'date' => now()->toDateString(),
                'new_data' => 1]);
        } else {
            $this->inputFeeding->push([]);
        }
        $this->inputFeedingArray = $this->inputFeeding->toArray();
    }

    public function auto_add_input($date = 0)
    {
        $startDate = Carbon::parse($this->importDate);
        // $endDate = Carbon::parse($this->importDate)->addDays(35); // 假設結束日期是當前日期
        if (empty($this->morning_weight_array)) {
            // 如果 $this->morning_weight_array 為空，設置 $endDate 為從 $this->importDate 開始往後推 35 天
            $endDate = Carbon::parse($this->importDate)->addDays(35);
        } else {
            // 否則，設置 $endDate 為 $this->morning_weight_array 的最後一天日期
            $endDate = array_keys($this->morning_weight_array)[count($this->morning_weight_array) - 1];
        }

        while ($startDate->lte($endDate)) {
            $dateExists = $this->inputBreedingLog->firstWhere('date', $startDate->format('Y-m-d'));

            if (!$dateExists) {
                $this->addInputBreedingLog($startDate->copy());
            }

            $startDate->addDay();
        }
    }

    public function addInputBreedingLog($date)
    {
        // 填充 inputBreedingLogArray 的邏輯
        $newInput = [
            'date' => $date->format('Y-m-d'),
            'age' => $date->diffInDays(Carbon::parse($this->importDate)), // 根据需要計算日齡
        ];

        // 添加到 inputBreedingLogArray
        array_push($this->inputBreedingLogArray, $newInput);
    }

    public function showOptions($table_name, $key)
    {
        $this->showOptions[$table_name] = $key;
    }

    public function addOption($table_name)
    {
        if (!empty($this->newOption)) {
            // array_push($this->options, $this->newOption);
            // dd($this->options, $this->newOption, $table_name);
            // 如果有的話就不新增，沒有的話就新增
            UserSetting::updateOrCreate(
                ['user_id' => auth()->user()->id, 'table_name' => $table_name, 'column_name' => $this->newOption],
                ['user_id' => auth()->user()->id, 'table_name' => $table_name, 'column_name' => $this->newOption]
            );
            $this->newOption = '';
            $this->options = UserSetting::where('user_id', auth()->user()->id)->select('table_name', 'column_name')->get()->toArray();
        }
    }

    public function selectOption($option, $key, $column_name)
    {
        $this->showOptions[$column_name] = false;
        // 確認inputBreedingLogArray是否有這個欄位
        if (Schema::hasColumn('breeding_logs', $column_name)) {
            $this->inputBreedingLogArray[$key][$column_name] = $option;
        }
        if (Schema::hasColumn('feeding_logs', $column_name)) {
            $this->inputFeedingArray[$key][$column_name] = $option;
        }
        // 變更抗生素Y/N顯示
        if ($column_name == 'add_antibiotics') {
            if ($option == '1') {
                $this->antibioticArray[$key] = "YES";
            } else {
                $this->antibioticArray[$key] = "NO";
            }

        }
        if ($column_name == 'importNum') {
            $this->importNum = $option;
            $this->buildingNumOptions = $this->contract->chickenImports->where('contract_id', $this->contract->id)->where('id', $this->importNum)->pluck('building_number')->toArray();
            $this->buildingNum = "請選擇";
            //如果只有一個直接跳轉
            if (count($this->buildingNumOptions) == 1) {
                $this->buildingNum = $this->buildingNumOptions[0];
                $this->mount($this->contract, request()->merge(['import' => $this->importNum, 'buildingNum' => $this->buildingNum]));
            } else {
                $this->showOptions('buildingNum', 1);
            }
        }

        if ($column_name == 'buildingNum') {
            $this->buildingNum = $option;
            $this->mount($this->contract, request()->merge(['import' => $this->importNum, 'buildingNum' => $this->buildingNum]));
        }
        // $this->placeholderValue = $option;
    }

    public function closeOption($table_name)
    {
        $this->showOptions[$table_name] = false;
        // $this->isOptionOpen[$table_name] = false;
    }
    // Orth
    public function getAge($date, $importDate)
    {
        $date = Carbon::parse($date);
        $importDate = Carbon::parse($importDate);
        $age = $date->diffInDays($importDate);
        return $age;
    }

    public function getWeight($searchDate) // 取得上午或下午均重資訊
    {
        //遍歷資料集，尋找匹配的日期
        foreach ($this->inputBreedingLog as $inputBreedingLog) {
            if ($inputBreedingLog['date'] == $searchDate) {
                if(!empty($inputBreedingLog['pm_avg_weight'])){ // 檢查 pm_avg_weight 是否存在且非空
                    return $inputBreedingLog['pm_avg_weight']; // 返回 pm_avg_weight
                }
                elseif (!empty($inputBreedingLog['am_avg_weight'])){ // 檢查 am_avg_weight 是否存在且非空
                    return $inputBreedingLog['am_avg_weight']; // 返回 am_avg_weight
                }
                else {
                    return 0; // 如果没有 pm_avg_weight 和 am_avg_weight，则返回 0
                }
            }
        }
        return 0; // 如果没有找到匹配的日期，则返回 0
    }

    public function updateAverageWeights()
    {
        if (!is_array($this->inputBreedingLogArray)) {
            // 如果不是数组，可以初始化为一个空数组或执行其他逻辑
            $this->inputBreedingLogArray = [];
        }

        foreach ($this->inputBreedingLogArray as $key => &$logEntry) {
            $date = $logEntry['date'] ?? null;
            if($date) {
                $morningWeight = $this->morning_weight_array[$date] ?? null;
                $eveningWeight = $this->evening_weight_array[$date] ?? null;

                $logEntry['am_avg_weight'] = $morningWeight ? $morningWeight : 'N/A';
                $logEntry['pm_avg_weight'] = $eveningWeight ? $eveningWeight : 'N/A';
            }
        }
        unset($logEntry);
    }
}
