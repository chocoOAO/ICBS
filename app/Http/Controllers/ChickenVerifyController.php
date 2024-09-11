<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;


class ChickenVerifyController extends Controller
{
    public function create(Contract $contract)
    {
        return view('chicken-verify.create', compact('contract'));
    }
}
