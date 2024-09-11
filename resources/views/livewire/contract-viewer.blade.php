<form action="#" wire:submit.prevent="submit">
    <button class="btn btn-primary" type="button" wire:click="exportPDF()">列印</button>
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

@if (!$isEdit)
<style>
    .form-control {
        pointer-events: none;  /* 禁用元素的鼠标事件，使其不可交互; 用户无法与这些元素交互，比如点击或输入。 */
        color: #000;  /* 将文字颜色设置为黑色 */
    }
</style>
@endif

