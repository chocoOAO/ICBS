<form action="#" wire:submit.prevent="submit">
    @php
        // 宣告
        $quantity = 0;
        $disuse = 0;
        $price = 0;
        $totalSum = 0;
    @endphp
    {{-- <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a> --}}
    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center">雛雞驗收單</h2>
    </div>

    <table class="max-w-full table-fixed">
        <tbody>
            <!-- <button class="btn btn-primary" type="button" wire:click="fake()">產生假資料</button> -->

            <tr>
                <td>
                    <font color="red">*</font>供應廠商
                </td>
                <td colspan="2">
                    <div>
                        <div class="relative flex items-center">

                            <div class="text-sm">
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="relative flex items-center">
                        <font color="red">*</font>驗收單編號
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="text">
                        </div>
                    </div>
                </td>

                <td>

                    <div>
                        <div class="relative flex items-center">
                            <font color="red">*</font>
                            <div class="flex items-center h-5 align-middle">
                                驗收日期
                            </div>
                            <div class="ml-3 text-sm">
                                <input class="form-control" type="date">

                                {{-- <input class="form-control" type="date" wire:model.lazy="data.end_date" required> --}}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="10">
                    <hr class="my-5">
                    <table class="table-fixed">
                        <thead>
                            <tr>
                                {{-- <td style="width:9%">項目</td> --}}
                                <td style="width:9%">客戶姓名</td>
                                <td style="width:9%">入雛時間</td>
                                <td style="width:9%">入雛收量</td>
                                <td style="width:7%">贈送%</td>
                                <td style="width:7%">一週淘汰</td>
                                {{-- <td style="width:9%">一週死亡</td> --}}
                                <td style="width:7%">單價</td>
                                <td style="width:9%">手續費</td>
                                <td style="width:9%">金額</td>
                                <td style="width:20%">備註</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($inputs as $key => $input)
                                @php
                                    // isset() 函数用于检测变量是否已设置并且非 NULL。
                                    // 入雛收量 and 單價 and 淘汰數都不為null時，計算總價。
                                    if (isset($inputs[$key]['quantity']) && isset($inputs[$key]['price']) && isset($inputs[$key]['disuse']) && isset($inputs[$key]['fee'])) {
                                        // 字串轉整數
                                        // 驗收單列金額 = ((入雛收量 - 淘汰數) * 單價) * 手續費
                                        $fee = doubleval($inputs[$key]['fee'] / 100 + 1);
                                        $sum = intval(($inputs[$key]['quantity'] - $inputs[$key]['disuse']) * $inputs[$key]['price'] * $fee);

                                        $price = intval($inputs[$key]['price']);

                                        // 初始化
                                        $quantity = 0; // 入雛收量
                                        $disuse = 0; // 淘汰數
                                        $totalSum = 0; // 驗收單總金額

                                        // 計算
                                        for ($i = 0; $i < $key + 1; $i++) {
                                            $disuse = intval($inputs[$i]['disuse']);
                                            $quantity = intval($inputs[$i]['quantity']) + $quantity;
                                            $totalSum = $totalSum + $sum;
                                        }
                                    } else {
                                        $sum = 0;
                                        $price = 0;
                                        $quantity = 0;
                                        $disuse = 0;
                                    }
                                @endphp

                                <tr>
                                    {{-- 項目 --}}
                                    {{-- <td> --}}
                                    <input class="form-control" type="hidden"
                                        wire:model.lazy="inputs.{{ $key }}.id">
                                    {{-- 這裡暫時用id --}}
                                    {{-- <input class="form-control" type="date"
                                        wire:model.lazy="inputs.{{ $key }}.item"> --}}

                                    {{-- <input class="form-control" type="text" id="dummy"> --}}
                                    {{-- </td> --}}

                                    {{-- 客戶姓名 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.customer_name"
                                            placeholder="王大明">
                                        {{-- {{ $inputs[$key]['customer_name'] }} --}}



                                    </td>

                                    {{-- 入雛時間 --}}
                                    <td>
                                        <div class="flex items-center h-5 align-middle">
                                            <input class="form-control" type="date"
                                                wire:model.lazy="inputs.{{ $key }}.date">
                                        </div>
                                    </td>

                                    {{-- 入雛收量 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.quantity" placeholder="34500"
                                            min="0">
                                    </td>

                                    {{-- 贈送2% --}}
                                    <td>
                                        {{-- <input class="form-control" type="text"
                                        wire:model.lazy="inputs.{{ $key }}.gift" placeholder="690"> --}}
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.gift" placeholder="2%"
                                            min="0">
                                        {{-- {{$inputs[$key]['quantity']}} --}}
                                        {{-- {{$input[$key]}}  --}}

                                    </td>

                                    {{-- 淘汰 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.disuse" placeholder="0"
                                            min="0">
                                    </td>

                                    {{-- 週死 --}}
                                    {{-- <td>
                                        <input class="form-control" type="text"
                                            wire:model="inputs.{{ $key }}.death_quantity" placeholder="512"
                                            min="0">
                                    </td> --}}
                                    {{-- 單價 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.price" placeholder="31"
                                            min="0" step="0.01">
                                    </td>
                                    {{-- 手續費 %數 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.fee" placeholder="9%"
                                            min="0">
                                    </td>
                                    {{-- 金額  --}}
                                    <td>
                                        {{-- ToDo：如果單價每個都不一樣 會有問題 --}}


                                        <input class="form-control" type="text" disabled="disable"
                                            value="{{ $sum }}">
                                    </td>
                                    {{-- 備註 --}}
                                    <td>
                                        <input class="form-control" type="text"
                                            wire:model.lazy="inputs.{{ $key }}.memo1" placeholder="測試">
                                        <span></span>
                                    </td>

                                    <td>
                                        {{-- @isset($input->id)
                                            <button style="background-color: red; color: white;" type="button"
                                                onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $input->id }})">刪除
                                            </button>
                                        @endisset --}}
                                            <button class="btn-primary" style="background-color: red; color: white;"
                                                type="button"
                                                onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $key }})">刪除</button>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-between">
        <button class="btn-primary" type="button" wire:click="addInput()">+</button>
        {{-- <button class="btn-primary" type="submit">保存</button> --}}
    </div>
    <table class="max-w-full table-fixed">
        <style>
            canvas {
                background: #eee;
            }

            #test {
                img {
                    display: block;
                    width: 300px;
                    height: 200px;
                }
            }
        </style>
        <hr class="my-5">
        <div>
            <tr>
                <td>
                    <span>雛雞款：</span>
                <td>{{ $quantity }}羽 - {{ $disuse }}羽 = {{ $quantity - $disuse }} 羽</td>
                </td>
            </tr>

            <tr>
                <td>
                    <span>公司款：</span>
                </td>

                {{-- 單價 * 總收量 * 0.91  --}}
                <td> {{ $price }} 元/羽 x {{ $quantity - $disuse }} 羽 * 0.91% =
                    {{ round($totalSum * 0.91) }} 元</td>
                </td>
                {{-- <tr>
                        <td>
                            <span>dd</span>
                        </td>
                    </tr> --}}
            </tr>
            <tr>
                <td>
                    <span>客戶款：</span>

                <td> {{ $price }} 元/羽 x {{ $quantity - $disuse }} 羽 * 0.93% =
                    {{ round($totalSum * 0.93) }} 元</td>
                {{-- 單價 * 總收量 * 0.93  --}}
                </td>

                </td>
            </tr>
        </div>

    </table>

    <table class="equal-width-table" style="width:100% ; border: 2px solid black;    padding: .4rem;">
        <style>
            .td_border {
                border: 1px solid #ccc;
                padding: .4rem;
            }

            .equal-width-table {
                table-layout: fixed;
                width: 100%;
            }

            .equal-width-table td {
                width: auto;
            }
        </style>
        <tr>
            <td class="td_border">總經理</td>
            <td class="td_border"></td>
            <td class="td_border">副總經理</td>
            <td class="td_border"></td>
            <td class="td_border">毛雞契養處</td>
            <td class="td_border"></td>
            <td class="td_border">協理</td>
            <td class="td_border"></td>
        </tr>
        <tr>

            <td class="td_border">經理</td>
            <td class="td_border"></td>
            <td class="td_border">課長</td>
            <td class="td_border"></td>
            <td class="td_border">業務人員</td>
            <td class="td_border"></td>
            <td class="td_border">牧場人員</td>
            <td class="td_border"></td>
        </tr>
    </table>



    <div class="flex justify-end">
        <button class="btn-primary" type="submit" onclick="display_alert()">保存</button>
    </div>


</form>

<script type="text/javascript">
    function display_alert() {
        // alert("保存成功！")
    }
</script>
