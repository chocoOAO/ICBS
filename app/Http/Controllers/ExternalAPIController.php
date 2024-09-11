<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\ChickenImport;
use App\Models\Contract;
use App\Models\RawWeight;
use App\Models\AvgWeight;
use App\Models\SensorList;
use App\Models\SensorDataCo2;
use App\Models\SensorDataNh3;
use App\Models\SensorDataTemp;
use App\Models\SensorDataHumidity;
use App\Models\Water;
use App\Models\FieldName;
use App\Models\User;
use App\Models\PredictWeightResult;
use Carbon\Carbon;
use Spatie\LaravelIgnition\FlareMiddleware\AddDumps;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ExternalAPIController extends Controller
{
    public function getUserPassword(string $id) {
        $account_id = $id; // 您的账户 ID
        $account_pwd_url = "http://1.34.47.251:28888/api/client/get_account_pwd.php?account_id=$account_id";

        try {
            // 获取账户密码
            $account_pwd_response = Http::get($account_pwd_url);

            if (!$account_pwd_response->successful()) {
                return response()->json(['message' => 'Failed to retrieve account password']);
            }

            $account_pwd_data = json_decode($account_pwd_response->body(), true);

            if (!isset($account_pwd_data['account_pwd'])) {
                return response()->json(['message' => 'Error: Invalid account password response']);
            }

            $account_pwd = $account_pwd_data['account_pwd'];

            // 将获取的账户密码存储到 User 数据库中
            $hashed_password = bcrypt($account_pwd_data['account_pwd']);
            $user = User::create([
                'account' => $account_id, // 使用获取的账户名作为用户名
                'password' => $hashed_password,
                'password_unencrypted' => $account_pwd, // 提供一个默认的空字符串作为默认值
                'email' => '', // email之後會拔掉在註解就好
                'name' => $account_pwd_data['account_name']
            ]);
            $user->save();

            return response()->json(['message' => 'Success', 'account_pwd' => $account_pwd]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }
    
    public function getSid() {
        $url = "http://1.34.47.251:28888/api/client/list_all_sheds.php";

        try {
            $response = Http::get($url);

            if (!$response->successful()) {
                return response()->json(['message' => 'Failed']);
            }

            $data = json_decode($response->body(), true);

            if (!is_array($data)) {
                return response()->json(['message' => 'Error: Invalid response']);
            }

            // 收集所有待更新紀錄的array
            $updates = [];

            foreach ($data as $item) {
                if (!is_array($item) || !isset($item['shed_name'])) {
                    continue;
                }

                $field = FieldName::firstOrCreate([
                    'sid' => $item['sid'],
                ], [
                    'shed_name' => $item['shed_name'],
                ]);

                $parts = explode('_', $item['shed_name']);
                $part1 = $parts[0];
                $part2 = $parts[1] ?? null;

                $contract = Contract::where('name_b', $part1)->first();

                if ($contract && $field->sid) {
                    // 收集需要更新的chickenImport信息
                    $updates[] = [
                        'contract_id' => $contract->id,
                        'building_number' => $part2,
                        'chicken_sid' => $field->sid
                    ];
                }
            }

            // 使用批量更新邏輯進行更新
            foreach ($updates as $update) {
                ChickenImport::where('contract_id', $update['contract_id'])
                    ->where('building_number', $update['building_number'])
                    ->update(['chicken_sid' => $update['chicken_sid']]);
            }

            return response()->json(['message' => 'Success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 確認批次號是否存在以及批次號底下掛了那些感測器(GET)
    public function getSensor()
    {
        $batchLogs = ChickenImport::all(['id', 'chicken_sid', 'date']);

        // sid根據入雛表存入的modified_log取得
        foreach ($batchLogs as $batchLog) {
            $batchNumber = $batchLog->id;
            $sids = $batchLog->chicken_sid;
            $dates = $batchLog->date;

            $sensorList = SensorList::where('batchNumber', $batchNumber)->get();
            if (empty($batchNumber) || empty($sids)) {
                continue;
            }

            try {
                $url = "http://1.34.47.251:28888/api/client/batch_query.php?sid={$sids}&batchNumber={$batchNumber}";

                $response = Http::get($url);

                // 檢查是否成功接收到 API 回應
                if ($response->successful()) {
                    $data = $response->json();

                    // 因為回傳的資料是陣列，所以要用 foreach 逐筆寫入資料庫
                    foreach ($data as $item) {
                        if (is_array($item)) {

                            $existingRecord = SensorList::where('batchNumber', $batchNumber)
                                ->where('sensorID', $item['sensorID'] ?? null)
                                ->first();

                            if (!$existingRecord) {
                                SensorList::create([
                                    'batchNumber' => $batchNumber,
                                    'sensorType' => $item['sensorType'] ?? null,
                                    'sensorID' => $item['sensorID'] ?? null,
                                    'sid' => $sids,
                                    'date' => $dates,
                                    // 其他欄位...
                                ]);
                            }
                        } else {

                            Log::error("Expected array, but got string from API: " . print_r($item, true));
                        }
                    }
                } else {
                    return response()->json(['message' => 'Failed']);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
            }
        }
    }

    public function getWeightRaw()
    {
        // 取得距離現在40天內的sensorlist列表
        $sensorLists = SensorList::where('date', '>=', Carbon::now()->subDays(200))->orderBy('date', 'desc')->get(['sid', 'batchNumber', 'sensorID', 'date']);
        // $sensorLists = SensorList::orderBy('date', 'asc')->get(['sid', 'batchNumber', 'sensorID', 'date']);
        // dd($sensorLists);

        foreach ($sensorLists as $sensor) {

            $batchNumber = $sensor->batchNumber;
            $sid = $sensor->sid;
            $sensorID = $sensor->sensorID;
            $date = Carbon::parse($sensor->date)->startOfDay();

            $maxEmptyResponses = 7;
            $fetchedDays = 0;

            do {
                $url = "http://1.34.47.251:28888/api/client/weightRaw.php?sid={$sid}&batchNumber={$batchNumber}&sensorID={$sensorID}&Date={$date}";
                // dd($url);
                try {
                    $response = Http::get($url);

                    if ($response->successful()) {
                        $data = $response->json();

                        if (isset($data['type']) && $data['type'] === 'WeightRaw no data') {
                            $fetchedDays++;
                            if ($fetchedDays >= $maxEmptyResponses) {
                                break;
                            }
                        } 
                        elseif(isset($data['type']) && $data['type'] === 'Shed or batch number not exist'){
                            break;
                        }
                        else {
                            $fetchedDays = 0;
                            // $dataCollection = $dataCollection->merge($data);
                            // dd($dataCollection);

                            // 例如，將回應存入資料庫
                            foreach ($data as $item) {
                                // 檢查該記錄是否已存在
                                $existingRecord = RawWeight::where('Date', $item['Date'])
                                    ->where('sid', $item['sid'])
                                    ->where('time', $item['time'])
                                    ->where('sensorID', $item['sensorID'])
                                    ->first();

                                if (!$existingRecord) {
                                    RawWeight::create([
                                        'batchNumber' => $batchNumber,
                                        'Date' => $item['Date'],
                                        'time' => $item['time'],
                                        'sid' => $item['sid'],
                                        'sensorID' => $item['sensorID'],
                                        'weight' => $item['weight'],
                                    ]);
                                }
                            }
                        }
                    } else {
                        return response()->json(['message' => 'Failed']);
                    }
                } catch (\Exception $e) {
                    continue;
                }
                $date->addDay();
            } while(true);
        }
    }

    // 取得特定日期平均重量資料(GET)
    public function getWeightAverage()
    {
        $batchNumber = '2023_0523';
        // 截止日期
        $date = '20230615';
        $url = "http://1.34.47.251:28888/api/client/weightAvg.php?batchNumber={$batchNumber}&Date={$date}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫
                foreach ($data as $item) {
                    AvgWeight::create([
                        'batchNumber' => $batchNumber,
                        'Date' => $item['Date'],
                        'weightFieldAvg' => $item['weightFieldAvg'],
                        'weightFieldEvenness' => $item['weightFieldEvenness'],
                        'growthRate' => $item['growthRate'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 取得溫度資料()
    public function getSensorDataTemp()
    {
        $batchNumber = '2023_0523';
        $sensorID = 74;
        $url = "http://1.34.47.251:28888/api/client/sensorDataTemp.php?batchNumber={$batchNumber}&sensorID={$sensorID}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫

                foreach ($data as $item) {
                    SensorDataTemp::create([
                        'batchNumber' => $batchNumber,
                        // 'sensorType' => $item['sensorType'],
                        'Date' => $item['Date'],
                        'time' => $item['time'],
                        'sensorID' => $item['sensorID'],
                        'temperature' => $item['temperature'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 取得濕度資料()
    public function getSensorDataHumidity()
    {
        $batchNumber = '2023_0523';
        $sensorID = 74;
        $url = "http://1.34.47.251:28888/api/client/sensorDataHumidity.php?batchNumber={$batchNumber}&sensorID={$sensorID}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫

                foreach ($data as $item) {
                    SensorDataHumidity::create([
                        'batchNumber' => $batchNumber,
                        // 'sensorType' => $item['sensorType'],
                        'Date' => $item['Date'],
                        'time' => $item['time'],
                        'sensorID' => $item['sensorID'],
                        'humidity' => $item['humidity'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 取得氨氣資料()
    public function getSensorDataNh3()
    {
        $batchNumber = '2023_0523';
        $sensorID = 74;
        $url = "http://1.34.47.251:28888/api/client/sensorDataNH3.php?batchNumber={$batchNumber}&sensorID={$sensorID}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫

                foreach ($data as $item) {
                    SensorDataNh3::create([
                        'batchNumber' => $batchNumber,
                        // 'sensorType' => $item['sensorType'],
                        'Date' => $item['Date'],
                        'time' => $item['time'],
                        'sensorID' => $item['sensorID'],
                        'nh3' => $item['nh3'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 取得二氧化碳資料()
    public function getSensorDataCo2()
    {
        $batchNumber = '2023_0523';
        $sensorID = 74;
        $url = "http://1.34.47.251:28888/api/client/sensorDataCO2.php?batchNumber={$batchNumber}&sensorID={$sensorID}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫

                foreach ($data as $item) {
                    SensorDataCo2::create([
                        'batchNumber' => $batchNumber,
                        // 'sensorType' => $item['sensorType'],
                        'Date' => $item['Date'],
                        'time' => $item['time'],
                        'sensorID' => $item['sensorID'],
                        'co2' => $item['co2'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    // 取得水資料()
    public function getPredictData(){
        $standard_data = [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235];
        ///為了遞補預測17-21天重量
        $backfill = [701,768,837,910,985];
        $need_predict_data = DB::table('contracts')
                ->join('chicken_imports', 'contracts.id', '=', 'chicken_imports.contract_id')
                ->leftJoin('chicken_outs', function ($join) {
                    $join->on('contracts.id', '=', 'chicken_outs.contract_id')
                        ->on('chicken_outs.chicken_import_id', '=', 'chicken_imports.id')
                        ->on('chicken_outs.building_number', '=', 'chicken_imports.building_number');
                })
                ->select(
                    DB::Raw("(chicken_imports.id) as imports_id, (contracts.id) as contracts_id, (chicken_imports.building_number) as building_number, CONCAT(contracts.name_b, '_', chicken_imports.building_number) as name_b"),
                    DB::Raw("MIN(chicken_imports.date) as start")
                )
                ->whereRaw("chicken_imports.date < contracts.end_date")
                ->groupBy('contracts.name_b', 'contracts.id', 'chicken_imports.id', 'chicken_imports.building_number')
                ->orderBy('chicken_imports.id')
                ->havingRaw("SUM(chicken_outs.quantity) IS NULL OR SUM(chicken_outs.quantity) = 0")
                ->get();
            ///取出需要預測的資料並串成一個標頭，格式:場域名稱-棟別-數量-
            $need_predict_information = DB::table('chicken_imports')
                ->join('z_cus_kna1s as zc', 'chicken_imports.m_KUNAG', '=', 'zc.m_KUNAG')
                ->join('contracts', 'contracts.id', '=', 'chicken_imports.contract_id')
                ->whereRaw("chicken_imports.date < contracts.end_date")
                ->select(
                    DB::raw("CONCAT(zc.m_NAME, '-', chicken_imports.building_number, '-', COALESCE(chicken_imports.actual_quantity, '沒有實際數量')) as title"),
                    DB::raw("MIN(chicken_imports.date) as start")
                )
                ->where(function ($query) use ($need_predict_data) {
                    foreach ($need_predict_data as $item) {
                        $query->orWhere(function ($query) use ($item) {
                            $query->where('chicken_imports.id', $item->imports_id)
                                ->where('chicken_imports.building_number', $item->building_number);
                        });
                    }
                })
                ->orderBy('chicken_imports.id')
                ->groupBy('zc.m_NAME', 'chicken_imports.building_number', 'chicken_imports.actual_quantity', 'chicken_imports.id', 'chicken_imports.building_number')
                ->get();

            $j = 0;
            ///逐個合約處理
            foreach ($need_predict_data as $key => $value) {
                $begin = 0;
                ///確認有無sid
                $sid = DB::table('field_names')
                    ->where('shed_name', $value->name_b)
                    ->select('sid')
                    ->first();

                if ($sid) {
                    ///找出最後五天日期和重量進行預測
                    $maxDate = DB::table('raw_weights')
                        ->where('batchNumber', $value->imports_id)
                        ->where('sid', $sid->sid)
                        ->max('Date');

                    if ($maxDate) {
                        $startDateCarbon = Carbon::parse($maxDate);
                        $startDates = [
                            $startDateCarbon->copy()->subDays(4)->format('Y-m-d'),
                            $startDateCarbon->copy()->subDays(3)->format('Y-m-d'),
                            $startDateCarbon->copy()->subDays(2)->format('Y-m-d'),
                            $startDateCarbon->copy()->subDays(1)->format('Y-m-d'),
                            $startDateCarbon->copy()->subDays(0)->format('Y-m-d'),
                        ];
                        $result = RawWeight::getWeightData($value->imports_id, $startDates, $sid->sid);

                        $dates = $result->map(function ($log) {
                            return ['date' => $log->Date];
                        })->toArray();
                        $weights = $result->map(function ($log) {
                            return ['weight' => $log->weight];
                        })->toArray();
                        ///補資料，可能中間有幾天缺失資料
                        if (count($weights) < 5) {
                            $begin = (strtotime($maxDate) - strtotime($value->start)) / (60 * 60 * 24);
                            $lossCount = 5 - count($weights);
                            $standardSubset = array_reverse(array_slice(array_reverse($standard_data), 35 - $begin, $lossCount));
                            $weights = array_merge($weights, array_map(function ($weight) {
                                return ['weight' => $weight];
                            }, $standardSubset));
                        }
                        $begin = (strtotime($maxDate) - strtotime($value->start)) / (60 * 60 * 24);
                    }

                    $predictController = new PredictController();
                    $region = 1001;
                    $i = 0;
                    ///處理天數不足預測問題
                    if ($begin < 17 || $maxDate == null) {
                        $predict_result = [
                            ["weight" => "1783.26", "age" => 31],
                            ["weight" => "1867.35", "age" => 32],
                            ["weight" => "1951.84", "age" => 33],
                            ["weight" => "2036.68", "age" => 34],
                            ["weight" => "2121.86", "age" => 35]
                        ];
                    } else if ($begin < 21) {
                        $keepCount = $begin - 16;
                        $weights = array_slice($weights, -$keepCount);
                        $standardSubset = array_reverse(array_slice(array_reverse($backfill), 0, 5 - $keepCount));
                        $weights = array_merge($weights, array_map(function ($weight) {
                            return ['weight' => $weight];
                        }, $standardSubset));
                        $begin = 21;
                        $predict_result = $predictController->exePython($begin, $weights, $region);
                    } else {
                        $predict_result = $predictController->exePython($begin, $weights, $region);
                    }
                    ///找出預測重量在哪天2-2.1kg並做判斷處理
                    foreach ($predict_result as $i => $pd_result) {
                        $predict_result[$i]['weight'] = round(floatval($predict_result[$i]['weight']), 2);
                        $predict_result[$i]['weight'] = preg_replace('/[+-].*/', '', $pd_result['weight']);
                        if (intval($predict_result[$i]['weight']) > 2000 && intval($predict_result[$i]['weight']) < 2100) {
                            $need_predict_information[$j]->title .= '-' . $predict_result[$i]['weight'];
                            $need_predict_information[$j]->start = date('Y-m-d', strtotime($need_predict_information[$j]->start . ' +' . $pd_result['age'] . ' days'));
                            if ($predict_result[$i]['weight'] > $standard_data[intval($pd_result['age'])] * 1.1) {
                                $need_predict_information[$j]->title = '★★' . $need_predict_information[$j]->title;
                            } elseif ($predict_result[$i]['weight'] > $standard_data[intval($pd_result['age'])] * 1.05) {
                                $need_predict_information[$j]->title = '★' . $need_predict_information[$j]->title;
                            }
                            $need_predict_information[$j]->title = $need_predict_information[$j]->title . '(' . $pd_result['age'] . ')';
                            break;
                        } elseif ($i === count($predict_result) - 1) {
                            $index = 0;
                            foreach ($standard_data as $key => $line_data) {
                                if ($line_data >= 2000 && $line_data <= 2100) {
                                    $need_predict_information[$j]->title .= '-' . $line_data;
                                    $need_predict_information[$j]->start = date('Y-m-d', strtotime($need_predict_information[$j]->start . ' +' . $index . ' days'));
                                    if (intval($line_data) > $standard_data[intval($pd_result['age'])] * 1.1) {
                                        $need_predict_information[$j]->title = '★★' . $need_predict_information[$j]->title;
                                    } elseif (intval($line_data) > $standard_data[intval($pd_result['age'])] * 1.05) {
                                        $need_predict_information[$j]->title = '★' . $need_predict_information[$j]->title;
                                    }
                                    $need_predict_information[$j]->title = $need_predict_information[$j]->title . '(' . $index . ')';
                                    break 2;
                                }
                                $index++;
                            }
                        }
                    }
                }
                else{
                    ///沒有sid的處理
                    $need_predict_information[$j]->title .= '-該場域不存在API沒有SID'; 
                }
                $existingRecord = PredictWeightResult::where('contracts_id', $value->contracts_id)
                ->where('batchNumber', $value->imports_id)
                ->where('sid', $sid ? $sid->sid : null)
                ->first();
                if ($existingRecord) {
                    // 如果找到現有記錄，更新 title 和 start
                    $existingRecord->update([
                        'title' => $need_predict_information[$j]->title,
                        'start' => $need_predict_information[$j]->start,
                    ]);
                    
                    $predictWeightResult = $existingRecord;
                } else {
                    // 如果未找到現有記錄，創建新記錄
                    $predictWeightResult = PredictWeightResult::create([
                        'contracts_id' => $value->contracts_id,
                        'batchNumber' => $value->imports_id,
                        'sid' => $sid ? $sid->sid : null,
                        'title' => $need_predict_information[$j]->title,
                        'start' => $need_predict_information[$j]->start,
                    ]);
                }
                $j++;
            }
    } 
    public function getWater()
    {
        // {"batchNumber":"2023_0523","Date":"20230523","time":"00:16:02","sensorID":"46","water":66476.571}

        $batchNumber = '2023_0523';
        $sensorID = 46;
        $url = "http://1.34.47.251:28888/api/client/water.php?batchNumber={$batchNumber}&sensorID={$sensorID}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                // 在這裡處理 API 回應的 $data

                // 例如，將回應存入資料庫

                foreach ($data as $item) {
                    Water::create([
                        'batchNumber' => $batchNumber,
                        // 'sensorType' => $item['sensorType'],
                        'Date' => $item['Date'],
                        'time' => $item['time'],
                        'sensorID' => $item['sensorID'],
                        'water' => $item['water'],
                        // 其他欄位...
                    ]);
                }

                return response()->json(['message' => 'Success', 'data' => $data]);
            } else {
                return response()->json(['message' => 'Failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }
}
