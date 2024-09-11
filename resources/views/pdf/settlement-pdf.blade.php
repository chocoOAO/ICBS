<style>
    table,
    td {
        border: 1px solid #ccc;
        padding: .4rem;
        font-family: "NotoSansTC-VariableFont_wght";

    }

    table {
        border: 2px solid black;
        padding: .4rem;

    }

    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght"
    }

    .table-container{
        page-break-inside: avoid ;
    }

    /* 设置特定的类来避免分页 */
    .no-page-break {
        page-break-inside: avoid !important; 

    }
    .grade-display {
        text-align: center;
        vertical-align: middle;
        font-size: 5em;
        font-weight: normal; /* 书法字体通常不需要加粗 */
        font-family: 'Great Vibes', cursive;
        page-break-inside: avoid ;
        }
</style>

@php
    use App\Models\Contract;
    use App\Models\ChickenImport;
    $data2['chicken_imports'] = ChickenImport::where('contract_id', $data2['contract_id'])->get();
    $data2['m_NAME'] = Contract::where('id', $data2['contract_id'])->first()->m_NAME;
@endphp

@php
    $Selected_AccountNumber = $data2['Selected_AccountNumber']
@endphp

@foreach ($Selected_AccountNumber as $key => $account_number)

<table class="max-w-full table-fixed" style="width:100%">
    <tbody>
        <tr>
            <td>
                帳款單號：
            </td>
            <td>
                {{ $account_number }}
            </td>
            <td>
                過磅日期：<!-- 帳款日期：  -->
            </td>
            <td>
                {{ $data2['weighing_date'] }}
            </td>
            <td>
                廠商：
            </td>
            <td colspan="3">
                {{ $data2['m_NAME'] }}
            </td>
            <td>
                飼主：
            </td>
            <td >
                {{ $data2['breeder'] }}
            </td>
        </tr>
        <tr>
            <td>
                畜牧場：
            </td>
            <td>
                {{ $data2['livestock_farm_name'] }}
            </td>
            <td>
                地點：
            </td>
            <td>
                {{ $data2['address'] }}
            </td>
            <td>
                報紙價：
            </td>
            <td>
                {{ $data2['price_of_newspaper'] }}
            </td>
            <td>
                手續費：
            </td>
            <td>
                {{ $data2['fee'] }}
            </td>
        </tr>
    </tbody>
</table>



<table class="max-w-full table-fixed " style="width:100% ">
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

    @foreach ($data2['settlementData2'] as $key => $input)
            <tr style="border:2px ">
                <!-- 批號 -->
                <td colspan="2">
                    {{ $input["number"] }}
                </td>
                <!-- 公斤重 -->
                <td colspan="2">
                    {{ $input["kilogram_weight"] }}
                </td>
                <!-- 台斤重 -->
                <td colspan="2">
                    {{ number_format($input["catty_weight"],2) }}
                </td>
                <!-- 單價 -->
                <td colspan="2">
                    {{ $input["unit_price"] }}
                </td>
                <!-- 羽數 -->
                <td colspan="2">
                    {{ $input["total_of_birds"] }}
                </td>
                <!-- 平均重 -->
                <td colspan="2">
                    {{ $input["average_weight"] }}
                </td>
                <!-- 下雞 -->
                <td colspan="2">
                    {{ $input["down_chicken"] }}
                </td>
                <!-- 死雞 -->
                <td colspan="2">
                    {{ $input["death"] }}
                </td>
                <!-- 剔除雞 -->
                <td colspan="2">
                    {{ $input["discard"] }}

                </td>
                <td colspan="2">
                    {{ $input["stinking_claw"] }}
                </td>
                <!-- 臭胸% -->
                <td colspan="2">
                    {{ $input["stinking_chest"] }}
                </td>

                <!-- 皮膚癌% -->
                <td colspan="2">
                    {{ $input["dermatitis"] }}
                </td>

                <!-- 飼料殘留% -->
                <td colspan="2">
                    {{ $input["residue"] }}
                </td>

                <!-- 貸款金額 -->
                <td colspan="2">
                    {{ number_format($input["catty_weight"] * $input["unit_price"]) }}
                </td>
            </tr>
            @endforeach

    
</table>


<table style="width:100%">
    <tr>
        <td style="text-align: center;" colspan="2" rowspan="2">小計</td>
        <!-- 公斤重Total -->
        <td style="text-align: center;">總公斤</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_weight'] }} </td>
        <!-- 台斤重Total -->
        <td style="text-align: center;">總台斤</td>
        <td style="text-align: center;" colspan="2">{{$data2['total_catty_weight'] }}</td>
        <!-- 總羽數Total -->
        <td style="text-align: center;">總羽數</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_amount'] }}</td>
        <!-- 均重Total -->
        <td style="text-align: center;">平均數</td>
        <td style="text-align: center;">{{ number_format($data2['total_avg_weight'],2) }}</td>

    </tr>
    <tr>
        <!-- 下雞Total -->
        <td style="text-align: center;">總下雞數</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_down_chicken'] }}</td>
        <!-- 死雞Total -->
        <td style="text-align: center;">總死雞數</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_death_chicken'] }}</td>
        <!-- 剔除雞Total -->
        <td style="text-align: center;">總剔除數</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_abandoned_weight'] }}</td>
        <!-- 總貸款Total -->
        <td style="text-align: center;">總貸款</td>
        <td style="text-align: center;" colspan="2">{{ $data2['total_loan'] }}</td>

    </tr>
    </tr>

</table>
<table class="no-page-break" style="width:100%">
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
        <tr >
            <td > <!-- 因為不知道該如何分配比例、超過100%，所以這格宽度自动决定 -->
                    <p style="text-align: center;">扣</p>
                    <p style="text-align: center;">除</p>
                    <p style="text-align: center;">金</p>
                    <p style="text-align: center;">額</p>
            </td>
            <td rowspan="1" style="width: 70%;">
                    <div style="text-align: left; color: #333; font-size: 18px;">
                        〔基本扣款項目〕
                    </div>
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                            <td style="width: 70%; text-align: left; vertical-align: middle; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第一個單元格佔70% -->
                                扣款項目
                            </td>
                            <td style="width: 30%; text-align: right; vertical-align: middle; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第二個單元格佔30% -->
                                扣款金额（新台幣）
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 70%; text-align: left; color: #333; font-size: 16px; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第一個單元格佔70% -->
                                1.剔除雞扣款：{{ $data2['eliminate_chicken_deductions'] }}元
                            </td>
                            <td style="width: 30%; text-align: right; color: #333; font-size: 16px; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第二個單元格佔30% -->
                                NT$ {{ number_format($data2['eliminate_chicken_deductions'], 0, '.', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; font-size: 16px; border: none;">
                                2.死雞扣款：{{ $data2['dead_chickens_deductions'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['dead_chickens_deductions'], 0, '.', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; font-size: 16px; border: none;">
                                3.臭爪扣款：{{ $data2['stinky_claw_deduction'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['stinky_claw_deduction'], 0, '.', ',') }} 
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; font-size: 16px; border: none;">
                                4.毛雞車越縣補助：{{ $data2['maoji_car_subsidies'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['maoji_car_subsidies'], 0, '.', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; font-size: 16px; border: none;">
                                5.超大雞扣款：{{ $data2['extra_large_chicken'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['extra_large_chicken'], 0, '.', ',') }} 
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left; color: #333; border: none;">
                                6.皮膚炎扣款：{{ $data2['stinky_dermatitis'] }}元
                            </td>
                            <td style="text-align: right; color: #333; border: none;">  
                                NT$ {{ number_format($data2['stinky_dermatitis'], 0, '.', ',') }} 
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; border: none;">
                                7.臭胸扣款：{{ $data2['stinky_stinking_chest'] }}元
                            </td>
                            <td style="text-align: right; color: #333; border: none;">  
                                NT$ {{ number_format($data2['stinky_stinking_chest'], 0, '.', ',') }} 
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left; color: #333; border: none;">
                                8.雛雞折扣：{{ $data2['chick_discount'] }}元
                            </td>
                            <td style="text-align: right; color: #333; border: none;">  
                                NT$ {{ number_format($data2['chick_discount'], 0, '.', ',') }} 
                            </td>
                        </tr>

                        <tr> <td colspan="2" style="border-top: 1px dashed #ccc; border-bottom: none; padding: 0;"></td> </tr>
                        <tr>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;"> <!-- 通過使用百分比來指定各自佔據的寬度：第一個單元格佔70% -->
                                小計扣款金額：{{ $data2['eliminate_chicken_deductions']+$data2['dead_chickens_deductions']+$data2['stinky_claw_deduction']+$data2['extra_large_chicken']+ $data2['stinky_dermatitis'] + $data2['stinky_stinking_chest'] + $data2['chick_discount'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['eliminate_chicken_deductions']+$data2['dead_chickens_deductions']+$data2['stinky_claw_deduction']+$data2['extra_large_chicken']+ $data2['stinky_dermatitis'] + $data2['stinky_stinking_chest'] + $data2['chick_discount'], 0, '.', ',') }} 
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                小計補助金額：{{ $data2['maoji_car_subsidies'] }}元
                            </td>
                            <td style="text-align: right; color: #333; font-size: 16px; border: none;">  
                                NT$ {{ number_format($data2['maoji_car_subsidies'], 0, '.', ',') }}
                            </td>
                        </tr>
                        <!-- 插入虛線分隔行 -->
                        <tr> <td colspan="2" style="border-top: 1px dashed #ccc; border-bottom: none; padding: 0;"></td> </tr>
                    </table>
                    <div style="text-align: left; color: #333; font-size: 18px;">
                        〔其它额外扣款金額〕
                    </div>
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        @unless($data2['Extra_Deduction_inputs'] && count($data2['Extra_Deduction_inputs']) - 1 > 0)
                            <tr>
                                <td style="width: 70%; text-align: left; vertical-align: middle; color: #333; font-size: 16px; border: none;"> NULL，沒有多個扣款輸入。</td>
                            </tr>
                        @endunless

                        @foreach ($data2['Extra_Deduction_inputs'] as $index => $deduction)
                            @if ($index < count($data2['Extra_Deduction_inputs']) - 1) <!-- 不處理最後一個元素 -->
                                <tr>
                                    <td style="width: 70%; text-align: left; vertical-align: middle; color: #333; font-size: 16px; border: none;">
                                        {{ $index + 1 }}. {{ $deduction['deduction_note'] }}：{{ $deduction['user_deduction_amount'] }}元
                                    </td>
                                    <td style="width: 30%; text-align: right; vertical-align: middle; color: #333; font-size: 16px; border: none;">
                                        NT$ {{ number_format($deduction['user_deduction_amount'], 0, '.', ',') }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    <div style="width: 100%; height: 2px; background-color: black;"></div>  <!-- 粗黑线 -->

                    @php
                    $amounts = array_column($data2['Extra_Deduction_inputs'], 'user_deduction_amount');
                    $total = array_sum($amounts);
                        $sum_deduction_amount = array_sum([
                            $data2['eliminate_chicken_deductions'],
                            $data2['dead_chickens_deductions'],
                            $data2['stinky_claw_deduction'],
                            $data2['extra_large_chicken'],
                            $data2['maoji_car_subsidies'],
                            $total,
                            $data2['stinky_dermatitis'],
                            $data2['stinky_stinking_chest'],
                            $data2['chick_discount']
                        ]);
                    @endphp
                    
                    <br>
                    <div  style="text-align: right; font-size: 30px;">
                        總計扣款金額：NT$ {{ number_format($sum_deduction_amount, 0, '.', ',') }} 
                    </div>
                    <p style="text-align: right;">※四舍五入至整數位。</p> <!-- 保留間隙 -->    
                    
            </td> 
            <td class="grade-display" >
                    <h3>{{ $data2['grade'] }}</h3>
            </td>
            
            <td style="width: 10%; text-align: center;">臭爪</td>
            <td style="width: 8%; text-align: center;">{{ $data2['total_stinking_claw'] }}%</td>
        </tr>
        <tr>
            <td> 
                <p style="text-align: center;">加</p>
                <p style="text-align: center;">項</p>
                <p style="text-align: center;">金</p>
                <p style="text-align: center;">額</p>
            </td>
            <td style="vertical-align: top;">

                <div style="text-align: left; color: #333;">
                    〔加項項目與金額〕
                </div>
                <table class="max-w-full table-fixed" style="width: 100%; border-collapse: collapse; border: none;">
                    @unless($data2['Extra_Plus_inputs'] && $data2['Extra_Plus_inputs']->count() - 1 > 0) <!-- 检查 Extra_Deduction_inputs 是否存在并且其中的元素数量大于零，但最後一筆是保留給新增資料使用。 --> 
                        <p style="font-style: italic;">NULL，尚未輸入任何額外加項項目。</p>
                    @endunless
                    @foreach ($data2['Extra_Plus_inputs'] as $index => $deduction)
                        @if ($index < count($data2['Extra_Plus_inputs']) - 1 ) <!-- 不處理最後一個元素 -->
                            <tr>
                                <td style="width: 70%; text-align: left; vertical-align: middle; color: #333; font-size: 16px; border: none;">
                                    {{ $index + 1 }}. {{ $deduction['plus_note'] }}：{{ $deduction['plus_amount'] }}元
                                </td>
                                <td style="width: 30%; text-align: right; vertical-align: middle; color: #333; font-size: 16px; border: none;">
                                    NT$ {{ number_format($deduction['plus_amount'], 0, '.', ',') }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                <div style="width: 100%; height: 1px; background-color: black;"></div>  <!-- 細黑线 -->

                @php
                    $sum_PlusMoney_amount = $data2['Extra_Plus_inputs']->sum('plus_amount');
                @endphp

                <div style="margin-top: 10px; margin-bottom: 10px;"></div> <!-- 在上下创建间隙 -->
                <div  style="text-align: right; font-size: 30px;">
                    總計加項金額：NT$ {{ number_format($sum_PlusMoney_amount, 0, '.', ',') }} 
                </div>
                <p style="text-align: right;">※ 四捨五入至整數。</p> <!-- 保留間隙 -->
            </td>
            <td class="grade-display" >
                    
            </td>
            <td style="text-align: center;">臭胸</td>
            <td style="text-align: center;">{{ $data2['total_stinking_chest'] }}%</td>
            
        </tr>

        <tr>
            <td> 
                <p style="text-align: center;">應</p>
                <p style="text-align: center;">付</p>
                <p style="text-align: center;">金</p>
                <p style="text-align: center;">額</p>
            </td>
            <td> 

                @php
                    $account_payment = $data2['total_loan'] - $sum_deduction_amount + $sum_PlusMoney_amount;
                @endphp

                <div style="text-align: right; font-size: 30px;">
                    實際應付款：NT$ {{ number_format($account_payment, 0, '.', ',') }} 
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;"></div> <!-- 在上下创建间隙 -->
                <p style="text-align: right;">※ 四捨五入至整數。</p> <!-- 保留間隙 -->
            </td>
            <td class="grade-display" >
                    
            </td>
            <td style="text-align: center;">皮膚炎</td>
            <td style="text-align: center;">{{ $data2['total_dermatitis'] }}%</td>
        </tr>
    </tbody>
</table>
<table style="width:100%">
    <tr>
        <td>說明</td>
        <td colspan="10">
            <p>1.付款條件：產銷履歷牧場手續費退{{ $data2['fee'] }}元/斤</p>
            @for($i = 0; $i < count($data2['deductions']); $i++)
                    <p>{{$i+2}}.臭爪扣款：第
                    @foreach($data2['numbers'][$i] as $index => $number)
                        {{ $number }}
                        @if($index < count($data2['numbers'][$i]) - 1)
                            {{ ',' }}
                        @endif
                    @endforeach
                    台，{{ $data2['deductions'][$i] }}，{{$data2['deductions_absorb'][$i]}}</p>               
                @endfor
            <div style="text-align: left; color: #333; font-size: 16px;">
                〔其它說明事項〕
            </div>
            <table style="width: 100%; border-collapse: collapse; border: none;">
                @unless($data2['Extra_Note_inputs'] && count($data2['Extra_Note_inputs']) - 1 > 0)
                    <tr>
                        <td style="width: 70%; text-align: left; vertical-align: middle; color: #333; font-size: 16px; border: none;"> NULL</td>
                    </tr>
                @endunless
                @foreach ($data2['Extra_Note_inputs'] as $index => $Add_description)
                    @if ($index < count($data2['Extra_Note_inputs']) - 1) <!-- 不處理最後一個元素 -->
                        <tr>
                            <td style="width: 70%; text-align: left; vertical-align: middle; color: #333; font-size: 16px; border: none;">
                                {{ $index + 1 }}. {{ $Add_description['other_note'] }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </td>
    </tr>
    
</table>
@if ($account_number  !== end($Selected_AccountNumber))
    <!-- 分頁 -->
    <div class="page-break"></div>
@endif

@endforeach