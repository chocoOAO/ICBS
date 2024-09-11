<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Test;
use App\Models\ZCusKna1;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use App\Models\Settlement;
use App\Models\SettlementAccountNumber;

class ExcelController extends Controller
{
    // 寫死的 讀取緯創提供的excel
    public function readExcel()
    {
        // $filePath = storage_path('app/excels/aaa.xls');
        // #設備名稱-日期時間-平均體重（g）-場域平均體重（g）-場域均勻度（%）-成長速度（g/天）
        $filePath = storage_path('/excels/aaa.xls');

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];

        // 顯示指定欄位日期 時間 平均體重
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $columnIndex = $cell->getColumn();

                // 只处理索引为 3、4 和 5 的列（日期、时间和平均体重）
                if ($columnIndex == 'C' || $columnIndex == 'D' || $columnIndex == 'E') {
                    $rowData[] = mb_convert_encoding($cell->getValue(), 'UTF-8');
                }
            }
            $data[] = $rowData;
        }

        // echo "<pre>";
        // print_r($data);

        return $data;
    }

    // 用以讀取洽富提供的Excel資料給前端用 暫時寫死的
    public function read()
    {
        // $filePath = storage_path('app/excels/aaa.xls');
        $filePath = storage_path('app/excels/AP20231218001.xlsx');

        $spreadsheet = IOFactory::load($filePath);

        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        // 顯示所有欄位
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = mb_convert_encoding($cell->getValue(), 'UTF-8');
            }
            $data[] = $rowData;
        }

        // echo "<pre>";
        // print_r($data);

        return $data;
    }

    // 還沒用到
    public function writeExcel()
    {
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        // 设置单元格值
        $worksheet->setCellValue('A1', 'Hello');
        $worksheet->setCellValue('B1', 'World!');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filePath = storage_path('app/excels/output.xlsx');
        $writer->save($filePath);

        return "Excel file created!";
    }

    // Ajax傳資料用
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->readExcel();

            return response()->json($data);
        }
    }

    // Ajax傳資料用
    public function getReadData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->read();

            return response()->json($data);
        }
    }

    // 讀取storage_path('/excels/)內所有的excel檔案，寫入file_log.txt裡面
    // 之後讀取file_log.txt裡面的檔案，
    // 並且寫入資料庫，如果再將檔案移動至資料夾exist，沒有資料夾則建立一個
    public function db_store()
    {
        // 定義快取鍵和過期時間（15 分鐘）
        $cacheKey = 'db_store_data';
        $cacheDuration = 15 * 60; // 15 分鐘，以秒為單位

        // 檢查快取中是否有資料
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey); // 從快取中獲取資料
        }

        // 如果快取中沒有資料，執行資料處理
        Test::truncate();
        // Settlement::truncate();

        $excelPath = '/mnt/bpm_test/ToFSFMS/qiafu_folder/newCreate_folder';
        $files = \File::files($excelPath);
        $processedData = [];

        foreach ($files as $file) {
            $filePath = $file->getPathname();
            $filename = basename($filePath, '.xlsx');
            $existingRecord = Test::where('account_number', 'LIKE', $filename . '%')->first();

            if ($existingRecord) {
                return "Record already exists!";
            }

            // 讀取Excel檔案
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $counter = 0;
            $totalRows = $worksheet->getHighestRow();

            $isFirstRow = true;
            $fieldNames = ["number","source","traceability","weighing_date","chicken_imports_id","account_number","breeder", "livestock_farm_name","batch","car_number","description","kilogram_weight","catty_weight","total_of_birds", "average_weight","down_chicken", "death", "discard", "stinking_claw", "dermatitis", "stinking_chest", "residue", "price_of_newspaper","unit_price","notes"];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                $counter++;

                if ($counter <= 1 || ($counter == $totalRows && empty($row->getCellIterator()->seek("B")->current()->getValue()))) {
                    continue;
                }

                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }

                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }

                if (count($rowData) < 25) {
                    $rowData = array_pad($rowData, 25, null);
                }

                $data = array_combine($fieldNames, $rowData);
                if (count(array_filter($data)) > 0) {
                    Test::create($data);
                    Settlement::create($data);
                    $processedData[] = $data;
                }
            }
        }

        // 將結果存儲到快取中，並設置過期時間為15分鐘
        Cache::put($cacheKey, $processedData, $cacheDuration);

        return $processedData;
    }

    // 載入客戶主檔資料
    // 1.讀取路徑
    // 2.分別取得A B C 行
    // 3.將A B C的資料整列一筆一筆存入 SQL
    // 4.如果客戶代號有重複的就不存入
    public function load()
    {
        // 每次執行更新看看有無最新的檔案
        // $this->update();

        // 讀取最新的檔案
        $directory = storage_path('excels'); // 指定目录
        $pattern = $directory . '/客戶主檔-*.xlsx'; // 客戶主檔文件的 glob 模式

        $latestFile = null;
        $latestDate = null;

        foreach (File::glob($pattern) as $filePath) {
            if (preg_match('/客戶主檔-(\d{8})\.xlsx$/', basename($filePath), $matches)) {
                $fileDate = Carbon::createFromFormat('Ymd', $matches[1]);

                if ($latestDate == null || $fileDate > $latestDate) {
                    $latestDate = $fileDate;
                    $latestFile = $filePath;
                }
            }
        }

        // $logPath = storage_path('/excels/客戶主檔-20230908.xlsx');
        $logPath = $latestFile;
        $spreadsheet = IOFactory::load($logPath);
        $worksheet = $spreadsheet->getActiveSheet();

        $isFirstRow = true;
        $fieldNames = [
            'm_KUNAG',
            'm_NAME',
            'm_ADDSC',
        ];
        // $log = fopen("/mnt/bpm_test/ToFSFMS/mKUNAGWritingLog.txt", "a");

        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }

            if ($isFirstRow) {
                // $fieldNames = $rowData;
                $isFirstRow = false;
                continue;
            }

            $data = array_combine($fieldNames, $rowData);
            $status = 'Success';
            try {
                $time = date("Y-m-d H:i:s", time());
                // 检查客户代号是否重复
                $existingRecord = ZCusKna1::where('m_KUNAG', $data['m_KUNAG'])->first();
                if (!$existingRecord) {
                    // 如果客户代号不重复，将数据插入数据库
                    ZCusKna1::create($data);
                }
            } catch (\Exception $e) {
                // $logEntry['status'] = 'Failure';
                // $logEntry['error'] = $e->getMessage();
                // 如果移动失败，可能需要删除之前复制的文件
                $status = 'Failure';
                // File::delete($destinationFilePath);
            }
            // fwrite($log, $time . "-" . $logPath . "-" . $data['m_KUNAG']."-" . $status . "\n");
        }
        // fclose($log);

        // echo $logPath;
    }
    private function update()
    {
        $sourceDirectory = '/mnt/bpm_test/ToFSFMS';
        $destinationDirectory = storage_path('excels');
        $completeDirectory = '/mnt/bpm_test/ToFSFMS/Complete';
        // if (!file_exists($completeDirectory)) {
        //     mkdir($completeDirectory, 0777, true); // 创建 Complete 文件夹，如果不存在
        // }

        // 使用 glob 搜索所有符合条件的文件
        $files = File::glob($sourceDirectory . '/客戶主檔*.xlsx');

        foreach ($files as $sourceFilePath) {
            $filename = basename($sourceFilePath);
            $destinationFilePath = $destinationDirectory . '/' . $filename;
            $completeFilePath = $completeDirectory . '/' . $filename;
            $status = 'Success';
            $logEntry = [
                'time' => now()->tz('Asia/Taipei')->toDateTimeString(),
                'filename' => $filename,
                'sourcePath' => $sourceFilePath,
                'destinationPath' => $destinationFilePath,
                'status' => 'Success',
                'error' => ''
            ];
            $log = fopen("/mnt/bpm_test/ToFSFMS/log.txt", "a");

            try {
                File::copy($sourceFilePath, $destinationFilePath);
                File::move($sourceFilePath, $completeFilePath);
                $time = date("Y-m-d H:i:s", time());
            } catch (\Exception $e) {
                // $logEntry['status'] = 'Failure';
                // $logEntry['error'] = $e->getMessage();
                // 如果移动失败，可能需要删除之前复制的文件
                $status = 'Failure';
                // File::delete($destinationFilePath);
            }
            fwrite($log, $time . "-" . $filename . "-" . $sourceFilePath . "-" . $destinationFilePath . "-" . $status . "\n");
            fclose($log);
        }

        // 检查Log.txt是否存在，不存在则创建
        if (!File::exists($destinationDirectory . "Log.txt")) {
            File::put($destinationDirectory, 'Log.txt'); // 创建空文件
        }

        // // 生成日志文件
        // $logContent = array_map(function ($entry) {
        //     return implode("\t", $entry);
        // }, $logEntry);
        // File::put($destinationDirectory."Log.txt", implode("\n", $logContent));
    }
}