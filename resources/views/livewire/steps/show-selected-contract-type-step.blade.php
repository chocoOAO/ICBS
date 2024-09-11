<form action="#">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">

            <div class="my-2 py-5 border-gray-200">
                <h2 class="text-xl text-gray-800 leading-tight text-center">選擇合約類型</h2>
            </div>

            <div>
                <button wire:click="chooseType(1)" type="button">保價計價</button>
                <button wire:click="chooseType(2)" type="button">代養計價</button>
                <button wire:click="chooseType(3)" type="button">其他事項</button>
            </div>
        </div>
    </div>
</form>
