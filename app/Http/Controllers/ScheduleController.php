<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ChickenImport;
use App\Models\ChickenOut;
use App\Models\RawWeight;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PredictWeightResult;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        ///ROSS標準資料參照
        
        $standard_data = [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235];
        ///為了遞補預測17-21天重量
        $backfill = [701,768,837,910,985];
        if ($request->ajax()) {
            $need_predict_information = DB::table('predict_weight_result')
            ->select(
                DB::raw("predict_weight_result.title as title"),
                DB::raw("predict_weight_result.start as start")
            )->get();            
            ///派車單的資料抓取
            $chicken_out_data = DB::table('contracts')
            ->join('chicken_imports', 'contracts.id', '=', 'chicken_imports.contract_id')
            ->join('chicken_outs', function ($join) {
                $join->on('contracts.id', '=', 'chicken_outs.contract_id')
                    ->on('chicken_outs.chicken_import_id', '=', 'chicken_imports.id')
                    ->on('chicken_outs.building_number', '=', 'chicken_imports.building_number');
            })
            ->select(
                DB::Raw("CONCAT(chicken_imports.id, '-' ,contracts.name_b,'-',chicken_imports.building_number,'-', SUM(chicken_outs.quantity)) as title"),
                DB::Raw("chicken_outs.date as start")
            )
            ->havingRaw("SUM(chicken_outs.quantity) IS NOT NULL")
            ->groupBy('chicken_imports.id', 'contracts.name_b','chicken_imports.building_number','chicken_outs.date')
            ->get();

            ///派車單在行事曆上顯示設定
            foreach ($chicken_out_data as $key => $value) {
                    // 使用explode分割title字串
                $titleParts = explode('-', $value->title);
                    // 使用end函數獲取陣列的最後一個元素，即actual_quantity的值
                $actualQuantity = end($titleParts);

                    // 根據 actual_quantity 的值來設置顏色
                if ($actualQuantity <= 50000) {
                    $chicken_out_data[$key]->color = 'green';
                    $chicken_out_data[$key]->textColor = 'white';
                }
                else{
                    $chicken_out_data[$key]->color = 'red';
                    $chicken_out_data[$key]->textColor = 'white';
                }
            }

            $totalQuantity = 0;
            $quantityPerDay = [];
            ///預測資料在行事曆上顯示設定
            foreach ($need_predict_information as $key => $value) {
                $titleParts = explode('-', $value->title);
                $secondToLast = intval($titleParts[count($titleParts) - 2]);

                // 將日期作為 key，將倒數第二個資料的值加到該日期的加總中
                $itemDate = $value->start;
                if (!isset($quantityPerDay[$itemDate])) {
                    $quantityPerDay[$itemDate] = 0;
                }

                $quantityPerDay[$itemDate] += $secondToLast;
            }
            foreach ($need_predict_information as $key => $value) {
                $itemDate = $value->start;

                if (isset($quantityPerDay[$itemDate]) && $quantityPerDay[$itemDate] >= 65000) {
                    $need_predict_information[$key]->textColor = 'red';
                }


                $need_predict_information[$key]->color = 'gray';
            }

            // 最後整合兩筆資料
            $chicken_out_data=$chicken_out_data->merge($need_predict_information);
            return response()->json($chicken_out_data);
        }
        return view('schedule.list');
    }
}