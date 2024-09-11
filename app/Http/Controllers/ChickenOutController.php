<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;

class ChickenOutController extends Controller
{
    //
    public function create(Contract $contract)
    {
        return view('chicken-out.create', compact('contract'));
    }

}
