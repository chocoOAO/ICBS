<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChickenImportController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ChickenOutController;
use App\Http\Controllers\ExternalAPIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GrowthRecordController;

use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/test', function () {
//     return response()->json([
//         'name' => 'Abigail',
//         'state' => 'CA',
//     ]);
// });

Route::resource('chicken-import', ChickenImportController::class);
Route::resource('chicken-contract', ContractController::class);
Route::resource('chicken-out', ChickenOutController::class);

// 緯創 API
Route::get('/sensor-get', [ExternalAPIController::class, 'getSensor']);
Route::get('/weight-raw', [ExternalAPIController::class, 'getWeightRaw']);
Route::get('/weight-average', [ExternalAPIController::class, 'getWeightAverage']);
Route::get('/temp-get', [ExternalAPIController::class, 'getSensorDataTemp']);
Route::get('/humidity-get', [ExternalAPIController::class, 'getSensorDataHumidity']);
Route::get('/co2-get', [ExternalAPIController::class, 'getSensorDataCo2']);
Route::get('/nh3-get', [ExternalAPIController::class, 'getSensorDataNh3']);
Route::get('/water-get', [ExternalAPIController::class, 'getWater']);

//參照:福壽2緯創API定義_20230918.docx
Route::get('/user/search', [UserController::class, 'search']);
Route::get('/growth/antibiotics/search', [GrowthRecordController::class, 'searchAntibiotics']);

// API8 回報飼養日誌之用藥紀錄
// Route::post('/feeding-log', 'GrowthRecordController@store');
Route::get('/cre-feeding-log', [GrowthRecordController::class, 'createFeedingLog']);
Route::put('/upd-feeding-log', [GrowthRecordController::class, 'updateFeedingLog']);
// Route::post('/upd-feeding-log/{id}', [GrowthRecordController::class, 'updateFeedingLog']);
// ------------------------------------------------------------------------------



// Route::resource('chicken-import', Api\ChickenImportController::class);
