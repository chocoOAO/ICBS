<form action="#" wire:submit.prevent="submit">

    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
    @if ($inputs->isNotEmpty())
        <button type="button" class="btn btn-primary" style="margin-left: 10px;" wire:click="exportPDF">列印</button>
    @endif

    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center" style="font-weight: bold; font-size:20px">抓雞派車單</h2>
    </div>

    <style>
        .min-width-100px {
            min-width: 100px;
        }
        
    </style>

    @if ($errors->has('No_ImportNum'))
        <script>
            alert("{{ $errors->first('No_ImportNum') }}");
        </script>
    @endif

    @if ($errors->has('exceedTotalSurvivors'))
        <script>
            alert("{{ $errors->first('exceedTotalSurvivors') }}");
        </script>
    @endif
    
    <div class="table-wrapper">
        <div class="md-card-content" style="overflow-x: auto;">
            <table class="max-w-full table-fixed"> <!-- 確保表格在其父容器內以固定佈局(fixed table layout)的方式呈現，同時最大寬度不超過其父容器。-->
                <thead>
                    <tr>
                        <td class="min-width-100px">批號</td>                                                
                        <td class="min-width-100px">棟舍</td>
                        <td class="min-width-100px">客戶主檔</td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <!-- 批號 -->
                        <td>
                            <div class="relative flex items-center custom-width100">
                                <div class="text-sm" style="display: flex;">
                                    <!-- wire:click="showOptions('importNum',1)"是當輸入框被點擊時觸發Livewire組件的showOptions方法。；readonly屬性使輸入框為只讀，用戶不能直接編輯。 -->
                                    <input class="form-control" type="text" wire:model.lazy="importNum" wire:click="showOptions('importNum',1)" readonly> 
                                </div>
                            </div>
                            <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                                @if ($showOptions['importNum']) style="display: block;" @else style="display: none;" @endif>
                                <ul>
                                    @foreach ($importNumOptions as $key => $import_number)
                                        <li class="px-3 py-1 hover:bg-gray-200" wire:click="selectOption('{{ $import_number['id'] }}', '{{ $key }}', 'importNum')">
                                            {{ $import_number['id'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>

                        <!-- 棟舍 -->
                        <td>
                            <div class="relative flex items-center custom-width100">
                                <div class="text-sm" style="display: flex;">
                                    <input class="form-control" type="text" wire:model.lazy="building_number" wire:click="showOptions('building_number',1)" readonly>
                                </div>
                            </div>
                            <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                                @if ($showOptions['building_number']) style="display: block;" @else style="display: none;" @endif>
                                <ul>
                                    @foreach ($buildingNumOptions as $key => $building_number)
                                        <li class="px-3 py-1 hover:bg-gray-200" wire:click="selectOption('{{ $building_number }}', '{{ $key }}', 'building_number')">
                                            {{ $building_number }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>

                        <!-- 客戶主檔 -->
                        <td>
                            <div class="relative flex items-center custom-width100">
                                <div class="text-sm" style="display: flex;">
                                    <!-- style="cursor: not-allowed;"直接在元素上設置了一個內聯樣式，這會將鼠標指針更改為不允許的符號（通常是一個斜杠圈）。 -->
                                    <input class="form-control" style="cursor: not-allowed;" type="text" wire:model.lazy="m_NAME" readonly="true">                                    
                                </div>
                            </div>    
                        </td>
                    </tr>                                                                                    
                </tbody>
            </table>
            <p style="color:gray;">※ 請點擊批號或棟舍的輸入框，然後透過下拉式選單來指定資料。</p>
        </div>
    </div>

    <hr class="my-5"> <!-- 水平線標籤 -->

    <div class="table-wrapper">
        <div class="md-card-content" style="overflow-x: auto;">
            <table class="max-w-full table-fixed">
                <thead>
                    <tr>
                        <td>日期</td>
                        {{-- <td class="min-width-100px">車次</td>
                        <td class="min-width-100px">車號</td> --}}
                        {{-- <td style="min-width: 80px;">助手</td> --}}
                        <td style="min-width: 80px;">雞主</td>
                        <td class="min-width-100px">隻數（羽）</td>
                        <td>抓雞時間</td>
                        <td style="min-width: 110px;">雞主電話</td>
                        {{-- <td class="min-width-100px">抓雞工</td> --}}
                        <td class="min-width-100px">地點</td> <!-- 產地 -->
                        <td class="min-width-100px">預估重量</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($inputs as $key => $input)
                    <tr>
                        <!-- 日期 -->
                        <td>
                            <input class="form-control" type="date" wire:model.lazy="inputs.{{ $key }}.date" required>
                        </td>

                        {{-- 
                            <!-- 車次 -->
                            <td>
                                <div class="flex items-center h-5 align-middle">
                                    <input class="form-control" type="text"
                                        wire:model.lazy="inputs.{{ $key }}.id"
                                    readonly="true">
                                </div>
                            </td>
                            <!-- 車號 -->
                            <td>
                                <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.car_code" placeholder="TSA-9999" min="0">
                            </td> 
                            <!-- 助手 -->
                            <td>
                            <input class="form-control" type="text"
                                wire:model.lazy="inputs.{{ $key }}.assistant"
                                placeholder="王大臻" min="0">
                            </td> 
                        --}}

                        <!-- 雞主 -->
                        <td>
                            <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.owner" required>
                        </td>
                        <!-- 隻數（羽） -->
                        <td>
                            <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.quantity" min=0 step=1 required> {{-- type="number" 限制输入框只允许输入数字。这不仅可以在视觉上提示用户，而且在大多数现代浏览器上还会阻止非数字的输入。min="0"属性确保输入的数字不会小于0。 --}}
                        </td>
                        <!-- 抓雞時間 -->
                        <td>
                            <input class="form-control" type="time" wire:model.lazy="inputs.{{ $key }}.time" required>
                        </td>
                        <!-- 雞主電話 -->
                        <td>
                            <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.phone_number" placeholder="請填寫電話號碼">
                        </td>

                        <!-- 抓雞工 -->
                        {{-- <td>
                                <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.worker" placeholder="邱阿臻">
                        </td> --}}

                        <!-- 產地/地點 -->
                        <td>
                            <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.origin">
                        </td>
                        <!-- 預估重量 -->
                        <td>
                            <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.weight" readonly>
                        </td>

                        <td>
                            <button class="btn-primary" style="background-color: red; color: white;" type="button" onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()" wire:click="delete({{ $key }})">刪除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between">
        <button class="btn-primary" type="button" wire:click="addInput()">+</button>
    </div>
    
    @php
        // 变量初始化：确保所有变量在 @php 块中初始化，以防止未定义变量错误。
        $quantity = null;
        $totalChickenOut = 0;

        if (isset($data, $inputs)){
            $quantity = $data['quantity'] ?? null;
            $totalChickenOut = collect($inputs)->sum('quantity');
        }
    @endphp
    @if (isset($data, $inputs, $quantity) && $quantity==0)
        <div style="margin-top: 10px; color: red">
            {{ sprintf('※ 目前已抓取的羽數達 %s 隻，無法再進行進一步抓取。', number_format($totalChickenOut, 0, '.', ',') ) }}
        </div>
    @endif

    <div class="flex justify-end">
        <button class="btn-primary" type="submit" onclick="display_alert()">保存</button>
    </div>
</form>

    <script type="text/javascript">
        function display_alert() {
            // alert("保存成功！")
        }
    </script>