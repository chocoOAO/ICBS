<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationMenuController extends Controller
{

    public function index(Request $request, Contract $contract)
    {
        return view('livewire.navigation-menu');
    }

}
