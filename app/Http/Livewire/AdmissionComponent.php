<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdmissionComponent extends Component
{
    public Contract $contract;

    public function render()
    {
        return view('livewire.admission');
    }
    public function mount(Contract $contract, Request $request)
    {
        $this->contract = $contract;
    }
}