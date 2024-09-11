<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Models\RawWeight;
use App\Models\SensorList;
use App\Http\Controllers\ExcelController;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\PredictController;
use App\Models\ChickenImport;

class ChartComponent extends Component
{
    // Line1_Part1 RawWeight
    // Line1_Part2 PredictedWeight
    // Line2       NationalWeight
    // Line3~5     Previous1stWeight,Previous2ndWeight,Previous3rdWeight

    public Contract $contract;
    public Collection $chicken_import;
    public Collection $sensor_list;
    // public Collection $national_weights;

    public $raw_weights;
    public $before1st_weights;
    public $before2nd_weights;
    public $before3rd_weights;

    public $predicted_weights;

    public $national_weights;
    public $previous1st_weights;
    public $previous2nd_weights;
    public $previous3rd_weights;

    public $combinedArray;

    public $ROSSGrowthCurve;
    public $previous1stChartData;
    public $previous2ndChartData;
    public $previous3rdChartData;
    public $count = 0;
    public $selectedDate;
    public string $importDate = "";
    public $importNum = "-1";
    public $buildingNum = "A";
    public $selectedOption = array(-1, -1); # 選項分別對應array($this->importNum, $this->buildingNum)，批號及棟舍。

    public $importNumOptions = [];
    public $buildingNumOptions = [];

    // 預測第幾天往前5位
    // 範圍只有 21 ~ 30
    // 例如：21 = 17~21
    // 例如：22 = 18~22
    // 例如：...
    // 例如：30 = 26~30
    // 如果不是21 就不預測
    // $startIndex應該是chickenImport Date跟raw_weights的db的最新一筆Date的去計算其日齡
    // 如果日齡小於21就不預測
    // 如果日齡大於21就預測
    public $startIndex = 0;

    // fake sensorID2buildingNum
    public $sensorID2buildingNum = array(
        '0' =>  'A',
        '1' =>  'B',
        '2' =>  'C',
        '3' =>  'D',
    );

    public function render()
    {
        return view('livewire.chart-line-chart');
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

        $this->importNumOptions = json_decode(json_encode($this->importNumOptions), true);

        // if ($request->import != "-1" && $request->import != null) {
        //     $this->importNum = $request->import;
        //     $this->buildingNum = $request->buildingNum;
        //     if ($this->buildingNum == null){
        //         $this->chicken_import = collect($contract->chickenImports->where('contract_id', $contract->id)->where('id', $this->importNum)->first());
        //     } else {
        //         $this->chicken_import = collect($contract->chickenImports->where('contract_id', $contract->id)->where('id', $this->importNum)->where('building_number', $this->buildingNum)->first());
        //     };
        // } else {
        //     $this->chicken_import = collect($contract->chickenImports->where('contract_id', $contract->id)->first());
        //     $this->importNum = $this->chicken_import['id'];
        //     $this->buildingNum = $this->chicken_import['building_number'];
        // }

        $this->chicken_import = collect($contract->chickenImports->where('contract_id', $contract->id)->first());

        if (isset($this->chicken_import['id']) && isset($this->chicken_import['building_number'])) {
            $this->importNum = $this->chicken_import['id'];
            $this->buildingNum = $this->chicken_import['building_number'];

        // 假資料
        /* $this->fakeSensorList();

        // 取得sensor list
        $this->getSensorList();
        foreach ($batchNumbers as $batchNumber) {
            $this->fakeRawWeight($batchNumber);
        }
        $this->fakeRawWeight($batchNumber=$this->chicken_import['id'],$Date=$this->chicken_import['date']);
        */

        $batchNumbers = ChickenImport::pluck('id');
        // 用sensorList取得raw_weights
        $this->raw_weights = RawWeight::where('batchNumber', $this->chicken_import['id'])
            ->where('sensorID', 0)
            ->select('Date', 'batchNumber', 'weight', 'time')
            ->get()
            ->toArray();

        // RawWeight的最後一筆日期 意旨最新的資料
        $lastElement = end($this->raw_weights);
        // 計算startIndex
        // $this->startIndex = Carbon::parse($lastElement['Date'])->diffInDays(Carbon::parse($this->chicken_import['date']));
        if (is_array($lastElement)) {
            $this->startIndex = Carbon::parse($lastElement['Date'])->diffInDays(Carbon::parse($this->chicken_import['date']));
        } else {
            // 在 $lastElement 不是陣列的情況下的處理方式，例如給 $this->startIndex 一個預設值
        }

        // $unpredicted_last5 = array_slice($this->raw_weights, -5, 5, true);
        $unpredicted_5 = array_slice($this->raw_weights, $this->startIndex - 5 + 1, 5, true);

        $this->buildingNumOptions = $contract->chickenImports->where('contract_id', $contract->id)->where('id', $this->importNum)->pluck('building_number')->toArray();

        // P.S. RawWeight 不是均重 之後要改

        if ($this->startIndex > 20 && $this->startIndex < 31) {
            $predict = new PredictController();
            // dd($unpredicted_5);
            $this->predicted_weights = $predict->exePython($begin = $this->startIndex, $data = $unpredicted_5, $region = 1001);
        } else {
            $this->predicted_weights = [];
        }

        $combinedArray = [];

        $nextDate = $this->chicken_import['date'];


        // 因為只能預測 31 ~ 35 所以等於是從第一筆預測資料開始往後推31天
        $nextDate = date("Y-m-d", strtotime($nextDate . " +31 day"));

        foreach ($this->predicted_weights as $predictedWeight) {
            $predictedWeight += [
                'Date' => $nextDate,
                'batchNumber' => $this->chicken_import['id'],
                'time' => '00:00:00'
            ];

            $combinedArray[] = $predictedWeight;
            $nextDate = date("Y-m-d", strtotime($nextDate . " +1 day"));
        }

        $combinedArray = array_merge($this->raw_weights, $combinedArray);

        // 計算age 日齡 = 當日日期 - 進場日
        $importDate = Carbon::parse($this->chicken_import['date']);
        foreach ($combinedArray as &$row) {
            $row['age'] = $importDate->diffInDays(Carbon::parse($row['Date']));
        }
        $this->combinedArray = $combinedArray;

        // ROSS 標準生長數據
        $this->ROSSGrowthCurve = $this->ROSSGrowthData();
        // $this->loadActualandPredictedData();
        } else {
            echo "<script>alert('目前尚未取得批號資訊，無法顯示數據圖!');</script>";
        }
    }

    public function getSensorList()
    {
        $this->sensor_list = collect(SensorList::where('batchNumber', $this->importNum)->where('sensorID', 0)
            ->select('batchNumber', 'sensorType', 'sensorID')
            ->get());
    }
    //取得前三次均重
    private function getWeights($import)
    {
        $sensorID = RawWeight::where('batchNumber', $import['id'])->pluck('sensorID')->first();
        $sid = RawWeight::where('batchNumber', $import['id'])->pluck('sid')->first();
        $weights = RawWeight::where('batchNumber', $import['id'])
            ->where('sensorID', $sensorID)
            ->where('sid', $sid)
            ->orderBy('Date', 'asc') // 日期升序排序
            ->orderBy('time', 'desc') // 在同一天内按時間升序排序
            ->get()
            ->groupBy('Date')
            ->map(function ($dateGroup) {
                return $dateGroup->first(); // 每個日期分組中選擇時間最晚的
            })
            ->sortBy(function ($record, $date) {
                return $date; // 確保結果按日期升序排序
            })
            ->values()
            ->toArray();
        $weights = $this->checkAndRemoveLastRecord($weights);
        // dd($weights);

        foreach ($weights as &$row) {
            $row['age'] = Carbon::parse($import['date'])->diffInDays(Carbon::parse($row['Date']));
        }

        return $weights;
    }

    public function updatedSelectedOption($value)
    {
        $newData = $this->getChartDataBasedOnOption($value);
        // dd($newData);

        // 實現選擇批號顯示對應日期 wire:model.lazy="chicken_import.date"
        $selectedBatch = ChickenImport::where('id', $this->importNum)->first();
        $this->selectedDate = $selectedBatch->date;
        // dd($newData);   
        $chartDatasets = [
            'selectedData' => $newData,
            'rossData' => $this->ROSSGrowthCurve,
        ];

        if ($this->previous1stChartData) {
            $chartDatasets['chartDatasets']['previous1st'] = $this->previous1stChartData;

        }
        if ($this->previous2ndChartData) {
            $chartDatasets['chartDatasets']['previous2nd'] = $this->previous2ndChartData;
        }
        if ($this->previous3rdChartData) {
            $chartDatasets['chartDatasets']['previous3rd'] = $this->previous3rdChartData;
        }

        $this->dispatchBrowserEvent('update-chart', $chartDatasets);

        $this->selectedOption = array($this->importNum, $this->buildingNum);

    }

    private function formatForChart($weights)
    {
        $chartData = ['labels' => [], 'weights' => []];

        foreach ($weights as $weight) {
            // 确保包含所需的键
            if (isset($weight['Date']) && isset($weight['weight'])) {
                $chartData['labels'][] = $weight['Date'];
                $chartData['weights'][] = $weight['weight'];
            }
        }

        return $chartData;
    }
    private function getChartDataBasedOnOption($option)
    {
        // 標準日增重
        $standardWeights = [0,18,18,20,23,26,29,32,35,38,41,44,48,51,54,58,61,64,67,70,72,75,78,80,82,84,86,88,90,91,93,94,95,96,96,97];
        $additional_index = 0;
        if ((substr( strtoupper($option), 0, 1) == 'G' && strlen($option) == 9) ||
            (substr( strtoupper($option), 0, 1) == 'A' && strlen($option) == 9)) 
            {
            $this->importNum = $option; # 批號，判斷方式:開頭為大寫G且字串長度為9
            #儲存$this->importNum到request的session
            request()->session()->put('importNum', $this->importNum); # 先將所選擇的批號存到
            request()->session()->save();
            #若request的session當中的buildingNum不是null時，則存到變數$this->buildingNum
            if (request()->session()->get('buildingNum') != null) {
                $this->buildingNum = request()->session()->get('buildingNum');
            }
        } else {
            $this->buildingNum = $option; # 棟別
            #儲存$this->buildingNum到request的session
            request()->session()->put('buildingNum', $this->buildingNum); # 先將所選擇的批號存到
            request()->session()->save();
            #若request的session當中的importNum不是null時，則存到變數$this->importNum
            if (request()->session()->get('importNum') != null) {
                $this->importNum = request()->session()->get('importNum');
            }
        }
        request()->session()->save();

        // 載入前三次均重
        $var1 = ChickenImport::where('id', $this->importNum)
                    ->pluck('date')
                    ->first();

        $previousImports = $this->contract->chickenImports
            ->where('contract_id', $this->contract->id)
            ->where('building_number', $this->buildingNum)
            ->where('date', '<', $var1)
            ->sortByDesc('date')
            ->take(3)
            ->values();
       
        $count = count($previousImports);
        $chartDatasets = [];
        $this->previous1stChartData = [];
        $this->previous2ndChartData = [];
        $this->previous3rdChartData = [];
        if ($count > 0) {
            $this->previous1st_weights = $this->getWeights($previousImports[0]);
            $this->previous1stChartData = $this->formatForChart($this->previous1st_weights);
            $chartDatasets['previous1st'] = $this->previous1stChartData;
            // dd($this->previous1stChartData);
        }

        if ($count > 1) {
            $this->previous2nd_weights = $this->getWeights($previousImports[1]);
            $this->previous2ndChartData = $this->formatForChart($this->previous2nd_weights);

            $chartDatasets['previous2nd'] = $this->previous2ndChartData;
        }

        if ($count > 2) {
            $this->previous3rd_weights = $this->getWeights($previousImports[2]);
            $this->previous3rdChartData = $this->formatForChart($this->previous3rd_weights);

            $chartDatasets['previous3rd'] = $this->previous3rdChartData;
        }
        // $batchNumber = $option;
        $batchNumber = $this->importNum;
        $buildingNumber = $this->buildingNum;

        $SensorID = RawWeight::where('batchNumber', $batchNumber)->pluck('sensorID')->first();
        $selectedBatch = $this->contract->chickenImports
            ->where('contract_id', $this->contract->id)
            ->where('id', $batchNumber)
            ->where('building_number', $buildingNumber)
            ->first();

        if ($selectedBatch) {
            // 如果 $selectedBatch 不為 null，則存取其 chicken_sid 屬性
            $sid = $selectedBatch->chicken_sid;
        } else {
            // 如果 $selectedBatch 為 null，則使用 $this->contract->chickenImports 的第一個 sid
            $sid = $this->contract->chickenImports
                ->where('contract_id', $this->contract->id)
                ->where('id', $batchNumber)
                ->pluck('chicken_sid')
                ->first();
        }

        $this->raw_weights = RawWeight::where('batchNumber', $batchNumber)
            ->where('sid', $sid)
            ->select('Date', 'batchNumber', 'weight', 'time', 'sid')
            ->orderBy('Date', 'asc') // 日期升序排序
            ->orderBy('time', 'desc') // 在同一天内按時間升序排序
            ->get()
            ->groupBy('Date')
            ->map(function ($dateGroup) {
                return $dateGroup->first(); // 每個日期分組中選擇時間最晚的
            })
            ->sortBy(function ($record, $date) {
                return $date; // 確保結果按日期升序排序
            })
            ->values()
            ->toArray();
        // 取得最後兩筆資料
        $last_two_records = array_slice($this->raw_weights, -2);

        $this->raw_weights = $this->checkAndRemoveLastRecord($this->raw_weights);
        $lastElement = end($this->raw_weights);
        // dd($lastElement);

        if (!empty($lastElement) && is_array($lastElement) && array_key_exists('Date', $lastElement)) {
            $importDate = Carbon::parse($this->chicken_import['date']);
            $lastRecordDate = Carbon::parse($lastElement['Date']);
            $age = $importDate->diffInDays($lastRecordDate);
            $lastElement['age'] = $age;

            if ($lastElement === false) {
                $rossCurveData = $this->ROSSGrowthCurve;
                $this->raw_weights = array_map(function($dayAge, $weight) use ($rossCurveData) {
                    return [
                        'Date' => Carbon::now()->subDays($rossCurveData['labels'][$dayAge])->toDateString(),
                        'batchNumber' => 'ROSS',
                        'weight' => $weight,
                        'time' => '00:00:00',
                        'age' => $dayAge,
                    ];
                }, array_keys($rossCurveData['weights']), $rossCurveData['weights']);
                $this->startIndex = 0;
            } else {
                $this->startIndex = Carbon::parse($lastElement['Date'])->diffInDays(Carbon::parse($this->chicken_import['date']));

                $currentAge = $lastElement['age'];

                $lastWeight = $lastElement['weight'];

                while ($currentAge < 35 && $lastWeight < 2000) {
                    $additional_index++;
                    $currentAge++;
                    $expectedWeight = $lastElement['weight'] + $standardWeights[$currentAge];
                    
                    array_push($this->raw_weights, [
                        'Date' => Carbon::parse($lastElement['Date'])->addDay()->toDateString(),
                        'batchNumber' => $this->importNum,
                        'weight' => $expectedWeight,
                        'time' => '00:00:00',
                        'age' => $currentAge,
                        
                    ]);
                    
                    $lastElement['Date'] = Carbon::parse($lastElement['Date'])->addDay()->toDateString();
                    $lastElement['weight'] = $expectedWeight;
                    $lastElement['age'] = $currentAge;
                }
            }

            // $importDate = Carbon::parse($this->chicken_import['date']);
            foreach ($this->raw_weights as &$row) {
                $row['age'] = $importDate->diffInDays(Carbon::parse($row['Date']));
            }
        } else if (empty($lastElement)) {
            // 如果 'date' 鍵不存在，則發送警告或執行其他降級邏輯
            $this->dispatchBrowserEvent('no-weight-data', ['message' => '目前尚未取得重量資訊，無法顯示數據圖!']);
            return;
        }

        return [
            'labels' => range(0, 35),
            'index' => 35-$additional_index,
            'data' => array_map(function ($item) {
                return $item['weight'];
            }, $this->raw_weights),
            // 'before_one_data' => array_map(function ($weight) {
            //     return $weight; // 這裡可以進行任何需要的操作，例如轉化或調整數值
            // }, $chartDatasets['previous1st']['weights']),
        ];
    }

    public function checkAndRemoveLastRecord($data){
        // 確保資料陣列至少有兩筆資料
        if (count($data) < 2) {
            return $data; // 如果資料不足兩筆，直接返回原始資料
        }

        // 取得最後兩筆資料
        $last_two_records = array_slice($data, -2);

        $last_record = $last_two_records[1];
        $second_last_record = $last_two_records[0];

        // 檢查 weight 差異是否大於等於 750
        if (($second_last_record['weight'] - $last_record['weight']) >= 750) {
            // 刪除最後一筆資料
            array_pop($data);
        }

        // 返回更新後的資料
        return $data;
    }

    public function ROSSGrowthData()
    {
        $age = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35];
        $weight = [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,
        1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235];

        return [
            'labels' => $age,
            'weights' => $weight,
        ];
    }
    public function ChartUpdate()
    {
        // 更新数据
        $this->combinedArray = [];
        $this->previous1st_weights = [];
        $this->previous2nd_weights = [];
        $this->previous3rd_weights = [];

    // 发送数据到前端
        $this->dispatchBrowserEvent('update-data', [
            'combied_data' => $this->combinedArray,
            'previous1st_weights' => $this->previous1st_weights,
            'previous2nd_weights' => $this->previous2nd_weights,
            'previous3rd_weights' => $this->previous3rd_weights,

        ]);

        // $this->combinedArray = [];

        // // 發送數據到前端
        // $this->dispatchBrowserEvent('update-data', $allData);
    }
    public function selectBuildingNum($buildingNum)
    {
        $this->buildingNum = $buildingNum;

        // 發射一個事件來觸發圖表更新
        $this->ChartUpdate();
    }

}
