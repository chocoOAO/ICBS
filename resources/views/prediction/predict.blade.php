<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            XXX 場 XXX 重量預測
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                {{-- <livewire:chicken-verify :contract="$contract" /> --}}
                <form action="{{ route('predict') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="excel_file">
                    @php
                        index();
                    @endphp


                    {{-- <button type="submit">預測</button> --}}
            </div>
        </div>
    </div>
</x-app-layout>
