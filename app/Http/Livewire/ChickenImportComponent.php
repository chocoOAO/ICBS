<?php

namespace App\Http\Livewire;

use App\Models\BreedingLog;
use App\Models\BreedingPerformance;
use App\Models\ChickenImport;
use App\Models\Contract;
use App\Models\ContractDetail;
use App\Models\FeedingLog;
use App\Models\RawWeight;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\ExternalAPIController;
use Illuminate\Database\QueryException;

class ChickenImportComponent extends Component
{
    public Collection $inputs;
    public Collection $fake_raw_weights;
    public Contract $contract;
    public $address = "";
    public $select_start_date = "";
    public $select_end_date = "";
    public $photos = [];
    public $data = [];
    private $ExternalAPIController;
    public function __construct()
    {
        // Dependency injection to get the controller instance
        $this->ExternalAPIController = app(ExternalAPIController::class);
    }

    public function fake()
    {
        $this->data = [
            "id" => Str::random(10),
            "date" => (new \DateTime())->format('Y-m-d'),
            "m_KUNAG" => "",
            "species" => "AA",
            "quantity" => "16000",
            "gift_quantity" => "1000",
            "amount" => "100000",
            "actual_quantity" => "12500",
            "price" => "1.5",
            "package_quantity" => "6",
            "package" => "5",
            "avg_weight" => "50",
            "actual_avg_weight" => "60",
            "total_weight" => "1.5",
            "address" => "台中市",
            "building_number" => "A",
            "created_at" => "",
            "updated_at" => "",
            "chicken_origin" => "台北市",
            'new_data' => true,
        ];

        // 理論上應該一直往下加 不應該POP
        if ($this->inputs->last() == []) {
            $this->inputs->pop();
        }

        //檢查最後一個是否為空陣列

        $this->inputs->push($this->data);

        // $this->showChickenOrigin = false;
    }

    public function render()
    {
        return view('livewire.chicken-import');
    }

    public function mount(Contract $contract, Request $request)
    {
        $this->ExternalAPIController = app(ExternalAPIController::class);
        $this->contract = $contract;
        $this->inputs = collect($contract->chickenImports);
        $this->address = ContractDetail::getAddress($contract);
        if ($this->inputs->count() == 0) {
            // $this->chicken_origin = null;
            $this->addInput();
            // } else {
            //     $this->chicken_origin = $this->inputs->first()['chicken_origin'];
        } else {
            foreach ($this->inputs as $input) {
                // 如果沒有填寫地址，就用合約的地址
                $input['address'] = isset($input['address']) ? $input['address'] : $this->address;
            }
        }
        if ($request->alert != null) {
            // addError是內建的function，可以用來顯示錯誤訊息，在blade用$errors->first('duplicate_date')來顯示
            $this->addError('alert', $request->alert);
        }
    }

    public function submit()
    {
        if (!Gate::allows('create-import', $this->contract)) {
            Gate::authorize('create-import', $this->contract);
        }

        // 如果不是adm或是super_adm，就檢查權限大於1
        if (!(auth()->user()->isAdmin() || auth()->user()->permissions[1] > 1)) {
            abort(403, '你沒有權限進行該操作！');
        }

        $isUpdated = false; // 判斷是否有更新過資料，前端顯示用

        foreach ($this->inputs as $input) {
            $input['contract_id'] = $this->contract->id;
            $input['m_KUNAG'] = $this->contract->m_KUNAG;

            if(isset($input['date'])){
                $inputDate = $input['date'];
            } else {

            }
            // $input['chicken_origin'] = $this->chicken_origin;

            // RawWeight 假資料
                /*
                'batchNumber',
                'Date',
                'time',
                'sensorID',
                'weight',
                    */
            if (isset($input['id'])) {
                //如果是資料庫沒有的資料，就新增
                if (!ChickenImport::where('id', $input['id'])->where('building_number', $input['building_number'])->exists()) {
                    if ($input['building_number'] == null || $input['building_number'] == "") {
                        $input['building_number'] = 'A';
                    }
                    $input['creator'] = auth()->user()->name;
                    try{
                        ChickenImport::Create($input);
                    } catch (QueryException $e) { // 捕获并处理异常
                        $errorMessage = '新增「飼養入雛」資料時發生錯誤。';
                        // 检查异常消息中是否包含 "Data too long for column"
                        if (preg_match('/Data too long for column \'([^\']+)\'/', $e->getMessage(), $matches)) {
                            $column = $matches[1];
                            $errorMessage .= "欄位 '{$column}' 的數據過長，請核對數據。\n詳細錯誤信息：（{$e->getMessage()}）";
                        } else {
                            $errorMessage .= "\n原因：{$e->getMessage()}";
                        }
                            throw new \Exception($errorMessage);
                    }

                    $isUpdated = false; // 新增操作不算作更新

                    $this->callUpdateAPI($input);
                    $this->saveData();
                    continue;
                } else {
                    if (isset($input['new_data'])) {
                        $this->addError('same_import', '資料庫已有相同的批次編號' . $input['id'] . '_' . $input['building_number'] . '，請重新輸入！');
                        return ;
                    }
                    //如果是已建立的資料，就更新
                    // dd($input);
                    $input['last_editor'] = auth()->user()->name;
                    // dd($input['created_at']);
                    if ($input['created_at'] == null) {
                        $input['created_at'] = now();
                    }
                    if ($input['m_KUNAG'] == null) {
                        $input['m_KUNAG'] = $this->inputs[0]['m_KUNAG'];
                    }
                    $input['created_at'] = date('Y-m-d H:i:s', strtotime($input['created_at']));
                    $input['updated_at'] = now();
                    ChickenImport::where('id', $input['id'])->where('m_KUNAG', $input['m_KUNAG'])->where('building_number', $input['building_number'])->update($input);

                    $this->callUpdateAPI($input);

                    $isUpdated = true; // 更新操作
                }
            } else {

                if (!is_array($input)) {
                    continue;
                }

                if (!isset($input['avg_weight'])) {
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
            }
        }
        $this->saveImg();
        $successMessage = $isUpdated ? '更新成功' : '創建成功';
        $this->dispatchBrowserEvent('save-successful', ['message' => $successMessage]);

        return redirect()->route('chicken-import.create', $this->contract->id);
    }

    public function saveData()
    {
        // getSid 移到點擊 "飼養入雛表" 時觸發
        // $sidData = $this->ExternalAPIController->getSid();
        $sensorData = $this->ExternalAPIController->getSensor();
    }

    private function callUpdateAPI($input)
    {
        $url = "http://1.34.47.251:28888/api/client/batch_update.php";

        $sid = ChickenImport::where('id', $input['id'])
            ->where('building_number', $input['building_number'])
            ->first()->chicken_sid;

        $quantity = isset($input['actual_quantity']) ? $input['actual_quantity'] : '';

        $params = [
            'sid' => $sid,
            'batchNumber' => $input['id'],
            'start_date' => $input['date'],
            'quantity' => $input['actual_quantity']
        ];

        // 使用curl或其他HTTP客戶端庫調用API
        // 這裡以curl為例
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    public function addInput()
    {
        if (!Gate::allows('create-import', $this->contract)) {
            Gate::authorize('create-import', $this->contract);
            $this->inputs->pop();
        }
        $this->inputs->push(['address' => $this->address, 'new_data' => true]);
        // dd($this->inputs);
    }

    public function delete($index)
    {
        if (!isset($this->inputs[$index]['id'])) {
            $this->inputs->forget($index);
            return;
        }

        // dd($this->inputs[$index]['id']);
        // dd(Auth::user()->name);
        BreedingLog::where('chicken_import_id', '=', [$this->inputs[$index]['id']])->where('building_number', '=', $this->inputs[$index]['building_number'])->delete();
        BreedingPerformance::where('chicken_import_id', '=', [$this->inputs[$index]['id']])->where('building_number', '=', $this->inputs[$index]['building_number'])->delete();
        FeedingLog::where('chicken_import_id', '=', [$this->inputs[$index]['id']])->where('building_number', '=', $this->inputs[$index]['building_number'])->delete();
        ChickenImport::whereIn('id', [$this->inputs[$index]['id']])->where('building_number', '=', $this->inputs[$index]['building_number'])->delete();
        try {
            // 生成一個delete_log.txt，如果沒有則建立一個，寫入序號-時間戳記-filename-錯誤訊息
            $log = fopen("/mnt/bpm_test/ToFSFMS/delete_log.txt", "a");
            $time = date("Y-m-d H:i:s", time());
            // dd($time);
            fwrite($log, $time . "-" . $this->inputs[$index]['id'] . "-" . "deleted by " . Auth::user()->name . "\n");
            fclose($log);
        } catch (\Exception $e) {
        }

        $this->inputs->forget($index);
        $this->chicken_origin = $this->inputs->count() == 0 ? null : $this->inputs->first()['chicken_origin'];
        // return redirect()->route('chicken-import.create', $this->contract->id);
        return;
    }

    // 上傳圖片
    public function saveImg()
    {
        $this->validate([
            'photos.*' => 'image|max:5120', // 5MB Max
        ]);

        $path = 'Import';
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        foreach ($this->photos as $key => $photo) {

            // 取得檔案副檔名
            $extension = $photo->getClientOriginalExtension();
            // 將檔案名稱變為 合約 m_NAME + 批次編號
            // 不加入extension的話，中文檔名的檔案會無法存成圖片
            // dd($this->inputs);
            $filename = $this->contract->m_NAME . "_" . $this->inputs[$key]['id'] . '.' . $extension;

            // 檢查檔案是否已經存在
            if (Storage::exists($path . '/' . $filename)) {
                // 提示使用者是否要覆蓋
                if ($this->confirmOverwrite($filename)) {
                    $photo->storeAs($path, $filename);
                }
            } else {
                $photo->storeAs($path, $filename);
            }
        }
    }

    //篩選資料庫
    public function search()
    {
        $this->inputs = collect($this->contract->chickenImports);

        if ($this->select_start_date != "") {
            $this->inputs = $this->inputs->where('date', '>=', $this->select_start_date);
        }

        if ($this->select_end_date != "") {
            $this->inputs = $this->inputs->where('date', '<=', $this->select_end_date);
        }
    }
}
