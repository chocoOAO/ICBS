<!DOCTYPE html>
<style>
    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght";
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border-collapse: collapse;
        padding: 8px;
    }
    .table-fixed {
        width: 100%;
    }
    .max-w-full {
        width: 100%;
    }

    .min-width-100px {
        min-width: 100px;
    }
    
</style>
<html lang="zh-Hant"> <!-- 設置語言屬性 lang 為繁體中文（台灣）。-->

@php
    use App\Models\ChickenOut;
    $data['inputs'] = ChickenOut::where('contract_id', $data['contract_id'])->where('chicken_import_id', $data['import'])->orderBy('date')->orderBy('building_number')->orderBy('quantity', 'desc')->get(); // 06/25開會討論，要求列印批號底下的所有棟舍資料。
    $BuildingNumbers = $data['inputs']->pluck('building_number')->unique();
@endphp

<body class="font-zh"> 

    <div class="my-2 py-5 border-gray-200">
        <h1 class="text-xl text-gray-800 leading-tight text-center font-bold" style="text-align: center;">抓雞派車單</h1>
    </div>
    
    <div class="table-wrapper"> <!-- 包裹表格 並 且結構化，幫助更好地結構化 HTML 文件，讓代碼更加清晰易讀。 -->
        <table class="max-w-full" style="width: 60%; font-size: 18px;">
            <thead>
                <tr>
                    <!-- 批號 -->
                    <td style="width: 5%;">批號：</td>
                    <td style="width: 15%;">
                        <div class="relative flex items-center custom-width100">
                            <div class="text" style="display: flex; justify-content: flex-start;">
                                {{ $data['import'] }} 
                            </div>
                        </div>
                    </td>
                    <!-- 棟舍 -->
                    <td style="width: 5%;">棟舍：</td>
                    <td style="width: 35%;">
                        <div class="relative flex items-center custom-width100">
                            <div class="text" style="display: flex; justify-content: flex-start;">
                                {{ $BuildingNumbers->isNotEmpty() ? $BuildingNumbers->implode(' & ') : '無' }}
                            </div>
                        </div>
                    </td>
                    <!-- 客戶主檔 -->
                    <td style="width: 5%;">客戶主檔：</td>
                    <td style="width: 35%;">
                        <div class="relative flex items-center custom-width100">
                            <div class="text" style="display: flex; justify-content: flex-start;">
                                {{ $data['m_NAME'] }} 
                            </div>
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
    
    <hr class="my-5">
    
    <div class="table-wrapper"> <!-- 包裹表格 並 且結構化，幫助更好地結構化 HTML 文件，讓代碼更加清晰易讀。 -->
        <table class="max-w-full mx-auto table-fixed">                 
            <thead>          
                <tr>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">日期</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">雞主</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">棟舍</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">隻數（羽）</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">抓雞時間</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">雞主電話</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">地點</th>
                    <th style="width: 12.5%; border: 1px solid #e0e0e0;">預估重量</th>
                </tr>
            </thead> 
            <tbody>
                @forelse ($data['inputs'] as $key => $input)
                    <tr>
                        <!-- 日期 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['date'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 雞主 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['owner'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 棟舍 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['building_number'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 隻數（羽） -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['quantity'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 抓雞時間 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['time'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 雞主電話 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ !empty($data['inputs'][$key]['phone_number']) ? $data['inputs'][$key]['phone_number'] : '沒有資料' }}
                                </div>
                            </div>
                        </td>
                        <!-- 地點 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ $data['inputs'][$key]['origin'] }}
                                </div>
                            </div>
                        </td>
                        <!-- 預估重量 -->
                        <td style="text-align: center; border: 1px solid #e0e0e0;">
                            <div class="relative flex items-center custom-width100">
                                <div class="text" style="display: flex;">
                                    {{ !empty($data['inputs'][$key]['weight']) ? $data['inputs'][$key]['weight'] : '沒有資料' }}
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div style="margin-top: 10px; color: red">
                                ※ 請先至少儲存一筆抓雞派車單資料，之後才可進行列印。
                            </div>
                        </td>
                    </tr>
                @endforelse

                @php
                    // 使用 diff 方法取差集，得到在 ChickenImport 中有、而在 ChickenOut 中沒有出現的 building_number
                    use App\Models\ChickenImport;
                    $chickenimport_BuildingNumbers = ChickenImport::where('contract_id', $data['contract_id'])->where('id', $data['import'])->pluck('building_number');
                    $Lack_of_ChickenOutData = $chickenimport_BuildingNumbers->diff($BuildingNumbers);
                @endphp
                @if ($Lack_of_ChickenOutData->isNotEmpty())
                    <tr>
                        <td colspan="7">
                            <div style="margin-top: 10px; color: red">
                                ※ 下列棟舍尚缺抓雞資料：{{ $Lack_of_ChickenOutData->implode(' & ') }}。
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>