<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ChickenImport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\XmlController;
use App\Http\Controllers\ExternalAPIController;
use Symfony\Component\Process\Process;
use App\Jobs\ProcessAPIsix;

class ChickenImportController extends Controller
{
    private $ExternalAPIController;

    public function __construct()
    {
        // Dependency injection to get the controller instance
        $this->ExternalAPIController = app(ExternalAPIController::class);
    }
    public function create(Contract $contract, Request $request)
    {
        if (!Gate::allows('view-import', $contract)) {
            Gate::authorize('view-import', $contract);
        }
        $xmlController = new XmlController();

        $xmlController->writeInDB();

        $sidData = $this->ExternalAPIController->getSid();

        ProcessAPIsix::dispatch();

        return view('chicken-import.create', [
            'contract' => $contract,
            'alert' => $request->alert,
        ]);
    }
}
