<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\ExcelController;

class SettlementController extends Controller
{
    protected $excelController;

    public function __construct(ExcelController $excelController)
    {
        
        $this->excelController = $excelController;
        $this->excelController->db_store();
    }

    public function testGetExcelFromTestExcels()
    {
        // 使用控制器B的方法
        $excelData = $this->excelController->read();
        return $excelData;
    }

    public function index(Request $request, Contract $contract)
    {
        // dd($request->all());
        return view('settlement.index', compact('contract'));
    }
    public function select(Request $request, Contract $contract)
    {
        // dd($request->all());
        return view('settlement.select', compact('contract'));
    }
}
