<?php

namespace App\Support;

use Spatie\LivewireWizard\Support\State;

class ContractWizardState extends State
{
    public function deliveryAddress(): array
    {
        $deliveryAddressStepState = $this->forStep('delivery-address');

        return [
            'name' => $deliveryAddressStepState['name'],
            'street' => $deliveryAddressStepState['street'],
            'zip' => $deliveryAddressStepState['zip'],
            'city' => $deliveryAddressStepState['city'],
        ];
    }

    public function amount(): int
    {
        return $this->forStep('cart')['amount'];
    }

    public function type(): int
    {
        return $this->forStep('basic-information-step')['type'];
    }
}