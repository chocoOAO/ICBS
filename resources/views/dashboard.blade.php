<x-app-layout>

    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('歡迎光臨') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                {{-- <x-jet-welcome /> --}}

                <!-- ToDo：客戶編號 -->
                <div class="pt-4 bg-gray-100">
                    @php

                        $user = Auth::user();
                        $user_name = $user->name;

                        $auth_type = $user->getAuth_type();
                        $m_Name = $user->getMName();

                        /*
                        1.列出該使用者底下的所有合約
                        2.列出最近的合約截止日
                        3.列出該使用者底下的所有合約的所有入雛表
                        4.列出最近的入雛表日期
                        5.比對2.4.的合約截止日與入雛表的日期是否小於50天
                        4.小於則彈出警告
                        5.大於則不彈出警告
                        */

                        $expired_array = []; // 创建一个空数组，用于存储过期的合同
                        $contracts = $user->getContract();
                        $chicken_imports = $user->getChickenImport();
                        $Warning = '';
                        foreach ($contracts as $contract) {
                            foreach ($chicken_imports as $chicken_import) {
                                $date_diff = intval((strtotime($contract->end_date) - strtotime($chicken_import->date)) / 86400);

                                if ($date_diff < 50) {
                                    // 检查是否已经存在相同的 $chicken_import
                                    if (!in_array($chicken_import, $expired_array)) {
                                        $expired_array[] = $chicken_import;
                                    }
                                }
                            }
                        }

                        foreach ($expired_array as $key => $value) {
                            $Warning .= $value->m_KUNAG . '-' . $value->id . ' 入雛日期' . $value->date . ' ' . '合約截止日' . $contract->end_date . "\\n";
                        }
                        if ($auth_type == 'admin' || $auth_type == 'super_admin') {
                            echo '<script>
                                var warning = "'. $Warning .'"; // 將 PHP 變數轉換為 JavaScript 變數
                                alert("提示：\\n" + warning);
                            </script>';
                        }

                    @endphp



                    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                        <h1>{{ $user_name }}您好！您的客戶編號
                            @if ($user->m_KUNAG == null)
                                <span>目前尚未指定，請聯絡貴單位的場管理員協助設定，謝謝！</span>
                            @else
                                <span>是{{ $user->m_KUNAG }}、場域名稱是</span>
                                {{ $m_Name }}，歡迎使用！</span>
                            @endif

                            @if ($auth_type == 'worker')
                                <h1>目前您身份尚未有任何農戶飼養紀錄表</h1>
                            @else
                                <h1>請點選其他頁面</h1>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
