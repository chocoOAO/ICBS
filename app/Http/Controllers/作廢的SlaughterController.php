<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ChickenImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SlaughterController extends Controller
{
    public function index(Request $request)
    {
        return view('chicken-slaughter.index', [
            'select_day' => $request,
            'select_weight' => $request,
            'select_import_day' => $request,
            'select_future_weight' => $request,
        ]);
    }

}
