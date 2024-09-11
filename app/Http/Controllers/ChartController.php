<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Illuminate\Support\Facades\Gate;

class ChartController extends Controller
{
    public function index(Contract $contract)
    {
        if (!Gate::allows('view-import', $contract)) {
            Gate::authorize('view-import', $contract);
        }

        return view('chart.line-chart', compact('contract'));
    }
}
