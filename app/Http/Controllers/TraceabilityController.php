<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class TraceabilityController extends Controller
{
    public function index(Request $request, Contract $contract)
    {
        return view('traceability.index', [
            'contract' => $contract,
            'import' => $request,
        ]);
    }
}