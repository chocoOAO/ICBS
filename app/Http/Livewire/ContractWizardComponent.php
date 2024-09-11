<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Support\ContractWizardState;
use Spatie\LivewireWizard\Components\WizardComponent;
use App\Http\Livewire\Steps\BasicInformationStepComponent;
use App\Http\Livewire\Steps\ChooseContractTypeStepComponent;
use App\Http\Livewire\Steps\ShowSelectedContractTypeStepComponent;
use App\Models\ContractDetail;

class ContractWizardComponent extends WizardComponent
{
    public $contract = null;
    public $copy = false;
    public $contract_details = null;
    public $isEdit = 0;

    public function mount($contract = null, $copy = false)
    {
        if (isset($contract) && $contract != null) {
            $this->contract = $contract;
            $this->copy = $copy;
            // 重新組合細節資料
            $contractDetails = ContractDetail::with('detailType')->where('contract_id', $contract->id)->get();
            $this->contract_details = $contractDetails->mapWithKeys(function ($item) {
                return [$item->detailType->name => $item->value];
            });
        }
    }

    public function initialState(): array
    {
        if (isset($this->contract) && $this->contract != null) {
            return [
                'basic-information-step' => [
                    'type' => $this->contract->type,
                    'data' => $this->contract->toArray(),
                    'extraData' => $this->contract_details->toArray(),
                    'view' => true,
                    'contract_id' => $this->contract->id,
                    'copy' => $this->copy,
                ],
                'show-selected-contract-type-step' => [
                    'data' => $this->contract_details->toArray(),
                ],
            ];
        }
        return [];
    }

    public function steps(): array
    {
        return [
            ChooseContractTypeStepComponent::class,
            BasicInformationStepComponent::class,
        ];
    }

    public function stateClass(): string
    {
        return ContractWizardState::class;
    }
}
