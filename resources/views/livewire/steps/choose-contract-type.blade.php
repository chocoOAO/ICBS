<form action="#">

    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center">選擇合約類型</h2>
    </div>

    <div class="h-56 grid grid-cols-3 gap-4 content-around">
        <button wire:click="chooseType(1)" type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">保價計價(停用)</button>
        <button wire:click="chooseType(2)" type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">代養計價</button>
        <button wire:click="chooseType(3)" type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">其他事項(契養)</button>
    </div>
</form>
