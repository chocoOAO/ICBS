<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            合約管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2 pb-5 border-gray-200 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">合約管理</h3>
                <div class="mt-3 sm:mt-0 sm:ml-4">
                    <label for="mobile-search-candidate" class="sr-only">Search</label>
                    <label for="desktop-search-candidate" class="sr-only">Search</label>
                    <div class="flex rounded-md shadow-sm">
                        <div class="relative flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/search -->
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <form action="#" method="GET">
                                <input type="text" name="search" id="desktop-search-candidate"
                                    class="hidden focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-md pl-10 sm:block sm:text-sm border-gray-300"
                                    placeholder="搜尋" value="{{ request()->get('search') }}">
                                <input type="submit" hidden />
                            </form>

                        </div>

                        <a href="{{ route('contract.create') }}" type="button"
                            class="inline-flex items-center ml-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            建立合約
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                合約名稱</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                合約類型
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                合約週期</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                最後修改日期</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span> <!-- class="sr-only"用於隱藏元素 -->
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contracts as $contract)
                            <tr>
                                <!-- 甲方固定式福壽實業股份有限公司 -->
                                <!-- 所以合約名稱改name_b-->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $contract->name_b }}的合約</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $contract->type_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $contract->begin_date }}～{{ $contract->end_date }}
                                    @php
                                        $remainingDays = \Carbon\Carbon::parse($contract->end_date)->diffInDays(\Carbon\Carbon::now());
                                    @endphp
                                    (<span class="{{ $remainingDays < 7 ? 'text-red-600' : '' }}">剩餘
                                        {{ $remainingDays }} 天 </span>)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"> {{ $contract->updated_at }}
                                </td>
                                <!-- 這裡不會到controller 直接到contractViewer-->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('contract.view', ['contract' => $contract, 'isEdit' => false]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">查看</a>
                                    <a href="{{ route('contract.edit', ['contract' => $contract, 'isEdit' => true]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">編輯</a>
                                    <a href="{{ route('contract.copy', ['contract' => $contract, 'isEdit' => true, 'isCopy' => true]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">複製</a>
                                    <a href="{{ route('contract.delete', ['contract' => $contract]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">刪除</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if (request()->has('search'))
                                        查無資料
                                    @else
                                        尚未建立任何合約資料
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                        @foreach ($expiredContracts as $contract)
                            <tr>
                                <!-- 甲方固定式福壽實業股份有限公司 -->
                                <!-- 所以合約名稱改name_b-->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $contract->name_b }}的合約</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $contract->type_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $contract->begin_date }}～{{ $contract->end_date }} (已過期)</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"> {{ $contract->creator }}
                                </td>
                                <!-- 這裡不會到controller 直接到contractViewer-->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('contract.view', ['contract' => $contract, 'isEdit' => false]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">查看</a>
                                    <a href="{{ route('contract.edit', ['contract' => $contract, 'isEdit' => true]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">編輯</a>
                                    <a href="{{ route('contract.copy', ['contract' => $contract, 'isEdit' => true, 'isCopy' => true]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">複製</a>
                                    <a href="{{ route('contract.delete', ['contract' => $contract]) }}"
                                        class="text-indigo-600 hover:text-indigo-900">刪除</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
