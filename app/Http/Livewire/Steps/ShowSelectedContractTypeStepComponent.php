<?php

namespace App\Http\Livewire\Steps;

use Livewire\Component;
use App\Models\Contract;
use App\Models\ContractDetail;
use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Support\Facades\Log;

class ShowSelectedContractTypeStepComponent extends StepComponent
{
    public $data = [];

    public function submit()
    {
        $isView = $this->state()->forStep('basic-information-step')['view'] == false;
        $copy = $this->state()->forStep('basic-information-step')['copy'] == true;

        if (!$isView) {
            $this->handleCreateContract();
        }
        else if ($copy){
            $this->handleCreateContract();
        }
        else {
            $this->handleEditContract();
        }

        return redirect('contracts');
    }

    public function stepInfo(): array
    {
        return [
            'label' => '選擇合約類型',
        ];
    }

    public function prev()
    {
        $this->previousStep();
    }

    public function render()
    {
        $contractTypeFromBasicInformation = 0;
        if (isset($this->state()->forStep('basic-information-step')['type']))
            $contractTypeFromBasicInformation = $this->state()->forStep('basic-information-step')['type'];

        $contractTypeFromChoose = 0;
        if (isset($this->state()->forStep('choose-contract-type-step')['type']))
            $contractTypeFromChoose = $this->state()->forStep('choose-contract-type-step')['type'];

        $contractType = $contractTypeFromBasicInformation;
        if ($contractTypeFromBasicInformation == 0) {
            $contractType = $contractTypeFromChoose;
        }
        $isView = $this->state()->forStep('basic-information-step')['view'] == true;

        if ($contractType == 1) {
            return view('livewire.steps.contract-type-1')->with('isView', $isView);
        }

        if ($contractType == 2) {
            return view('livewire.steps.contract-type-2')->with('isView', $isView);
        }

        if ($contractType == 3) {
            return view('livewire.steps.contract-type-3')->with('isView', $isView);
        }
    }

    public function handleCreateContract()
    {
        $basicInformation = $this->state()->forStep('basic-information-step')['data'];
        $basicInformationExtraData = $this->state()->forStep('basic-information-step')['extraData'];

        $contractTypeFromBasicInformation = 0;
        if (isset($this->state()->forStep('basic-information-step')['type']))
            $contractTypeFromBasicInformation = $this->state()->forStep('basic-information-step')['type'];

        $contractTypeFromChoose = 0;
        if (isset($this->state()->forStep('choose-contract-type-step')['type']))
            $contractTypeFromChoose = $this->state()->forStep('choose-contract-type-step')['type'];

        $contractType = $contractTypeFromBasicInformation;
        if ($contractTypeFromBasicInformation == 0) {
            $contractType = $contractTypeFromChoose;
        }
        $contractDetails = $this->data;

        // 建立合約本體
        $basicInformation['type'] = $contractType;
        $contract = Contract::Create($basicInformation);

        // 處理基本畫面中看起來像是詳細資訊的資料
        foreach ($basicInformationExtraData as $detailKey => $value) {
            ContractDetail::createContractDetailByKey($contract, $detailKey, $value);
        }

        // 處理之後畫面中的詳細資訊
        foreach ($contractDetails as $detailKey => $value) {
            ContractDetail::createContractDetailByKey($contract, $detailKey, $value);
        }
    }

    public function handleEditContract()
    {
        $basicInformation = $this->state()->forStep('basic-information-step')['data'];
        $basicInformationExtraData = $this->state()->forStep('basic-information-step')['extraData'];

        $contractTypeFromBasicInformation = 0;
        if (isset($this->state()->forStep('basic-information-step')['type']))
            $contractTypeFromBasicInformation = $this->state()->forStep('basic-information-step')['type'];

        $contractTypeFromChoose = 0;
        if (isset($this->state()->forStep('choose-contract-type-step')['type']))
            $contractTypeFromChoose = $this->state()->forStep('choose-contract-type-step')['type'];

        $contractType = $contractTypeFromBasicInformation;
        if ($contractTypeFromBasicInformation == 0) {
            $contractType = $contractTypeFromChoose;
        }
        $contractDetails = $this->data;

        // 建立合約本體
        $basicInformation['type'] = $contractType;
        $contract = Contract::where('id', '=',  $this->state()->forStep('basic-information-step')['contract_id']);
        array_splice($basicInformation, count($basicInformation)-2, 2);
        $contract->update($basicInformation);

        // 處理基本畫面中看起來像是詳細資訊的資料
        foreach ($basicInformationExtraData as $detailKey => $value) {
            ContractDetail::editContractDetailByKey($contract->first(), $detailKey, $value);
        }

        // 處理之後畫面中的詳細資訊
        foreach ($contractDetails as $detailKey => $value) {
            ContractDetail::editContractDetailByKey($contract->first(), $detailKey, $value);
        }
    }
}
