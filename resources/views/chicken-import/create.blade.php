<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            建立飼養入雛表
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                <livewire:chicken-import :contract="$contract" />
                {{-- <hr class="my-5"> --}}


                <!-- 20230818實體會議說明移除驗收單 -->
                {{-- <hr noshade="noshade" style="border:2px #cccccc dotted;margin-top:5%;margin-bottom:5%" /> --}}
                {{-- <livewire:chicken-verify :contract="$contract" /> --}}
            </div>
        </div>
    </div>
</x-app-layout>
