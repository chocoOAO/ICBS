<form action="#" wire:submit.prevent="submit">
    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center">農戶飼養紀錄表</h2>
    </div>
    @php
        $index = 0;
    @endphp
    <table class="max-w-full table-fixed @if (Auth::user()->permissions[2] < 3) cant_edit @endif">
        <tbody>
            <tr>
                <!--批號-->
                <td style="width: 8%;">
                    批號：
                </td>
                <td colspan="3">
                    <div class="relative flex items-center custom-width100">
                        <div class="text-sm" style="display: flex;">
                            <input class="form-control" type="text" wire:model.lazy="importNum"
                                wire:click="showOptions('importNum',1)" readonly>
                        </div>
                    </div>
                    <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                        @if ($showOptions['importNum']) style="display: block;" @else style="display: none;" @endif>
                        <ul>
                            @foreach ($importNumOptions as $key => $import_number)
                                <li wire:click="selectOption('{{ $import_number['id'] }}', '{{ $key }}', 'importNum')"
                                    class="px-3 py-1 hover:bg-gray-200">
                                    {{ $import_number['id'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </td>

                <td style="width: 8%;">
                    入雛日期：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" style="cursor: not-allowed;" type="text"
                                    wire:model.lazy="importDate" readonly="true">
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 8%;">
                    雞種：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" style="cursor: not-allowed;" type="text"
                                    wire:model.lazy="species" readonly="true">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <!--棟別-->
                <td style="width: 8%;">
                    棟別：
                </td>
                <td colspan="3">
                    <div class="relative flex items-center custom-width100">
                        <div class="text-sm" style="display: flex;">
                            <input class="form-control" type="text" wire:model.lazy="buildingNum"
                                wire:click="showOptions('buildingNum',1)" readonly>
                        </div>
                    </div>
                    <div class="absolute z-10 bg-white border border-gray-300 rounded-md" {{-- @dd($showOptions) --}}
                        @if ($showOptions['buildingNum']) style="display: block;" @else style="display: none;" @endif>
                        <ul>
                            @foreach ($buildingNumOptions as $key => $building_number)
                                <li wire:click="selectOption('{{ $building_number }}', '{{ $key }}', 'buildingNum')"
                                    class="px-3 py-1 hover:bg-gray-200">
                                    {{ $building_number }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                @php
                    $total_Disuse = 0;
                    foreach ($inputBreedingLogArray as $key => $input) {
                        if (isset($input['disuse'])) {
                            $total_Disuse = $total_Disuse + $input['disuse'];
                        }
                    }
                @endphp
                <td style="width: 8%;">
                    總淘汰數：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" style="cursor: not-allowed;" type="text"
                                    value="{{ $total_Disuse }}" readonly="true">
                            </div>
                        </div>
                    </div>
                </td>
                @php
                    $total_survivors = $survivors - $total_Disuse;
                @endphp
                <td style="width: 8%;">
                    剩存羽數：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" style="cursor: not-allowed;" type="text"
                                    value="{{ $total_survivors }}" readonly="true">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 8%;">
                    關鍵字：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" type="text" wire:model.lazy="keyword">
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 8%;">
                    起始日期：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">

                            <div class="text-sm">
                                <input class="form-control" type="date" wire:model.lazy="select_start_date"
                                    id="vendorName">
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 8%;">
                    結束日期：
                </td>
                <td colspan="3">
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <input class="form-control" type="date" wire:model.lazy="select_end_date"
                                    id="vendorName">
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="relative flex items-center">
                        <div class="text-sm">
                            <button type="button" class="btn btn-primary" wire:click="search()">查詢</button>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- 篩選列 --}}
            <tr>
                <td colspan="10">
                    <table>
                        <tr>
                            @foreach ($checkbox_value as $key => $value)
                                <td style="width:11.6%">
                                    <input type="checkbox" wire:model.lazy="checkbox_value.{{ $key }}">
                                    <label for="vehicle1"> {{ $checkbox_name[$key] }}</label><br>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- 雞 --}}
            <tr>
                <td colspan="11">
                    <hr class="my-5">
                    <table class="table-fixed">
                        <thead>
                            <tr>
                                <td style="width:9%">生長日期</td>
                                <td style="width:9%">日齡</td>
                                <td style="width:9%">淘汰數</td>
                                <td style="width:9%">總淘汰數</td>
                                <td style="width:9%">剩存羽數</td>
                                <td class="hoverable-breeding-rate" style="width:9%">育成率(%)</td>
                                <td style="width:9%">上午均重(g)</td>
                                <td style="width:9%">下午均重(g)</td>
                                <td style="width:4%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inputBreedingLogArray as $key => $input)
                                <tr>
                                    <!--日期-->
                                    <td>
                                        <div class="flex items-center h-5 align-middle">
                                            <input class="form-control" type="date"
                                                wire:model.lazy="inputBreedingLogArray.{{ $key }}.date"
                                                min="{{ \Carbon\Carbon::parse($importDate)->format('Y-m-d') }}"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                @if (auth()->user()->permissions[2] < 4 && !isset($this->inputBreedingLogArray[$key]['new_data'])) readonly @endif required>
                                            @php
                                                if (isset($input['date'])) {
                                                    $this->inputBreedingLogArray[$key]['age'] = $this->getAge($input['date'], $this->importDate);
                                                }
                                            @endphp

                                        </div>
                                    </td>
                                    <!--日齡-->
                                    <td>
                                        <input class="form-control" type="number" wire:model.lazy="inputBreedingLogArray.{{ $key }}.age" placeholder="請輸入數字" min="0" step="1" readonly>
                                    </td>
                                    <!--淘汰數-->
                                    <td>
                                        <input class="form-control" type="number"
                                            wire:model.lazy="inputBreedingLogArray.{{ $key }}.disuse"
                                            value="{{ isset($inputBreedingLogArray[$key]['disuse']) ? $inputBreedingLogArray[$key]['disuse'] : 0 }}"
                                            min="0" step="1"
                                            placeholder="0"
                                            @if (auth()->user()->permissions[2] < 4 && !isset($this->inputBreedingLogArray[$key]['new_data'])) readonly @endif>
                                    </td>
                                    <!--總淘汰數-->
                                    <td>
                                        @php
                                            if (isset($input['disuse'])) {
                                                $totalDisuse = $totalDisuse + $input['disuse'];
                                            }
                                        @endphp
                                        <input class="form-control" type="number"
                                            @if (isset($inputBreedingLogArray[$key]['disuse'])) value="{{ $totalDisuse }}" @endif
                                            readonly="true">
                                    </td>
                                    <!--剩存羽數-->
                                    <td>
                                        @php
                                            if (isset($input['disuse'])) {
                                                $survivors = $survivors - $input['disuse'];
                                            }
                                        @endphp
                                        <input class="form-control" type="number"
                                            @if (isset($inputBreedingLogArray[$key]['disuse'])) value="{{ $survivors }}" @endif
                                            readonly="true"> 
                                    </td>
                                    @if (isset($input['date']))
                                        <td>
                                            <!--育成率-->
                                            <!--要存的-->
                                            <!--後面要加, '.', '', 一個是小數點，一個是每三個位元插得值，不定義的話會預設","然後轉字串，這樣在轉回數字時會有error-->
                                            @php
                                                $show_breeding_rate = '----';
                                                if ( isset($importQuantity) && ($importQuantity != 0) ) {
                                                    $this->inputBreedingLogArray[$key]['breeding_rate'] = number_format($survivors / ($importQuantity), 4, '.', '');
                                                    $show_breeding_rate = number_format($this->inputBreedingLogArray[$key]['breeding_rate'] * 100, 2, '.', '');
                                                } 
                                            @endphp
                                            <input class="form-control" type="text"
                                                value="{{ $show_breeding_rate }}" placeholder="" readonly>
                                        </td>
                                        <td>
                                            <!--上午均重-->
                                            @php
                                                //取上午均重
                                                $morningWeight = $this->morning_weight_array[$input['date']] ?? 'N/A';

                                                if ($morningWeight === 'N/A') {
                                                    $morningWeight = null;
                                                }

                                                //第一次進來的時候，要先把均重設定為入雛均重
                                                $this->last_avg_weight = $this->import_avg_weight;

                                                //根據日齡去找對應的均重
                                                if (isset($input['date'])) {
                                                    $this->inputBreedingLogArray[$key]['age'] = $this->getAge($input['date'], $this->importDate);
                                                }

                                                // for ($i = 0; $i < $this->inputBreedingLogArray[$key]['age']; $i++) {
                                                //     // 日齡 / 7 無條件進位，如果是0就變成1
                                                //     $index = floor($i / 7) - 1;
                                                //     // 防止超出陣列範圍
                                                //     if ($index > 4) {
                                                //         $index = 4;
                                                //     }

                                                //     // 沒有資料時，直接套用國際平均增重
                                                //     $this->last_avg_weight = $this->last_avg_weight + $this->average_weight_gain[$index + 1];
                                                // }


                                                $this->inputBreedingLogArray[$key]['am_avg_weight'] = $morningWeight;

                                            @endphp
                                            <input class="form-control" type="text" value="{{ $morningWeight ? number_format($morningWeight, 2, '.', ',') : 0 }}" readonly > <!-- 如果变量 $morningWeight 存在且不为空（即其逻辑值为真），则对其进行格式化；如果不存在或为空，则输入框中显示為0。 --> 
                                        </td>
                                        <td>
                                            <!--下午均重-->
                                            @php
                                                //取下午均重
                                                $eveningWeight = $this->evening_weight_array[$input['date']] ?? 'N/A';

                                                if ($eveningWeight === 'N/A') {
                                                    $eveningWeight = null;
                                                }

                                                //第一次進來的時候，要先把均重設定為入雛均重
                                                $this->last_avg_weight = $this->import_avg_weight;

                                                //根據日齡去找對應的均重
                                                if (isset($input['date'])) {
                                                    $this->inputBreedingLogArray[$key]['age'] = $this->getAge($input['date'], $this->importDate);
                                                }

                                                for ($i = 0; $i < $this->inputBreedingLogArray[$key]['age']; $i++) {
                                                    // 日齡 / 7 無條件進位，如果是0就變成1
                                                    $index = floor($i / 7) - 1;
                                                    // 防止超出陣列範圍
                                                    if ($index > 4) {
                                                        $index = 4;
                                                    }

                                                    // 沒有資料時，直接套用國際平均增重
                                                    $this->last_avg_weight = $this->last_avg_weight + $this->average_weight_gain[$index + 1];
                                                }

                                                $this->inputBreedingLogArray[$key]['pm_avg_weight'] = $eveningWeight;

                                            @endphp
                                            <input class="form-control" type="text" value="{{ $eveningWeight ? number_format($eveningWeight, 2, '.', ',') : 0 }}" readonly > <!-- 如果$eveningWeight存在且不為null（即其邏輯值為真），則對其進行格式化；如果不存在或為null，則輸入框中顯示0。 -->
                                        </td>
                                        <td>
                                            <button
                                                class="btn-primary @if (Auth::user()->permissions[2] < 4 && !isset($this->inputBreedingLogArray[$key]['new_data'])) cant_delete_permission @endif "
                                                style="background-color: red;" type="button"
                                                onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $key }}, 'breeding_log')">刪除</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- 如果有重複日期，就會跳出警告, $errors是在component的$this->addError裡填加 --}}
                    @if ($errors->has('duplicate_date'))
                        <script>
                            alert("{{ $errors->first('duplicate_date') }}");
                        </script>
                        {{-- 如果入雛沒有填完整導致的分母有0，就會跳出警告, $errors是在component的$this->addError裡填加 --}}
                    @elseif ($errors->has('actual_quantity_is_zero'))
                        <script>
                            alert("{{ $errors->first('actual_quantity_is_zero') }}");
                            // window.history.back(-1);
                        </script>
                    @endif
                    <div class="flex justify-between">
                        @if ($DataInChickenOut == 0)
                            <button class="btn-primary" type="button" wire:click="addInput(1)">+</button>
                        @else
                            <p>{{$DataInChickenOut}}</p>
                        @endif
                    </div>
                </td>
            </tr>

            {{-- 飼料 --}}
            <tr>
                <td colspan="11">
                    <hr class="my-5">
                    <table class="table-fixed">
                        <thead>
                            <tr>
                                <td style="width:5%">日期</td>
                                <td style="width:5%">飼養行為</td>
                                <td style="width:13%">投料名稱</td>
                                <td style="width:9%">飼料量（kg）</td>
                                <td style="width:6%">使用抗生素</td>
                                <td style="width:9%">累計量（kg）</td>
                                <td class="hoverable-feeding-perf" style="width:5%">飼效</td>
                                <td style="width:4%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            {{--     public Collection $input_feeds; --}}
                            @foreach ($inputFeedingArray as $keyFeeds => $inputFeed)
                                @php
                                    $variableName = 'A_accumulated_weight';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center h-5 align-middle">
                                            <input class="form-control" type="hidden"
                                                wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.id">

                                            <input class="form-control" type="date"
                                                wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.date"
                                                min="{{ \Carbon\Carbon::parse($importDate)->subDays(40)->format('Y-m-d') }}"
                                                max="{{ \Carbon\Carbon::parse($importDate)->addDays(40)->format('Y-m-d') }}"
                                                @if (auth()->user()->permissions[2] < 4 && !isset($this->inputFeedingArray[$keyFeeds]['new_data'])) readonly @endif required>

                                        </div>
                                    </td>
                                    <!--飼養行為-->
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.feed_type"
                                            wire:click="showOptions('feed_type', {{ $keyFeeds }})"
                                            placeholder="飼養行為" required readonly>

                                        <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                                            @if ($showOptions['feed_type'] === $keyFeeds && $isOptionOpen['feed_type']) style="display: block;" @else style="display: none;" @endif>
                                            <ul>
                                                @foreach ($typeOptions as $type => $value)
                                                    <li wire:click="selectOption('{{ $type }}', '{{ $keyFeeds }}', 'feed_type')"
                                                        class="px-3 py-1 hover:bg-gray-200">
                                                        {{ $value }}
                                                    </li>
                                                @endforeach
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="closeOption('feed_type')">關閉</button>
                                            </ul>
                                        </div>
                                    </td>
                                    @php
                                        $dont_show = false;
                                        if (isset($inputFeed['feed_type'])) {
                                            $variableName = $inputFeed['feed_type'] . '_accumulated_weight';
                                            if ($inputFeed['feed_type'] == 'E' || $inputFeed['feed_type'] == 'F') {
                                                $this->inputFeedingArray[$keyFeeds]['feed_item'] = '----';
                                                $this->inputFeedingArray[$keyFeeds]['feed_quantity'] = '----';
                                                $this->inputFeedingArray[$keyFeeds]['add_antibiotics'] = 0;
                                                $this->antibioticArray[$keyFeeds] = '----';
                                                $this->inputFeedingArray[$keyFeeds]['feed_cumulant'] = 0;
                                                $this->inputFeedingArray[$keyFeeds]['feeding_efficiency'] = 0;
                                                $dont_show = true;
                                            }
                                        }
                                    @endphp
                                    <!--投料名稱-->
                                    <td>
                                        <input class="form-control" type="text" wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.feed_item" placeholder="投料名稱" @if ($dont_show) readonly @endif>
                                    </td>
                                    <!--飼料量-->
                                    <td>
                                        <input class="form-control" type="number" wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.feed_quantity" placeholder="飼料量（kg）" min=0 step='any' @if ($dont_show) readonly @endif>
                                    </td>
                                    <!--使用抗生素-->
                                    <td>
                                        <input class="form-control" type="text" {{-- wire:model.lazy="inputFeedingArray.{{ $keyFeeds }}.add_antibiotics" --}}
                                            wire:model.lazy="antibioticArray.{{ $keyFeeds }}"
                                            @if (!$dont_show) wire:click="showOptions('add_antibiotics', {{ $keyFeeds }})" @endif
                                            readonly>

                                        <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                                            @if ($showOptions['add_antibiotics'] === $keyFeeds && $isOptionOpen['add_antibiotics']) style="display: block;" @else style="display: none;" @endif>
                                            <ul>
                                                @foreach (['YES' => '1', 'NO' => '0'] as $option => $value)
                                                    <li wire:click="selectOption('{{ $value }}', '{{ $keyFeeds }}', 'add_antibiotics')"
                                                        class="px-3 py-1 hover:bg-gray-200">
                                                        {{ $option }}
                                                    </li>
                                                @endforeach
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="closeOption('add_antibiotics')">關閉</button>
                                            </ul>
                                        </div>
                                    </td>
                                    <!--累計量-->
                                    @php
                                        if (isset($inputFeed['feed_type'])) {
                                            if ($dont_show) {
                                                $$variableName = '----';
                                            } elseif (isset($inputFeed['feed_quantity'])) {
                                                $inputFeed['feed_quantity'] = $inputFeed['feed_quantity'] == '----' ? 0 : $inputFeed['feed_quantity'];
                                                $$variableName = $$variableName + $inputFeed['feed_quantity'];
                                                //如果用抓得不重算之後若有修改的話，會有問題
                                                $this->inputFeedingArray[$keyFeeds]['feed_cumulant'] = $$variableName;
                                            }
                                        }

                                    @endphp
                                    <td>
                                        <input class="form-control" type="text" value="{{ $$variableName }}"
                                            placeholder="" readonly>
                                    </td>
                                    <!-- 飼效 = 飼料總重 / 剩存羽數 / 均重 -->
                                    <td>
                                        @php
                                            // 設定時區 & 獲取當天日期和當前小時
                                            date_default_timezone_set('Asia/Taipei'); // 设置默认时区为台北时区
                                            $today = date('Y-m-d'); // 取得今天日期
                                            $currentHour = date('H'); // 获取当前的小时数（24小时制）

                                            // 初始化 feeding_efficiency 为 '----'
                                            $feeding_efficiency = '----';

                                            // 先以飼養日期比對生長日期
                                            if (isset($input['date'], $input) && $inputFeed['date'] == $today && $input['date'] == $today) {
                                                if ( ($currentHour >= 6 && $currentHour < 18) || empty($this->inputBreedingLogArray[$key]['pm_avg_weight']) ) {
                                                    // 判断当前时间是否在上午6点到下午6点之间 或 下午均重為零 → 使用上午均重
                                                    $this->last_avg_weight = $this->inputBreedingLogArray[$key]['am_avg_weight'];
                                                } else {
                                                    // 否則即是 "1800到到第二天的早上6am" → 使用下午均重
                                                    $this->last_avg_weight = $this->inputBreedingLogArray[$key]['pm_avg_weight'];
                                                }
                                            } else {
                                                $this->last_avg_weight = $this->getWeight($inputFeed['date']); // ★非常重要，一定要了解這行代碼。★
                                            }

                                            // 計算飼效
                                            if ($survivors != 0 && $this->last_avg_weight != 0) {
                                                $this->inputFeedingArray[$keyFeeds]['feeding_efficiency'] = $A_accumulated_weight / $survivors / (floatval($this->last_avg_weight) / 1000); // floatval將文字化為數值
                                            } else {
                                                $this->inputFeedingArray[$keyFeeds]['feeding_efficiency'] = 0;
                                            }

                                            // 計算并格式化 feeding_efficiency
                                            if (isset($this->inputFeedingArray[$keyFeeds]['feed_type']) && $this->inputFeedingArray[$keyFeeds]['feed_type'] == 'A') {
                                                $feeding_efficiency = number_format($this->inputFeedingArray[$keyFeeds]['feeding_efficiency'], 2, '.', '');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" value="{{ $feeding_efficiency }}" readonly>
                                    </td>
                                    <td>
                                        <button
                                            class="btn-primary @if (Auth::user()->permissions[2] < 4 && !isset($this->inputFeedingArray[$keyFeeds]['new_data'])) cant_delete_permission @endif "
                                            style="background-color: red;" type="button"
                                            onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $keyFeeds }}, 'feeding_log')">刪除</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" wire:click="addInputFeed(1)">+</button>
                    </div>
                </td>
            </tr>

            {{-- 育成狀況 --}}
            <tr>
                <td colspan="11">
                    <hr class="my-5">
                    <table class="table-fixed">

                        <tbody>

                            <style>
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
                            </style>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 橫向排列且往後對齊 --}}
    <div class="flex justify-end">
        <button class="btn-primary" type="submit" onclick="display_alert()">保存</button>
    </div>
</form>

<script type="text/javascript">
    function display_alert() {
        // alert("保存成功！")
    }
</script>

<style>
    .user-setting-input {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #050505;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .cant_delete_permission {
        pointer-events: none;
        background-color: #676565 !important;
    }

    .cant_edit {
        pointer-events: none;
    }

    ul {
        border: 2px solid rgb(45, 19, 242);
        border-radius: 8px;
        padding: 10px;
    }
</style>
