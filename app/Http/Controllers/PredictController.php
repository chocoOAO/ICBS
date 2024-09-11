<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\ExcelImportController;

class PredictController extends Controller
{

    public function exePython(int $begin = 21, array $data = [], int $region = 1)
    {
        /*
        1.找到對應的Python.exe
        2.先安裝足夠的套件給play21.py用
        3.執行exec("Python.exe 路徑" "欲執行之程式" "參數1" "參數2" ...")
        */
        // $path = "C:\FwuSowChickenWeb\public\py\play21.py";
        // $output_file = "C:\FwuSowChickenWeb\storage\app\tmp\out.json";

        $weights = array_map(function ($item) {
            return $item['weight'];
        }, $data);

        // 使用 array_slice 函数提取前5个元素
        $weightsSlice = array_slice($weights, 0, 5);
        // dd($weightsSlice);
        // 将提取的元素分别存储到 $day1 到 $day5 变量中

        $day1 = (int)$weightsSlice[0];
        $day2 = (int)$weightsSlice[1];
        $day3 = (int)$weightsSlice[2];
        $day4 = (int)$weightsSlice[3];
        $day5 = (int)$weightsSlice[4];

         $command = "C:\Python312/python ./public/py/play21.py $begin $day1 $day2 $day3 $day4 $day5 $region";
        // 主機上的Python路徑
        //$command = "/usr/bin/python3 ./py/play21.py $begin $day1 $day2 $day3 $day4 $day5 $region";
        // $command = "C:\Python312/python ./py/play21.py $begin $day1 $day2 $day3 $day4 $day5 $region";
        foreach ($weightsSlice as $line) {
            echo $line . PHP_EOL;
        }
        $result = exec($command);
        // dd($result);
        $predictWeight = explode(" ", $result);

        // Date 依序存入 $dates的值
        for($i=0;$i<5;$i++){
            $newData[] = [
                // 'batchNumber' => 'ARjdSbXoRy',
                'weight' => $predictWeight[$i],
                'age' => 31 + $i,
            ];
        }
        return $newData;
    }
}
