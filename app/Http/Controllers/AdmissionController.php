<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;


class AdmissionController extends Controller
{
    public function index(Request $request, Contract $contract)
    {
        return view('admission.index', [
            'contract' => $contract,
            'import' => $request,
        ]);
    }
}