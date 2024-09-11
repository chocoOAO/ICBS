<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            檢視合約
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                    <div class="col-span-3 bg-white   sm:rounded-lg p-12">
                        <livewire:contract-viewer :contract="$contract" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
