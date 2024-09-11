<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Spatie\SimpleExcel\SimpleExcelReader;


class PredictComponent extends Component
{
    public $filePath;
}