<?php

namespace App\Http\Livewire\Steps;

use Livewire\Component;
use Spatie\LivewireWizard\Components\StepComponent;

class ChooseContractTypeStepComponent extends StepComponent
{
    public $type = null;

    public function chooseType($type = 1)
    {
        $this->type = $type;
        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => '選擇合約類型',
        ];
    }

    public function render()
    {
        return view('livewire.steps.choose-contract-type');
    }
}
