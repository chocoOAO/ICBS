<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            生長預估
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <livewire:chart :contract="$contract" />
            </div>
        </div>
    </div>
</x-app-layout>
