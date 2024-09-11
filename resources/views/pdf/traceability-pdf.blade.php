<style>
    table {
        width: 100%; /* 設定表格的寬度為容器的 100%。也就是說，表格會自動調整寬度以填滿其父容器的寬度。 */
        border-collapse: collapse; /* 設定表格的邊框會合併。這意味著相鄰單元格的邊框會合併成一個單一的邊框，而不是分開顯示。這樣的設定通常可以使表格顯得更加整齊、美觀。 */
    }
    table td, table th {
        border: 1px solid #ccc;
        padding: .4rem;
        font-family: "NotoSansTC-VariableFont_wght";
    }
    .table-container {
        page-break-inside: avoid; /* Prevents the whole table from breaking across pages */
    }

    .min-width-100px {
            min-width: 100px;
        }

    .max-w-full {
            width: 100%;
        }

    .table-fixed {
        width: 100%;
    }

    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght"
    }
</style>

@php
    use App\Models\BreedingLog;
    use App\Models\FeedingLog;

    $data['inputBreedingLog'] = BreedingLog::where('chicken_import_id', $data['importNum'])->where('building_number', $data['building_number'])->orderBy('date', 'asc') ->get();  // 根據 date 欄位進行升冪排序
    $data['inputFeeding'] = FeedingLog::where('chicken_import_id', $data['importNum'])->where('building_number', $data['building_number'])->orderBy('date', 'asc')->get(); // 按照 date 欄位進行升冪排序
@endphp

@php
    $inputBreedingLog = $data['inputBreedingLog']
@endphp

@php
    $inputFeeding = $data['inputFeeding']
@endphp

@php
    $typeOptions = $data['typeOptions']
    # <!-- $typeOptions = ['A' => 'A-飼料', 'B' => 'B-疫苗', 'C' => 'C-藥品', 'D' => 'D-消毒', 'E' => 'E-清理雞舍', 'F' => 'F-清理雞糞']; -->
@endphp

<div class="table-container"> <!-- 用 .table-container 包住了整個表格並應用了 page-break-inside: avoid;，這通常應該足以防止整個表格在頁面之間被拆分。 -->

<div class="my-2 py-5 border-gray-200">
    <h1 class="text-xl text-gray-800 leading-tight text-center" style="font-weight: bold; font-size:20px; text-align: center; font-family: NotoSansTC-VariableFont_wght;">產銷履歷</h1>
</div>

<table class="max-w-full table-fixed mx-auto">
    <tbody>
        <tr>
            <td colspan="1">
                客戶
            </td>
            <td colspan="3">
                <div class="relative flex items-center">
                    {{ $data['m_NAME'] }} <!-- 客戶主檔名稱 -->
                </div>
            </td>
            <td colspan="1">
                入雛日期
            </td>
            <td colspan="1">
                <div class="relative flex items-center">
                    {{ $data['importDate'] }}
                </div>
            </td>
            <td colspan="1">
                入雛數量
            </td>
            <td colspan="3">
                <div class="relative flex items-center">
                    {{ $data['importQuantity'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                雞種
            </td>
            <td colspan="3">
                <div class="relative flex items-center">
                    白肉雞
                </div>
            </td>
            <td colspan="1">
                雛雞來源
            </td>
            <td colspan="1">
                <div class="relative flex items-center">
                {{ $data['chicken_origin'] }}
                </div>
            </td>
            <td colspan="1">
                <div class="relative flex items-center custom-width100 text-sm" style="display: flex; flex-direction: column;">
                    <p>批號</p> <!-- 批號 -->
                </div>
                <div>
                    <p>棟舍</p> <!-- 批號 -->
                </div>                
            </td>
            <td colspan="3">
                <div class="relative flex items-center custom-width100 text-sm" style="display: flex; flex-direction: column;">
                    <h3>{{ $data['importNum'] }}</h3> <!-- 批號 -->
                </div>
                <div>
                    <h3>{{ $data['building_number'] }}</h3> <!-- 棟舍 -->
                </div>
            </td>
        </tr>

        <!--雞 -->
        <tr>
            <td colspan="10">
                <table class="max-w-full table-fixed mx-auto">
                    <thead>
                        <tr>
                            <th style="width: 33%">日期</th>
                            <th style="width: 33%">日齡</th>
                            <th style="width: 33%">淘汰數</th>
                            <!-- <th style="width: 0%">下午均重(g)</th> --> <!-- 產銷履曆 列印的那個部分 不要均重 -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputBreedingLog as $key => $input)
                            <tr>
                                <td>
                                    <div class="flex items-center h-5 align-middle">
                                        {{ $input['date'] }} <!-- 日期 -->
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center h-5 align-middle">
                                        {{ $input['age'] }} <!-- 日齡 -->
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center h-5 align-middle">
                                        {{ $input['disuse'] }} <!-- 淘汰數 -->
                                    </div>
                                </td>
                                <!--  <td>
                                    <div class="flex items-center h-5 align-middle">
                                        {{ number_format($input['pm_avg_weight'], 2, '.', ',') }} 下午均重(g) 
                                    </div>
                                </td> --> <!-- 產銷履曆 列印的那個部分 不要均重 -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>

        <!--飼料 -->
        <tr>
            <td colspan="10">
                <table class="max-w-full table-fixed mx-auto">
                    <thead>
                        <tr>
                            <td style="width: 20%">日期</td>
                            <td style="width: 20%">飼養行為</td>
                            <td style="width: 20%">投料名稱</td>
                            <td style="width: 20%">飼料量(kg)</td>
                            <td style="width: 20%">使用抗生素</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputFeeding as $keyFeeds => $inputFeed)
                            <tr>
                                <td>
                                    <div class="flex items-center h-5 align-middle">
                                        {{ $inputFeed['date'] }} <!-- 日期 -->
                                    </div>
                                </td>
                                <td>
                                    {{ $typeOptions[$inputFeed['feed_type']] }} <!-- 飼養行為 -->
                                </td>
                                <td>
                                    {{ $inputFeed['feed_item'] }} <!-- 投料名稱 -->
                                </td>
                                <td>
                                    {{ $inputFeed['feed_quantity'] }} <!-- 飼料量(kg) -->
                                </td>
                                    @php
                                        $addAntibiotics = $inputFeed['add_antibiotics'] == 1 ? "YES" : "NO";
                                    @endphp
                                <td>
                                    {{ $addAntibiotics }} <!-- 使用抗生素 -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                育成率(%)
            </td>
            <td colspan="2">
                @php
                    $show_breeding_rate = number_format($data['breeding_rate'] * 100, 2, '.', '');
                @endphp
                <div class="flex items-center h-5 align-middle">
                    {{ $show_breeding_rate }}%
                </div>
            </td>
            <td colspan="1">
                飼效
            </td>
            <td colspan="1">
                @php
                    $show_feeding_efficiency = number_format($data['feeding_efficiency'], 2, '.', '')
                @endphp
                <div  class="relative flex items-center">
                    {{ $show_feeding_efficiency }} <!-- 飼效 = 飼料總重 / 剩存羽數 / (下午)均重 -->
                </div>
            </td>
            <td colspan="1">
                生產指數(%)
            </td>
            <td colspan="2">
                @php
                    if (isset($data['age'], $data['last_avg_weight']) && ($show_feeding_efficiency * $data['age']) != 0) {
                        $production_index = round( ($data['breeding_rate']*100) * ($data['last_avg_weight']/1000) / $show_feeding_efficiency / $data['age'] * 100); // (提醒)需要將均重換算成公斤KG；並且四捨五入、不用小數位。
                    } else {
                        $production_index = 0;
                    }
                    $production_index = number_format($production_index, 0, '.', '');
                @endphp
                <div class="relative flex items-center">
                    {{ $production_index }}%  <!-- 生產指數：（育成率 * 均重kg） / （飼效 ＊日齡）＊100％ -->
                </div>
            </td>
            <td colspan="1">
                重效差
            </td>
            <td colspan="1">
                @php
                $weight_effect = 0;
                if (isset($data['last_avg_weight'], $show_feeding_efficiency)){ 
                    $weight_effect = round((($data['last_avg_weight']/1000) - $show_feeding_efficiency) * 1000); // (提醒)需要將均重換算成公斤KG。
                }  
                $weight_effect = number_format($weight_effect, 0, '.', '');
                @endphp
                <div class="relative flex items-center">
                    {{ $weight_effect }} <!-- 重效差：（均重 －　飼效）*100 ‰ -->
                </div>
            </td>
        </tr>
        @if (empty($data['last_avg_weight']))
            <tr>
                <td colspan="10" style="border: none">
                    <div style="margin-top: 10px; color: red">
                        {{ sprintf('※ 缺少雞齡 %d 日的均重資料，故生產指數顯示為 %d%%。', $data['age'], $production_index) }}
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

</div>