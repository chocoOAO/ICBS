<form action="#" wire:submit.prevent="submit">

    <style>

        table td,
        table th {
            border: 1px solid #ccc;
            padding: .4rem
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

        .hoverable-breeding-rate {
            position: relative;
            /* 使元素相对定位 */
        }

        .hoverable-breeding-rate:hover::before {
            content: "剩存羽數 / 入雛總羽數 x 100 %";
            display: block;
            position: absolute;
            top: -20px;
            /* 将文本向上偏移 20px */
            background-color: #fff;
            /* 背景颜色，可选 */
            color: red;
            /* 文本颜色，可选 */
        }

        .hoverable-feeding-perf {
            position: relative;
            /* 使元素相对定位 */
        }

        .hoverable-feeding-perf:hover::before {
            content: "飼料總重 / 當下剩存羽數 / 均重";
            display: block;
            position: absolute;
            top: -20px;
            /* 将文本向上偏移 20px */
            background-color: #fff;
            /* 背景颜色，可选 */
            color: red;
            /* 文本颜色，可选 */
        }

        .hoverable-production-index {
            position: relative;
            /* 使元素相对定位 */
        }

        .hoverable-production-index:hover::before {
            content: "育成率＊均重（KG） / 飼效 / 日齡＊100％";
            display: block;
            position: absolute;
            top: -20px;
            /* 将文本向上偏移 20px */
            background-color: #fff;
            /* 背景颜色，可选 */
            color: red;
            /* 文本颜色，可选 */
        }

        .hoverable-weight-effect {
            position: relative;
            /* 使元素相对定位 */
        }

        .hoverable-weight-effect:hover::before {
            content: "（均重-飼效）*1000";
            display: block;
            position: absolute;
            top: -20px;
            /* 将文本向上偏移 20px */
            background-color: #fff;
            /* 背景颜色，可选 */
            color: red;
            /* 文本颜色，可选 */
        }
    </style>
    
    {{-- 如果無法抓到批號(importNum)，代表或許沒有資料，跳出警告視窗，並傳回空白表單。 --}}
    @if ($errors->has('No_ImportNum'))
    <script>
        alert("{{ $errors->first('No_ImportNum') }}"); // $errors是在component的$this->addError裡填加
    </script>
    @endif

    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
    <button type="button" class="btn btn-primary" style="margin-left: 10px;" wire:click="exportPDF">列印</button>

    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center" style="font-weight: bold; font-size:20px">產銷履歷</h2>
    </div>

    @if ($importNum  != -1)
    <table class="max-w-full table-fixed mx-auto"> <!-- 最大寬度為 100%。既保留了表格的固定佈局，又確保表格在其父容器內水平居中。 -->
    <!-- 以10為總方框大小進行劃分 -->
        <tbody>
            <tr>
                <td colspan="1"> 
                    客戶
                </td>
                <td colspan="3">
                    <div class="relative flex items-center">       
                        {{ $m_NAME }} <!-- 客戶主檔名稱 -->
                    </div>
                </td>
                <td colspan="1">
                    入雛日期
                </td>
                <td colspan="1">
                    <div class="relative flex items-center">
                        {{ $importDate }}
                    </div>
                </td>
                <td colspan="1">
                    入雛數量
                </td>
                <td colspan="3">
                    <div class="relative flex items-center">
                        {{ $importQuantity }}
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
                        {{ $chicken_origin }}
                    </div>
                </td>
                <td colspan="1">
                    批號
                </td>
                
                <td colspan="3">
                    <div class="relative flex items-center">
                        <table>
                            <!-- 批號 -->
                            <tr>                            
                                <td style="border: none;"> <!-- style="border: none;" 讓邊線隱藏 -->
                                    <div class="relative flex items-center custom-width100">
                                        <div class="text-sm" style="display: flex;">
                                            <input class="form-control" type="text" wire:model.lazy="importNum"
                                                wire:click="showOptions('importNum',1)" readonly> 
                                            <!-- wire:click="showOptions('importNum',1)"是當輸入框被點擊時觸發Livewire組件的showOptions方法。；readonly屬性使輸入框為只讀，用戶不能直接編輯。 -->
                                        </div>
                                    </div>
                                    <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                                        @if ($showOptions['importNum']) style="display: block;" @else style="display: none;" @endif>
                                        <ul>
                                            @foreach ($importNumOptions as $key => $import_number)
                                                <li wire:click="selectOption('{{ $import_number['chicken_import_id'] }}', '{{ $key }}', 'importNum')"
                                                    class="px-3 py-1 hover:bg-gray-200">
                                                    {{ $import_number['chicken_import_id'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                
                                <div style="margin-left: 2px"></div>
                            
                                <td style="border: none;"> <!-- style="border: none;" 讓邊線隱藏 -->
                                    <!-- 棟舍  -->
                                    <div class="relative flex items-center custom-width100">
                                        <div class="text-sm" style="display: flex;">
                                            <input class="form-control" type="text" wire:model.lazy="building_number"
                                                wire:click="showOptions('building_number',1)" readonly>
                                        </div>
                                    </div>
                                    <div class="absolute z-10 bg-white border border-gray-300 rounded-md" {{-- @dd($showOptions) --}}
                                        @if ($showOptions['building_number']) style="display: block;" @else style="display: none;" @endif>
                                        <ul>
                                            @foreach ($buildingNumOptions as $key => $building_number)
                                                <li wire:click="selectOption('{{ $building_number }}', '{{ $key }}', 'building_number')"
                                                    class="px-3 py-1 hover:bg-gray-200">
                                                    {{ $building_number }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
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
                                <!-- <td style="width: 0%">下午均重(g)</td> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inputBreedingLog as $key => $input)
                                <tr>
                                    <!-- 日期 -->
                                    <td>
                                        @php
                                            if (!isset($inputBreedingLog[$key]['date'])){
                                                $inputBreedingLog[$key]['date'] = "";
                                            }
                                        @endphp
                                        <div class="flex items-center h-5 align-middle">
                                            {{ $inputBreedingLog[$key]['date'] }}
                                        </div>
                                    </td>
                                    <!-- 日齡 -->
                                    <td>
                                        @php
                                            if (!isset($inputBreedingLog[$key]['age'])){
                                                $inputBreedingLog[$key]['age'] = "";
                                            }
                                        @endphp
                                        <div class="flex items-center h-5 align-middle">
                                            {{ $inputBreedingLog[$key]['age'] }}
                                        </div>
                                    </td>
                                    <!-- 淘汰數 -->
                                    <td>
                                        @php
                                            if (!isset($inputBreedingLog[$key]['disuse'])){
                                                $inputBreedingLog[$key]['disuse'] = "";
                                            }
                                        @endphp
                                        <div class="flex items-center h-5 align-middle">
                                            {{ $inputBreedingLog[$key]['disuse'] }}
                                        </div>
                                    </td>                                    

                                    <!-- 下午均重(g) -->
                                    @php
                                        if (!isset($inputBreedingLog[$key]['pm_avg_weight'])){
                                            $inputBreedingLog[$key]['pm_avg_weight'] = 0;
                                        }
                                    @endphp
                                     <!-- 產銷履曆 不要均重 -->
                                    <!-- <td>
                                        <div>
                                            {{ number_format($inputBreedingLog[$key]['pm_avg_weight'], 2, '.', ',') }}
                                        </div>
                                    </td> -->

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>

            <!--飼料 -->
            <tr>
                <td colspan="10">
                    <table class="table-fixed">
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
                                    <!-- 日期 -->
                                    <td>
                                        <div class="flex items-center h-5 align-middle">
                                            {{ $inputFeeding[$keyFeeds]['date'] }}
                                        </div>
                                    </td>
                                    
                                    <!-- 飼養行為 -->
                                    <td>
                                        {{ $typeOptions[$inputFeeding[$keyFeeds]['feed_type']] }}
                                    </td>
                                    
                                    <!-- 投料名稱 -->
                                    <td>
                                        {{ $inputFeeding[$keyFeeds]['feed_item'] }}
                                    </td>

                                    <!-- 飼料量(kg) -->
                                    <td>
                                        {{ $inputFeeding[$keyFeeds]['feed_quantity'] }}
                                    </td>

                                    <!-- 使用抗生素 -->
                                    <td>
                                    @php
                                        $addAntibiotics = $inputFeeding[$keyFeeds]['add_antibiotics'] == 1 ? "YES" : "NO";
                                    @endphp
                                    {{ $addAntibiotics }}
                                    </td>
                                    
                                    <!-- 累計量(kg) -->
                                    @php
                                        if (isset($inputFeeding[$keyFeeds]['feed_quantity'])) {
                                            if ($accumulatedWeight_len == 0) {
                                                $accumulatedWeight[$accumulatedWeight_len] = $inputFeeding[$keyFeeds]['feed_quantity'];
                                            } else {
                                                $accumulatedWeight[$accumulatedWeight_len] = $accumulatedWeight[$accumulatedWeight_len - 1] + $inputFeeding[$keyFeeds]['feed_quantity'];
                                            }
                                        } else {
                                            if ($accumulatedWeight_len == 0) {
                                                $accumulatedWeight[$accumulatedWeight_len] = 0;
                                            } else {
                                                $accumulatedWeight[$accumulatedWeight_len] = $accumulatedWeight[$accumulatedWeight_len - 1];
                                            }
                                        }
                                    @endphp
                                    <!-- <td>
                                        {{ $accumulatedWeight[$accumulatedWeight_len] }}
                                    </td> -->
                                    @php
                                        $accumulatedWeight_len++;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>

            <!-- The Last Row -->
            <tr>
                <td colspan="1" class="hoverable-breeding-rate">
                    育成率(%)
                </td>
                <td colspan="2">
                    <!-- 直接抓 inputBreedingLog 中最後一筆的 breeding_rate-->
                    @php
                        $show_breeding_rate = number_format($breeding_rate * 100, 2, '.', '');
                    @endphp
                    <div class="flex items-center h-5 align-middle">
                        {{ $show_breeding_rate }}%
                    </div>
                </td>
                
                <!-- 飼效 = 飼料總重 / 剩存羽數 / (下午)均重 -->
                <td colspan="1" class="hoverable-feeding-perf">
                    飼效
                </td>
                <!-- 检查 feed_type 是否是否等于 'A' -->
                <td colspan="1">
                    @php
                        $show_feeding_efficiency = number_format($feeding_efficiency, 2, '.', '')
                    @endphp
                    <div class="relative flex items-center">
                        {{ $show_feeding_efficiency }}
                    </div>
                </td>

                <!-- 生產指數：育成率 * 均重kg / 飼效 / 日齡 ＊ 100％ -->
                <td colspan="1" class="hoverable-production-index">
                    生產指數(%)
                </td>
                <td colspan="2">
                    @php
                        if (isset($age, $last_avg_weight) && ($show_feeding_efficiency * $age) != 0) {
                            $production_index = round( ($breeding_rate*100) * ($last_avg_weight/1000) / $show_feeding_efficiency / $age * 100); // (提醒)需要將均重換算成公斤KG；並且四捨五入、不用小數位。
                        } else {
                            $production_index = 0;
                        }
                        $production_index = number_format($production_index, 0, '.', '');
                    @endphp
                    <div class="relative flex items-center">
                        {{ $production_index }}%
                    </div>
                </td>
                
                <!--  重效差：（均重kg －　飼效）*1000‰  -->
                <td colspan="1" class="hoverable-weight-effect">
                    重效差
                </td>
                <td colspan="1">
                    @php
                    $weight_effect = 0;
                    if (isset($last_avg_weight, $show_feeding_efficiency)){
                        $weight_effect = round((($last_avg_weight/1000) - $show_feeding_efficiency) * 1000); // (提醒)需要將均重換算成公斤KG。
                    }
                    $weight_effect = number_format($weight_effect, 0, '.', '');
                    @endphp
                    <div class="relative flex items-center">
                        {{ $weight_effect }}
                    </div>
                </td>
            </tr>
            @if (empty($last_avg_weight))
                <tr>
                    <td colspan="10" style="border: none">
                        <div style="margin-top: 10px; color: red">
                            {{ sprintf('※ 缺少雞齡 %d 日的均重資料，故生產指數顯示為 %d%%。', $age, $production_index) }}
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    @endif
</form>
