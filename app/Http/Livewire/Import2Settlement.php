<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\Contract;
use Illuminate\Http\Request;

class import2settlement extends Component
{
    public Collection $inputs;
    public Contract $contract;
    public $batch_number = -1;

    public function render()
    {
        return view('livewire.import2settlement');
    }

    public function mount(Contract $contract, Request $request)
    {
        $this->contract = $contract;
        $this->inputs = collect($contract->chickenImports);
        if ($this->inputs->count() == 0) {
            $this->addInput();
        } else {
            $this->batch_number = $this->inputs->max('batch_number') + 1;
        }
    }

    public function addInput()
    {
        $this->inputs->push([]);
    }

    public function selectContract()
    {
        session(['selectContract' => $this->contract_id]);
    }

}
