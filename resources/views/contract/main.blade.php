<form action="#" wire:submit.prevent="submit">
    <!-- <button class="btn btn-primary" type="button" wire:click="fake()">產生假資料</button> -->
    @include('livewire.steps.basic-information')

    @if ($contractType == 1)
        @include('livewire.steps.contract-type-1')
    @endif

    @if ($contractType == 2)
        @include('livewire.steps.contract-type-2')
    @endif

    @if ($contractType == 3)
        @include('livewire.steps.contract-type-3')
    @endif

</form>
