<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PredictServiceProvider  extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function exePython(int $begin = 21, int $day1 = 637, int $day2 = 701, int $day3 = 768, int $day4 = 837, int $day5 = 910, int $region = 1)
    {
        /*
        1.找到對應的Python.exe
        2.先安裝足夠的套件給play21.py用
        3.執行exec("Python.exe 路徑" "欲執行之程式" "參數1" "參數2" ...")
        */

        // $path = "C:\\FwuSowChickenWeb\\public\\py\\play21.py";
        // $output_file = "C:\\FwuSowChickenWeb\\storage\\app\\tmp\\out.json";

        // // 補充: 需在 app 新增 tmp 資料夾
        // exec("C:\\Users\\salasrew\\AppData\\Local\\Programs\\Python\\Python311\\python \"$path\" 21 637 701 768 837 910 1 > \"$output_file\"");
        // $result = json_decode(file_get_contents('C:\\FwuSowChickenWeb\\storage\\app\\tmp\\out.json'), true);
        // return $result;

        $command = "C:/Users/Salasrew/AppData/Local/Programs/Python/Python312/python ./py/play21.py $begin $day1 $day2 $day3 $day4 $day5 $region";
        $result = exec($command);
        return $result;
    }
}
