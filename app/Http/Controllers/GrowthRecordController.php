<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\FeedingLog;
use App\Models\ChickenImport; //飼養紀錄表
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GrowthRecordController extends Controller
{

    public function create(Contract $contract, Request $request)
    {

        if (!Gate::allows('view-growth')) {
            Gate::authorize('view-growth');
        }

        return view('growth-record.create', [
            'contract' => $contract,
            'import' => $request,
        ]);
    }

    public function searchAntibiotics(Request $request)
    {
        $batchNumber = $request->input('batchNumber');

        $growthrecord = FeedingLog::where('chicken_import_id', $batchNumber)->first();

        if (!$growthrecord) {
            return response()->json(['type' => 'batchNumber No Exist'], 404);
        }

        return response()->json([
            'chicken_import_id' => $batchNumber,
            'add_antibiotics' => $growthrecord->add_antibiotics == 1 ? 'true' : 'false',
        ]);
    }

    public function createFeedingLog(Request $request)
    {
        $validatedData = $request->validate([
            'building_number' => 'required', // 棟別
            'chicken_import_id' => 'required', // 批號
            'date' => 'required|date', // 日期
            'feed_type' => 'required', // 飼養行為
            'feed_item' => 'required', // 投料名稱
            'feed_quantity' => 'required|numeric', // 飼料量
            'add_antibiotics' => 'required|in:Y,N' // 使用抗生素
        ]);

        $validatedData['add_antibiotics'] = $validatedData['add_antibiotics'] === 'Y' ? 1 : 0;

        $existingLog = FeedingLog::where($validatedData)->first();
        if ($existingLog) {
            $errorResponse = ['status' => 'error', 'message' => 'The feeding log already exists.'];
            return response()->json($errorResponse)->header('Content-Type', 'application/json; charset=utf-8');
        }

        $contractIdValue = $this->getContractIdValueBasedOnLogic($validatedData['chicken_import_id'], $validatedData['building_number']);

        if (!$contractIdValue) {
            // 如果未找到相應的記錄，返回錯誤訊息
            $errorResponse = ['status' => 'error', 'message' => 'chicken_import_id or building_number not found.'];
            return response()->json($errorResponse)->header('Content-Type', 'application/json; charset=utf-8');
        }

        // 將合同ID的值添加到驗證資料中
        $validatedData['m_KUNAG'] = $contractIdValue['m_KUNAG'];
        $validatedData['contract_id'] = $contractIdValue['contract_id'];

        // 創建會更新資料庫的新記錄
        try {
            // 創建新的 FeedingLog 紀錄
            $feedingLog = FeedingLog::create($validatedData);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            // 如果有錯誤，返回錯誤信息
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    protected function getContractIdValueBasedOnLogic($chicken_import_id, $building_number)
    {
        $chickenImport = ChickenImport::where('id', $chicken_import_id)
                                        ->where('building_number', $building_number)
                                        ->first();

        if ($chickenImport) {
            // 獲取相應的 m_KUNAG 和 contract_id 值
            $m_KUNAG = $chickenImport->m_KUNAG;
            $contract_id = $chickenImport->contract_id;

            // 返回這些值
            return [
                'm_KUNAG' => $m_KUNAG,
                'contract_id' => $contract_id
            ];
        } else {
            // 如果找不到相應的記錄，返回一個默認值或者引發一個錯誤
            // 在這個示例中，我們返回一個空陣列
            return null;
        }
    }
    public function updateFeedingLog(Request $request)
    {
        // 驗證請求數據
        $validatedData = $request->validate([
            'building_number' => 'required', // 棟別
            'chicken_import_id' => 'required', // 批號
            'date' => 'required|date', // 日期
            'feed_type' => 'required', // 飼養行為
            'feed_item' => 'required', // 投料名稱
            'feed_quantity' => 'required|numeric', // 飼料量
            'add_antibiotics' => 'required|in:Y,N' // 使用抗生素
        ]);

        $existingLog = FeedingLog::where([
            'building_number' => $validatedData['building_number'],
            'chicken_import_id' => $validatedData['chicken_import_id'],
            'date' => $validatedData['date'],
        ])->first();

        if (!$existingLog) {
            // 如果不存在相應的記錄，返回錯誤訊息
            $errorResponse = ['status' => 'error', 'message' => 'The feeding log does not exist.'];
            return response()->json($errorResponse)->header('Content-Type', 'application/json; charset=utf-8');
        }

        // 更新記錄
        try {
            $existingLog->update([
                'feed_type' => $validatedData['feed_type'],
                'feed_item' => $validatedData['feed_item'],
                'feed_quantity' => $validatedData['feed_quantity'],
                'add_antibiotics' => $validatedData['add_antibiotics'] === 'Y' ? 1 : 0,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Feeding log updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function checkFeedingLog(Request $request)
    {
        // 获取要更新的记录的ID
        $id = $request->input('id');

        if (!$id) {
            $errorResponse = ['status' => 'error', 'message' => 'No ID provided.'];
            return response()->json($errorResponse)->header('Content-Type', 'application/json; charset=utf-8');
        }

        // 调用 updateFeedingLog() 方法并传递请求和记录ID
        return $this->updateFeedingLog($request, $id);
    }
    
}
