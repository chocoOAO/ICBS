<!--暫時沒有功能-->
<!-- <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
    wire:click="">上一個批號</button> -->
<!-- <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
    wire:click="">下一個批號</button> -->

    <!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        .grade-display {
        text-align: center;
        vertical-align: middle;
        font-size: 5em;
        font-weight: normal; /* 书法字体通常不需要加粗 */
        font-family: 'Great Vibes', cursive;
        }
        .custom-table {
        border-collapse: collapse;
        width: 100%;
        }

        .custom-table th, .custom-table td {
            border: 1px solid #ddd; /* 添加邊框樣式，可根據需要調整 */
            word-wrap: break-word; /* 使文字換行 */
            max-width: 100px; /* 設置最大寬度，可根據需要調整 */
        }

        .custom-table td {
            white-space: normal; /* 設置文字換行 */
            padding: 8px; /* 添加內邊距，可根據需要調整 */
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr; /* Creates three columns of equal width */
            grid-template-rows: 1fr 0.05fr; /* Creates two rows, second row is three times taller than the first */
            grid-gap: 10px; /* Adds gap between grid items */
            height: 200px; /* Set the height of the grid container */
            width: 100%; /* Set the width of the grid container */
        }
        
        .grid-item {
            background-color: white; /* Sets the background color of grid items in the top row */
            border: 1px solid black; /* Adds border to the grid items */
        }

        .grid-item-middle {
            border: none; /* Removes the border from the middle item */
        }

        .grid-container-title {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr; /* Creates three columns of equal width */
            grid-gap: 10px; /* Adds gap between grid items */
            text-align: left; /* Aligns text to the left */
            width: 100%; /* Set the width of the grid container */
        }

        .grid-item-title {
            margin-bottom: 10px; /* 为标题和滚动框之间添加一些空间 */
            padding-left: 4px; /* 如果需要的话，给标题添加一些内边距 */
            /* 添加其他样式来美化标题，比如字体大小、字体粗细等 */
            font-weight: bold;
            font-size: 18px; /* 设置字体大小为18像素 */
        }

        table {
            border: 2px solid black;
            padding: .4rem;
            width: 100%;
            border-collapse: collapse;
        }


        th {
            background-color: #f2f2f2;
            border: 2px solid black;
            text-align: center;
        }
        /* ..............................想再做調整可以修改 */
        td {
            border: 1px solid #ccc;
            padding: .4rem;
        }

        /* .min-width-100px {
            min-width: 100px;
        } */

        /* 向右箭頭(加入已選擇的結帳單號) */
        .button_ArrowRight {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            position: relative;
        }
        .button_ArrowRight:hover {
            background-color: #3e8e41
        }
        .button_ArrowRight:hover::before { /* Add this block */
            content: "加入已選擇的結帳單號";
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            color: #000;
            padding: 5px;
            border: 1px solid #000;
            border-radius: 5px;
            margin-top: 120px;
        }
        .button_ArrowRight:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        /* 向左箭頭(移回已選擇的結帳單號) */
        .button_ArrowLeft {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            position: relative;
        }
        .button_ArrowLeft:hover {
            background-color: #3e8e41
        }
        .button_ArrowLeft:hover::before { /* Add this block */
            content: "移回已選擇的結帳單號";
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            color: #000;
            padding: 5px;
            border: 1px solid #000;
            border-radius: 5px;
            margin-top: 10px;
        }
        .button_ArrowLeft:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

    </style>
</head>

<table class="max-w-full table-fixed" style="border: 1px solid black; border-collapse: collapse; margin-top: 10px;">
    <tbody>
        <tr>
            <td style="text-align: left;">
                福壽批次
            </td>
            <td style="text-align: left;">
                <div class="relative flex items-center custom-width100 text-sm" style="display: flex;">
                    <input class="form-control" type="text" wire:model.lazy="breeder"
                        wire:click="Batch_ShowOptions('breeder',1)" readonly> 
                </div>
                <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                    @if ($batch_showOptions_array['breeder']) style="display: block;" @else style="display: none;" @endif> <!-- 如果 $batch_showOptions_array['breeder'] 为 true，则执行 style="display: block;"，使元素可见 ; 如果 $batch_showOptions_array['breeder'] 为 false，则执行 style="display: none;"，使元素不可见。-->
                    <ul>
                        @foreach ($BatchOptions as $key => $batch_number)
                            <li wire:click="Batch_SelectOption('{{ $batch_number['breeder'] }}', '{{ $key }}', 'breeder')"
                                class="px-3 py-1 hover:bg-gray-200">
                                {{ $batch_number['breeder'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </td>
            <td style="text-align: left;">
                過磅日期
            </td>
            <td style="text-align: left;">
                <div class="relative flex items-center custom-width100 text-sm" style="display: flex;">
                    <input class="form-control" type="text" wire:model.lazy="weighing_date"
                    wire:click="Batch_ShowOptions('weighing_date',1)" readonly> 
                </div>
                <div class="absolute z-10 bg-white border border-gray-300 rounded-md"
                    @if ($batch_showOptions_array['weighing_date']) style="display: block;" @else style="display: none;" @endif>
                    <ul>
                        @foreach ($WeighingDateOptions as $key => $weighing_date)
                            <li wire:click="Batch_SelectOption('{{ $weighing_date['weighing_date'] }}', '{{ $key }}', 'weighing_date')"
                                class="px-3 py-1 hover:bg-gray-200">
                                {{ $weighing_date['weighing_date'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- title -->
<div class="my-2 py-5 border-gray-200">
    <h2 class="text-xl text-gray-800 leading-tight text-center" style="font-weight: bold; font-size:25px">毛雞結款單</h2>
</div>

{{-- 如果無法抓到批號(importNum)，代表或許沒有資料，跳出警告視窗，並傳回空白表單。 --}}
@if ($errors->has('No_ImportNum'))
<script>
    alert("{{ $errors->first('No_ImportNum') }}"); // $errors是在component的$this->addError裡填加
</script>
@endif

<body>

    <div class="grid-container-title" >           
        <div class="grid-item-title">未選擇的結帳單號</div>
        <div class="grid-item-middle"></div>  <!-- 如果不要框線，class請改用grid-item-middle -->
        <div class="grid-item-title">已選擇的結帳單號</div>
    </div>

    <div class="grid-container">
        
        <!-- 未選擇的結帳單號(Scroll Bar) -->
        <div class="grid-item" style="overflow:auto;"> 
        <!-- style="overflow:auto;"是为一个元素添加滚动条，当元素的内容超过版面十，浏览器将显示滚动条。
        overflow-y: auto;是為元素的垂直方向上添加滚动条、overflow-x: auto;是允许水平滚动、overflow: auto;則是同时控制垂直和水平滚动。 -->
        @if (!is_null($Unselection_AccountNumber))
            <ul>
                @foreach ($Unselection_AccountNumber as $key => $selection)
                    <li class="px-3 py-1 hover:bg-gray-200" style="{{ $selection == $account_number ? 'background-color: #FFFF00;' : '' }}" wire:click="SettleUp_SelectOption('{{ $selection }}')">
                        {{ $selection }}
                    </li>
                @endforeach
            </ul>
        @endif
        </div>

        <div class="grid-item-middle" style="display: flex;  flex-direction: column; justify-content: center; align-items: center;"> <!-- flex-direction: column; => 將按鈕排列成一個垂直的列 -->
            <button type="button" class="button_ArrowRight" style="border: 1px solid black;" wire:click="AddIntoSelectedArea"> <!-- position: relative; top: -50px => 將元素偏向視窗的上方 -->
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16" >
                    <path fill-rule="evenodd" d="M1.5 7.5a.5.5 0 0 1 .5-.5h8.793L9.146 4.707a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L10.793 8H2a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <br>
            <button type="button" class="button_ArrowLeft" style="border: 1px solid black;" wire:click="RetrieveSelectedArea"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16" style="transform: scaleX(-1);">
                    <path fill-rule="evenodd" d="M1.5 7.5a.5.5 0 0 1 .5-.5h8.793L9.146 4.707a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L10.793 8H2a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
        </div>  <!-- 如果不要框線，class請改用grid-item-middle -->
        
        <!-- 已選擇的結帳單號(Scroll Bar) -->
        <div class="grid-item" style="overflow:auto;">
            <ul>
                @foreach ($Selected_AccountNumber as $key => $selection)
                    <li class="px-3 py-1 hover:bg-gray-200" style="{{ $selection == $account_number ? 'background-color: #FFFF00;' : '' }}" wire:click="SettleUp_SelectOption('{{ $selection }}')">
                        {{ $selection }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <table class="max-w-full table-fixed" style="border-collapse: collapse; border: none; display: flex; justify-content: flex-end;">
        <tbody>
            <tr>
                <td style="border: none;">
                    <button type="submit" class="btn-primary" style="display: flex; font-size: 1.5rem; padding: 1rem 1rem; background-color: #91989F; color: #FCFAF2;" onclick="confirm('確定要列印結款單嗎?') || event.stopImmediatePropagation()" wire:click="exportPDF">列印</button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- <br> -->
    @if($show_flag)
    <table class="max-w-full table-fixed custom-table" style="width:100%">
        <tbody>
            <tr>
                <td > 
                    帳款單號：
                </td>
                <td colspan="2">
                    {{ $settlementData->account_number }}
                </td>
                
                @php
                    if ($weighing_date !== null && !is_null($weighing_date['weighing_date'])){
                        $show_weighing_date = $weighing_date['weighing_date'];
                    }
                    else{
                        $show_weighing_date = '未選擇';
                    }
                @endphp
                
                <td>
                    過磅日期：<!-- 帳款日期： -->
                </td>
                <td>
                    {{ $settlementData->weighing_date }}
                </td>
                
                <td>
                    廠商：
                </td>
                <td >
                    {{ $contract->m_NAME }}
                </td>
                <td>
                    飼主：
                </td>
                <td >
                    {{ $settlementData->breeder }}
                </td>
            </tr>
            <tr>
                <td>
                    畜牧場：
                </td>
                <td>
                    {{ $settlementData->livestock_farm_name }}
                </td>
                <td>
                    地點：
                </td>
                <td>
                    {{ $address }}
                </td>
                <td>
                    報紙價：
                </td>
                <td>
                    {{ $settlementData->price_of_newspaper }}
                </td>
                <td>
                    手續費：
                </td>
                <td>
                    {{ $settlementData->price_of_newspaper-$settlementData->unit_price }}
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th colspan="2">序號</th>
                <th colspan="2">公斤重</th>
                <th colspan="2">台斤重</th>
                <th colspan="2">單價</th>
                <th colspan="2">羽數</th>
                <th colspan="2">平均重</th>
                <th colspan="2">下雞</th>
                <th colspan="2">死雞</th>
                <th colspan="2">剔除雞</th>
                <th colspan="2">臭爪％</th>
                <th colspan="2">臭胸％</th>
                <th colspan="2">皮膚炎％</th>
                <th colspan="2">飼料殘留％</th>
                <th colspan="2">貨款金額</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($settlementData2 as $key => $input)
            <tr style="border:2px ">
                <!-- 批號 -->
                <td colspan="2">
                    {{ $input->number }}
                </td>
                <!-- 公斤重 -->
                <td colspan="2">
                    {{ $input->kilogram_weight }}
                </td>
                <!-- 台斤重 -->
                <td colspan="2">
                    {{ number_format($input->catty_weight, 2) }}
                </td>
                <!-- 單價 -->
                <td colspan="2">
                    {{ $input->unit_price }}
                </td>
                <!-- 羽數 -->
                <td colspan="2">
                    {{ $input->total_of_birds }}
                </td>
                <!-- 平均重 -->
                <td colspan="2">
                    {{ number_format(round($input->average_weight, 2), 2) }}
                </td>
                <!-- 下雞 -->
                <td colspan="2">
                    {{ $input->down_chicken }}
                </td>
                <!-- 死雞 -->
                <td colspan="2">
                    {{ $input->death }}
                </td>
                <!-- 剔除雞 -->
                <td colspan="2">
                    {{ $input->discard }}

                </td>
                <td colspan="2">
                    {{ $input->stinking_claw }}
                </td>
                <!-- 臭胸% -->
                <td colspan="2">
                    {{ $input->stinking_chest }}
                </td>

                <!-- 皮膚癌% -->
                <td colspan="2">
                    {{ $input->dermatitis }}
                </td>

                <!-- 飼料殘留% -->
                <td colspan="2">
                    {{ $input->residue }}
                </td>

                <!-- 貸款金額 -->
                <td colspan="2">
                    {{ number_format($input->catty_weight * $input->unit_price) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width:100%">
        <tr>
            <td style="text-align: center;" colspan="2" rowspan="2">小計</td>
            <!-- 公斤重Total -->
            <td style="text-align: center;">總公斤</td>
            <td style="text-align: center;" colspan="2">{{ $total_weight }} </td>
            <!-- 台斤重Total -->
            <td style="text-align: center;">總台斤</td>
            <td style="text-align: center;" colspan="2">{{ $total_catty_weight }}</td>
            <!-- 總羽數Total -->
            <td style="text-align: center;">總羽數</td>
            <td style="text-align: center;" colspan="2">{{ $total_amount }}</td>
            <!-- 均重Total -->
            <td style="text-align: center;">平均數</td>
            <td style="text-align: center;">{{ number_format(round($total_avg_weight, 2), 2) }}</td>
            

        </tr>
        <tr>
            <!-- 下雞Total -->
            <td style="text-align: center;">總下雞數</td>
            <td style="text-align: center;" colspan="2">{{ $total_down_chicken }}</td>
            <!-- 死雞Total -->
            <td style="text-align: center;">總死雞數</td>
            <td style="text-align: center;" colspan="2">{{ $total_death_chicken }}</td>
            <!-- 剔除雞Total -->
            <td style="text-align: center;">總剔除數</td>
            <td style="text-align: center;" colspan="2">{{ $total_abandoned_weight }}</td>
            <!-- 總貸款Total -->
            <td style="text-align: center;">總貸款</td>
            <td style="text-align: center;" colspan="2">{{ $total_loan }}</td>
        </tr>
        </tr>
    </table>

    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="width: 2%;">
                    <p style="text-align: center;">標籤</p>
                </th>
                <th style="width: 70%;">
                    <p style="text-align: center;">細節</p>
                </th>
                <th style="width: 12%;">
                    <p style="text-align: center;">等級</p>
                </th>
                <th style="width: 8%;">
                    <p style="text-align: center;">健康狀況</p>
                </th>
                <th style="width: 8%;">
                    <p style="text-align: center;">百分比</p>
                </th>
            </tr>
        </thead>
        
        <tbody>
<!-- // 扣除金額 // -->
        <tr>
            <td>
                <p style="text-align: center;">扣</p>
                <p style="text-align: center;">除</p>
                <p style="text-align: center;">金</p>
                <p style="text-align: center;">額</p>
            </td>

            <td>
                <div style="text-align: left; vertical-align: top; color: #333;">
                    〔基本扣款項目〕
                </div>
                <table style="width: 100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td style="width: 70%; text-align: left; vertical-align: middle; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第一個單元格佔70% -->
                            扣款項目
                        </td>
                        <td style="width: 30%; text-align: right; vertical-align: middle; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第二個單元格佔30% -->
                            扣款金額（新台幣）
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 70%; text-align: left; color: #333; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第一個單元格佔70% -->
                            1.剔除雞扣款：{{ $eliminate_chicken_deductions }}元
                        </td>
                        <td style="width: 30%; text-align: right; color: #333; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第二個單元格佔30% -->
                            NT$ {{ number_format($eliminate_chicken_deductions, 0, '.', ',') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            2.死雞扣款：{{ $dead_chickens_deductions }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($dead_chickens_deductions, 0, '.', ',') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            3.臭爪扣款：{{ $stinky_claw_deduction }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($stinky_claw_deduction, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            4.毛雞車越縣補助：{{ $maoji_car_subsidies }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($maoji_car_subsidies, 0, '.', ',') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            5.超大雞扣款：{{ $extra_large_chicken }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($extra_large_chicken, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            6.皮膚炎扣款：{{ $stinky_dermatitis }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($stinky_dermatitis, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            7.臭胸扣款：{{ $stinky_stinking_chest }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($stinky_stinking_chest, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; color: #333; border: none;">
                            8.雛雞折扣：{{ $chick_discount }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($chick_discount, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr> <td colspan="2" style="border-top: 1px dashed #ccc; border-bottom: none; padding: 0;"></td> </tr>
                    <tr>
                        <td style="text-align: right; color: #333; border: none;">
                            小計扣款金額：{{ $eliminate_chicken_deductions+$dead_chickens_deductions+$stinky_claw_deduction+$extra_large_chicken + $stinky_dermatitis + $stinky_stinking_chest + $chick_discount}}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($eliminate_chicken_deductions+$dead_chickens_deductions+$stinky_claw_deduction+$extra_large_chicken + $stinky_dermatitis + $stinky_stinking_chest + $chick_discount, 0, '.', ',') }} 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #333; border: none;">  
                            小計補助金額：{{ $maoji_car_subsidies }}元
                        </td>
                        <td style="text-align: right; color: #333; border: none;">  
                            NT$ {{ number_format($maoji_car_subsidies, 0, '.', ',') }}
                        </td>
                    </tr>
                    <!-- 插入虛線分隔行 -->
                    <tr> <td colspan="2" style="border-top: 1px dashed #ccc; border-bottom: none; padding: 0;"></td> </tr>                            
                </table>
                    
                @php
                    $Deduction_Key = 0;
                @endphp

                <div style="margin-top: 15px; margin-bottom: 15px;"></div> <!-- 在上下创建间隙 -->
                <div style="text-align: left; color: #333;">
                    〔其它額外扣款金額〕
                </div>

                @unless($Extra_Deduction_inputs && $Extra_Deduction_inputs->count() - 1 > 0) <!-- 检查 Extra_Deduction_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                    <p style="font-style: italic;">NULL，沒有多個扣款輸入。</p>
                @endunless

                @if($Extra_Deduction_inputs && $Extra_Deduction_inputs->count() - 1 > 0) <!-- 检查 Extra_Deduction_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <thead>
                        <tr>
                            <td style="width: auto; border: none;"></td> <!-- 因為不知道該如何分配比例、超過100%，所以這格宽度自动决定 -->
                            <td style="width: 60%;  text-align: center; vertical-align: middle; border: none;">
                                扣款項目
                            </td>
                            <td style="width: 30%;  text-align: center; vertical-align: middle; border: none;">
                                扣款金額（新台幣）
                            </td>
                            <td style="width: 10%;  text-align: center; vertical-align: middle; border: none;">
                                刪除
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($Extra_Deduction_inputs->slice(0, $Extra_Deduction_inputs->count() - 1) as $Deduction_Key => $Deduction_Data)
                            <tr>
                                <td style="text-align: left; color: #333; border: none;">
                                    {{ $Deduction_Key + 1 }}.）
                                </td>
                                <td style="color: #333; border: none;">
                                    <!-- wire:model.defer 这个指令用于延迟数据同步至组件的状态更新直到表单提交的时刻。 特别有用当处理包含大量数据输入字段的表单时，因为它减少了实时的数据绑定和更新，从而提高性能。。这意味着当用户在这个输入框中键入时，输入值不会立即同步更新到 Livewire 组件，更新只会在触发一些操作（如表单提交）时发生。-->
                                    <span style="display: flex; align-items: center;">
                                        <input type="text" class="form-control" style="display: inline-block; flex-grow: 1; margin-right: 5px; text-align: left;" wire:model.defer="Extra_Deduction_inputs.{{ $Deduction_Key }}.deduction_note"> <!-- input 使用了 flex-grow: 1; 来确保它可以占据除了 label 之外的所有可用空间。 -->
                                        <label style="display: inline-block; flex-shrink: 0; text-align: center; align-items: center;">：</label> <!-- label 使用了 flex-shrink: 0; 来确保它不会在空间不足时被缩小。 -->
                                    </span>
                                </td>
                                <td style="color: #333; border: none;">
                                    <span style="display: flex; align-items: center;">
                                        <input type="number" class="form-control" style="display: inline-block; flex-grow: 1; margin-right: 5px; text-align: right;" min="0" step="1" wire:model.defer="Extra_Deduction_inputs.{{ $Deduction_Key }}.user_deduction_amount"> <!-- 必須要為正整數，不得為負數。 -->
                                        <label style="display: inline-block; flex-shrink: 0; text-align: center; align-items: center;">元</label>
                                    </span>
                                </td>
                                <td style="text-align: right; border: none;">
                                    <button class="btn-primary" type="button" style="background-color: red; color: white;" onclick="confirm('您確定要刪除嗎？') || event.stopImmediatePropagation()" wire:click="delete( {{ $Deduction_Data->id }} )" aria-label="刪除">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>                         
                    </table>
                    <p></p> <!-- 保留間隙 -->
                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" onclick="DisplayAlert_UpdateData()" wire:click="update_Deduction()" aria-label="修改保存">修改並保存</button> 
                    </div>
                    <p></p> <!-- 保留間隙 -->
                @endif

                @if(count($Extra_Deduction_inputs) <= 25) <!-- 當初User說好不超過20列的，談好是20列，每列可放100個字。 --> 
                    <div style="margin-top: 15px; margin-bottom: 15px;"></div> <!-- 在上下创建间隙 -->
                    <div style="text-align: left; color: #333;">
                        〔使用者新增扣款〕
                    </div>
                    <table style="width: 100%; border-collapse: collapse;  border: none;">
                        <thead>
                        <tr>
                            <th style="width: 70%;  text-align: center; vertical-align: middle;">
                                扣款項目
                            </th>
                            <th style="width: 30%;  text-align: center; vertical-align: middle;">
                                扣款金額（元）
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="text-align: left; color: #333;">
                                <input class="form-control" type="text"  style="border: none; box-shadow: none;" wire:model.defer="Extra_Deduction_inputs.{{ $Deduction_Key + 1 }}.deduction_note" placeholder="請輸入扣款項目">
                            </td>
                            <td style="text-align: left; color: #333;">
                                <input class="form-control" type="number"style="border: none; box-shadow: none; text-align: right;" wire:model.defer="Extra_Deduction_inputs.{{ $Deduction_Key + 1 }}.user_deduction_amount" min="0" step="1" placeholder=0> <!-- 必須要為正整數，不得為負數。 -->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p style="text-align: right;"> ※扣款金額只需輸入數字，無需再輸入單位（元）。 </p> <!-- 保留間隙 -->
                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" wire:click="addInput_Deduction()" onclick="DisplayAlert_AddData()" aria-label="新增保存">新增並保存</button>
                    </div>
                    <p></p> <!-- 保留間隙 -->
                @endif
                
                <div style="width: 100%; height: 1px; background-color: black;"></div>  <!-- 細黑线 -->

                @php
                    $sum_deduction_amount = array_sum([
                        $eliminate_chicken_deductions,
                        $dead_chickens_deductions,
                        $stinky_claw_deduction,
                        $extra_large_chicken,
                        $maoji_car_subsidies,
                        $Extra_Deduction_inputs->sum('user_deduction_amount'),
                        $stinky_dermatitis,
                        $stinky_stinking_chest,
                        $chick_discount
                    ]);
                @endphp
                
                <div style="margin-top: 10px; margin-bottom: 10px;"></div> <!-- 在上下创建间隙 -->
                <div  class="flex justify-end text-right mr-5" style="font-size: 1.25rem;">
                    總計扣款金額：NT$ {{ number_format($sum_deduction_amount, 0, '.', ',') }} 
                </div>
                <p style="text-align: right;">※ 四捨五入至整數。</p> <!-- 保留間隙 -->
            </td>

            <td rowspan="3" class="grade-display">
                <h3>{{ $this->grade() }}</h3>
            </td>

            <td style="text-align: center;">
                臭爪
            </td>
            
            <td style="text-align: center;">
                {{ $total_stinking_claw }}%
            </td>
        </tr>
<!-- // 扣除金額 // -->

<!-- // 加項金額 // -->
        <tr>
            <td> 
                <p style="text-align: center;">加</p>
                <p style="text-align: center;">項</p>
                <p style="text-align: center;">金</p>
                <p style="text-align: center;">額</p>
            </td>

            <td style="vertical-align: top;">
                @php
                    $Plus_Key = 0;
                @endphp

                <div style="text-align: left; color: #333;">
                    〔加項項目與金額〕
                </div>
                    
                @unless($Extra_Plus_inputs && $Extra_Plus_inputs->count() - 1 > 0) <!-- 检查 Extra_Deduction_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                    <p style="font-style: italic;">NULL，尚未輸入任何額外加項項目。</p>
                @endunless

                @if($Extra_Plus_inputs && $Extra_Plus_inputs->count() - 1 > 0) <!-- 检查 Extra_Deduction_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <thead>
                        <tr>
                            <td style="width: auto; border: none;"></td> <!-- 因為不知道該如何分配比例、超過100%，所以這格宽度自动决定 -->
                            <td style="width: 60%;  text-align: center; vertical-align: middle; border: none;">
                                加項項目
                            </td>
                            <td style="width: 30%;  text-align: center; vertical-align: middle; border: none;">
                                加項金額（新台幣）
                            </td>
                            <td style="width: 10%;  text-align: center; vertical-align: middle; border: none;">
                                刪除
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($Extra_Plus_inputs->slice(0, $Extra_Plus_inputs->count() - 1) as $Plus_Key => $Plus_Data)
                            <tr>
                                <td style="text-align: left; color: #333; border: none;">
                                    {{ $Plus_Key + 1 }}.）
                                </td>
                                <td style="color: #333; border: none;">
                                    <!-- wire:model.defer 这个指令用于延迟数据同步至组件的状态更新直到表单提交的时刻。 特别有用当处理包含大量数据输入字段的表单时，因为它减少了实时的数据绑定和更新，从而提高性能。。这意味着当用户在这个输入框中键入时，输入值不会立即同步更新到 Livewire 组件，更新只会在触发一些操作（如表单提交）时发生。-->
                                    <span style="display: flex; align-items: center;">
                                        <input type="text" class="form-control" style="display: inline-block; flex-grow: 1; margin-right: 5px; text-align: left;" wire:model.defer="Extra_Plus_inputs.{{ $Plus_Key }}.plus_note"> <!-- input 使用了 flex-grow: 1; 来确保它可以占据除了 label 之外的所有可用空间。 -->
                                        <label style="display: inline-block; flex-shrink: 0; text-align: center; align-items: center;">：</label> <!-- label 使用了 flex-shrink: 0; 来确保它不会在空间不足时被缩小。 -->
                                    </span>
                                </td>
                                <td style="color: #333; border: none;">
                                    <span style="display: flex; align-items: center;">
                                        <input type="number" class="form-control" style="display: inline-block; flex-grow: 1; margin-right: 5px; text-align: right;" min="0" step="1" wire:model.defer="Extra_Plus_inputs.{{ $Plus_Key }}.plus_amount"> <!-- 必須要為正整數，不得為負數。 -->
                                        <label style="display: inline-block; flex-shrink: 0; text-align: center; align-items: center;">元</label>
                                    </span>
                                </td>
                                <td style="text-align: right; border: none;">
                                    <button class="btn-primary" type="button" style="background-color: red; color: white;" onclick="confirm('您確定要刪除嗎？') || event.stopImmediatePropagation()" wire:click="delete( {{ $Plus_Data->id }} )" aria-label="刪除">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>                         
                    </table>
                    <p></p> <!-- 保留間隙 -->
                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" onclick="DisplayAlert_UpdateData()" wire:click="update_Plus()" aria-label="修改保存">修改並保存</button> 
                    </div>
                    <p></p> <!-- 保留間隙 -->
                @endif

                @if(count($Extra_Plus_inputs) <= 10) <!-- 2024/05/23 User說不會超過5列的加項。 --> 
                    <div style="margin-top: 15px; margin-bottom: 15px;"></div> <!-- 在上下创建间隙 -->
                    <div style="text-align: left; color: #333;">
                        〔使用者新增加項〕
                    </div>
                    <table style="width: 100%; border-collapse: collapse;  border: none;">
                        <thead>
                        <tr>
                            <th style="width: 70%;  text-align: center; vertical-align: middle;">
                                加項項目
                            </th>
                            <th style="width: 30%;  text-align: center; vertical-align: middle;">
                                加項金額（元）
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="text-align: left; color: #333;">
                                <input class="form-control" type="text"  style="border: none; box-shadow: none;" wire:model.defer="Extra_Plus_inputs.{{ $Plus_Key + 1 }}.plus_note" placeholder="請輸入加項項目">
                            </td>
                            <td style="text-align: left; color: #333;">
                                <input class="form-control" type="number"style="border: none; box-shadow: none; text-align: right;" wire:model.defer="Extra_Plus_inputs.{{ $Plus_Key + 1 }}.plus_amount" min="0" step="1" placeholder=0> <!-- 必須要為正整數，不得為負數。 -->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p style="text-align: right;"> ※加項金額只需輸入數字，無需再輸入單位（元）。 </p> <!-- 保留間隙 -->
                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" wire:click="addInput_Plus()" onclick="DisplayAlert_AddData()" aria-label="新增保存">新增並保存</button>
                    </div>
                    <p></p> <!-- 保留間隙 -->
                @endif

                <div style="width: 100%; height: 1px; background-color: black;"></div>  <!-- 細黑线 -->

                @php
                    $sum_PlusMoney_amount = $Extra_Plus_inputs->sum('plus_amount');
                @endphp

                <div style="margin-top: 10px; margin-bottom: 10px;"></div> <!-- 在上下创建间隙 -->
                <div  class="flex justify-end text-right mr-5" style="font-size: 1.25rem;">
                    總計加項金額：NT$ {{ number_format($sum_PlusMoney_amount, 0, '.', ',') }} 
                </div>
                <p style="text-align: right;">※ 四捨五入至整數。</p> <!-- 保留間隙 -->
            </td>
            
            <td style="text-align: center;">
                臭胸
            </td>
            <td style="text-align: center;">
                {{ $total_stinking_chest }}%
            </td>
        </tr>
<!-- // 加項金額 // -->

<!-- // 總計應付金額 // -->
        <tr>
            <td> 
                <p style="text-align: center;">應</p>
                <p style="text-align: center;">付</p>
                <p style="text-align: center;">金</p>
                <p style="text-align: center;">額</p>
            </td>
            <td> 

                @php
                    $account_payment = $total_loan - $sum_deduction_amount + $sum_PlusMoney_amount;
                @endphp

                <div  class="flex items-center justify-end text-right text-lg mr-5 text-3xl">
                    實際應付款：NT$ {{ number_format($account_payment, 0, '.', ',') }} 
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;"></div> <!-- 在上下创建间隙 -->
                <p style="text-align: right;">※ 四捨五入至整數。</p> <!-- 保留間隙 -->
            </td>

            <td style="text-align: center;">皮膚炎</td>
            <td style="text-align: center;">{{ $total_dermatitis }}%</td>
        </tr>
<!-- // 總計應付金額 // -->
        </tbody>
    </table>

    <table style="width:100%">
        <tr>
            <td style="width: 2%;">
                <p style="text-align: center;">說</p>
                <p style="text-align: center;">明</p>
            </td>
            <td style="width: 98%;">
                <p>1.付款條件：產銷履歷牧場手續費退{{ $settlementData->price_of_newspaper-$settlementData->unit_price }}元/斤</p>
                <!-- @for($i = 0; $i < count($deductions); $i++)
                    <p>{{$i+2}}.臭爪扣款：第
                    @foreach($numbers[$i] as $index => $number)
                        {{ $number }}
                        @if($index < count($numbers[$i]) - 1)
                            {{ ',' }}
                        @endif
                    @endforeach
                    台，{{ $deductions[$i] }}，{{$deductions_absorb[$i]}}</p>

                    
                @endfor -->
                @php
                    $Note_Key = 0;
                @endphp
                
                <br>
                <div style="text-align: left; color: #333; font-size: 16px;">
                    〔其它說明事項〕
                </div>
                <table style="border: 1px solid #ccc; width: 100%;">
                    <tbody>
                        @forelse ($Extra_Note_inputs->slice(0, $Extra_Note_inputs->count() - 1) as $Note_Key => $Note_Data)
                            <tr style="text-align: left; color: #333; font-size: 16px;">
                                <td style="width: 30px;">{{ $Note_Key + 1 }}</td>
                                <td style="width: auto;">  <!--  /* 让第二列尽可能占满剩余空间 */ -->
                                    <!-- wire:model.defer 这个指令用于延迟数据同步至组件的状态更新直到表单提交的时刻。 特别有用当处理包含大量数据输入字段的表单时，因为它减少了实时的数据绑定和更新，从而提高性能。。这意味着当用户在这个输入框中键入时，输入值不会立即同步更新到 Livewire 组件，更新只会在触发一些操作（如表单提交）时发生。-->
                                    <input type="text" wire:model.defer="Extra_Note_inputs.{{ $Note_Key }}.other_note" class="form-control">                                 
                                </td>
                                <td style="text-align: right; width: 80px;">
                                    <button class="btn-primary" type="button" style="background-color: red; color: white;" onclick="confirm('您確定要刪除嗎？') || event.stopImmediatePropagation()" wire:click="delete( {{ $Note_Data->id }} )">刪除</button>
                                </td>
                            </tr>
                        @empty
                            <div style="font-style: italic;">NULL</div>
                        @endforelse                               
                    </tbody>
                </table>
                <p></p>
                @if($Extra_Note_inputs && $Extra_Note_inputs->count() - 1 > 0) <!-- 检查 Extra_Note_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                <div class="flex justify-between">
                    <button class="btn-primary" type="button" onclick="DisplayAlert_UpdateData()" wire:click="update_OtherNotes()" aria-label="修改保存">修改並保存</button>
                </div>
                @endif
                
                @if(count($Extra_Note_inputs) < 25) <!-- 當初User說好不超過20列的，談好是20列，每列可放100個字。 >< --> 
                    <br>
                    <div style="text-align: left; color: #333; font-size: 16px;">
                        〔使用者新增說明事項〕
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: left; color: #333; font-size: 16px;">
                                    <input class="form-control" type="text" placeholder="请输入說明事項" wire:model.defer="Extra_Note_inputs.{{ $Note_Key  + 1 }}.other_note" >
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <p></p>
                    <div class="flex justify-between">
                        <button class="btn-primary" type="button" onclick="DisplayAlert_AddData()" wire:click="addInput_OtherNotes()" aria-label="新增保存">新增並保存</button>
                    </div>
                @endif

            </td>
        </tr>
    </table>
    @endif
    
    <br>
    <div class="flex justify-end">
        <button class="btn-primary" type="button"  style="background-color: red; color: white;" onclick="confirm('您确定要清空数据库吗？操作将无法恢复哦~') || event.stopImmediatePropagation()" wire:click="clear_DB_Settlement()"> 清空数据库 </button> <!-- 測試用，請刪除 -->
    </div>

</body>
</html>

<script type="text/javascript">
    function DisplayAlert_AddData() { alert("新增資料！") }
    function DisplayAlert_UpdateData() { alert("修改資料！") }
</script>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">