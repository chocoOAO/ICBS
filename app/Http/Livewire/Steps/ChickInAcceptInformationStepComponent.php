<?php

namespace App\Http\Livewire\Steps;

use Livewire\Component;
use Spatie\LivewireWizard\Components\StepComponent;

class ChickInAcceptInformationStepComponent extends StepComponent
{
    public $data = [];

    public $type = 0;

    public $view = false;

    // 這個用來保存第一個畫面中看起來屬於細節得資料
    // 我覺得畫面還要再重構 不然有不相關的東西要額外保存
    public $extraData = [];

    public $contract_id = "";

    public $copy = false;

    public function submit()
    {
        // $this->validate();

        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => '入雛驗收資訊',
        ];
    }

    public function render()
    {
        return view('livewire.steps.chickInAccept-basic-information');
    }
}
