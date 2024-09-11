<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ChickenImportController;
use App\Http\Controllers\ChickenVerifyController;
use App\Http\Controllers\GrowthRecordController;
use App\Http\Controllers\TraceabilityController;
use App\Http\Controllers\ChickenOutController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PredictController;
// use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionManagementController;
// use App\Http\Controllers\GuestController;

use App\Http\Controllers\XmlController;
use App\Http\Controllers\ExternalAPIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome2');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 合約CRUD 單數 contract 複數 contracts
    Route::get('/contracts',  [ContractController::class, 'list'])->name('contracts');
    Route::get('/contracts/create',  [ContractController::class, 'create'])->name('contract.create');
    Route::get('/contract/{contract}',  [ContractController::class, 'view'])->name('contract.view');
    Route::get('/contract/{contract}/edit',  [ContractController::class, 'edit'])->name('contract.edit');
    Route::get('/contract/{contract}/copy',  [ContractController::class, 'copy'])->name('contract.copy');
    Route::get('/contract/delete/{contract}',  [ContractController::class, 'delete'])->name('contract.delete');

    // 入雛
    Route::get('/contract/{contract}/chicken-import/create/{alert?}',  [ChickenImportController::class, 'create'])->name('chicken-import.create');

    // ToDo：入雛頁面
    Route::get('/contract/chicken-import/',  [ChickenImportController::class, 'create'])->name('chicken-import');

    // 驗收
    Route::get('/contract/{contract}/chicken-verify/create',  [ChickenVerifyController::class, 'create'])->name('chicken-verify.create');

    // 生長紀錄表
    Route::get('/contract/{contract}/growth-record/{import?}',  [GrowthRecordController::class, 'create'])->name('growth-record.create');

    // 預計排程
    // Route::get('/schedule',  [ScheduleController::class, 'index'])->name('schedule');
    Route::get('/schedule',  [ScheduleController::class, 'index'])->name('schedule');

    // 出雞表
    Route::get('/contract/{contract}/chicken-out/create/{import?}',  [ChickenOutController::class, 'create'])->name('chicken-out.create');

    // 產銷履歷
    Route::get('/contract/{contract}/traceability',  [TraceabilityController::class, 'index'])->name('traceability');

    // 毛雞結款單
    Route::get('/contract/{contract}/selectChickenImport',  [SettlementController::class, 'select']);
    Route::get('/contract/{contract}/settlement',  [SettlementController::class, 'index'])->name('settlement');

    // 入場紀錄
    Route::get('/contract/{contract}/admission',  [AdmissionController::class, 'index'])->name('admission');

    // PDF
    Route::get('/export-pdf',  [PDFController::class, 'exportPDF'])->name('export-pdf');


    // CSV Controller 純粹測試套件好用不
    Route::get("/data", [CsvController::class, "index"]);

    // Excel Controller
    Route::get('/read-excel', [ExcelController::class, 'readExcel']);
    Route::get('/write-excel', [ExcelController::class, 'writeExcel']);
    Route::get('/getData', [ExcelController::class, 'getData']);
    Route::get('/getReadData', [ExcelController::class, 'getReadData']);


    Route::get('/contract/{contract}/line-chart', [ChartController::class, 'index'])->name('lineChart');

    // Route::get('/exePython', [ExcelController::class, 'exePython']);

    // User permission management
    Route::get('/user-permission-management', [UserPermissionManagementController::class, 'permissionManagement'])->name('user-permission-management');
    Route::post('/user-permission-management/add_user', [UserPermissionManagementController::class, 'add_user'])->name('user-permission-management.add_user');
    Route::post('/user-permission-management/search_user', [UserPermissionManagementController::class, 'search_user'])->name('user-permission-management.search_user');

    });


// 該用戶底下尚無任何飼養批次
Route::get('/guest', [UserController::class, 'visit'])->name('guest');

// 用以執行興大的Python程式
Route::get('/exePython', [PredictController::class, 'exePython']);
// 用以讀取洽富提供的Excel資料給前端用 暫時寫死的
Route::get('/read', [ExcelController::class, 'read']);
// 讀取storage_path('app/excels/)內所有的excel檔案，寫入file_log.txt裡面
// 之後讀取file_log.txt裡面的檔案，
// 並且寫入資料庫，如果再將檔案移動至資料夾exist，沒有資料夾則建立一個
Route::get('/store', [ExcelController::class, 'db_store']);

Route::get('/getFolderFiles', [XmlController::class, 'getFolderFiles']);

// writeInDB
Route::get('/writeInDB', [XmlController::class, 'writeInDB']);

Route::get('/processFeedFile', [XmlController::class, 'processFeedFile']);

Route::get('/processFeedFile/{contract_id}/{sn2}', [XmlController::class, 'processFeedFile'])->middleware('web');

// offline
Route::get('/xml2DB', [XmlController::class, 'xml2DB']);

Route::get('/sensor-get', [ExternalAPIController::class, 'getSensor']);
Route::get('/weight-raw', [ExternalAPIController::class, 'getWeightRaw']);

// 取得各場域資料
Route::get('/sid-get', [ExternalAPIController::class, 'getSid']);
Route::get('/cre-feeding-log', [GrowthRecordController::class, 'createFeedingLog']);
Route::get('/upd-feeding-log', [GrowthRecordController::class, 'updateFeedingLog']);
// Route::post('/upd-feeding-log/{id}', [GrowthRecordController::class, 'updateFeedingLog']);
Route::get('/getUserPassword', [ExternalAPIController::class, 'getUserPassword']);
