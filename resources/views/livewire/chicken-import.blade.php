<form action="#" wire:submit.prevent="submit">
    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center">飼養入雛表</h2>
    </div>
    <div class=" @if (Auth::user()->permissions[1] < 3) cant_edit_permission @endif" style="overflow:auto;">
        {{-- 如果沒有資料就進入飼養紀錄表就跳警告 --}}
        @if ($errors->has('alert'))
            <script>
                alert("{{ $errors->first('alert') }}");
            </script>
        @elseif ($errors->has('same_import'))
            <script>
                alert("{{ $errors->first('same_import') }}");
            </script>
        @endif
        {{-- 查詢列 --}}
        <table>
            <tr>
                <td>
                    {{-- &nbsp是空格 --}}
                    <p>起始日期&nbsp;&nbsp;</p>
                </td>
                <td>
                    <input class="form-control" type="date" wire:model.lazy="select_start_date">
                </td>
                <td>
                    <p>&nbsp;&nbsp;至&nbsp;&nbsp;</p>
                </td>
                <td>
                    <p>結束日期&nbsp;&nbsp;</p>
                </td>
                <td>
                    <input class="form-control" type="date" wire:model.lazy="select_end_date">
                </td>
                <td>
                    &nbsp;&nbsp;
                    <button class="btn btn-primary" type="button" wire:click="search()">搜尋</button>
                </td>
            </tr>
        </table>

        <table class="max-w-full table-fixed">
            <tbody>
                <!-- <button class="btn btn-primary" type="button" wire:click="fake()">產生假資料</button> -->

                <tr>
                    <td colspan="12">
                        <hr class="my-5">
                        <table class="table-fixed">
                            <thead>
                                <tr>
                                    <td style="width:8%">批號</td>
                                    <td style="width:8%">日期</td>
                                    <td style="width:8%">雞種</td>
                                    <td style="width:8%">入雛數量</td>
                                    <td style="width:8%">贈送數量</td>
                                    <td style="width:8%">總數</td>
                                    <td style="width:8%">實際數量</td>
                                    <td style="width:6%">單價(元/羽)</td>
                                    <td style="width:6%">包裝(箱)</td>
                                    <td style="width:8%">平均雛雞重(g)</td>
                                    <td style="width:8%">實磅平均雛雞重(g)</td>
                                    <td style="width:8%">總重(kg)</td>
                                    <td style="width:8%">總價</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inputs as $key => $input)
                                    @php
                                        $can_edit = false;
                                        $only_create_can_edit = false;
                                        //判斷建立日期是否為今天或為空值
                                        if (isset($input['new_data'])) {
                                            $can_edit = true;
                                            $only_create_can_edit = true;
                                        }
                                        elseif (\Carbon\Carbon::parse($input['created_at'])->isToday()){
                                            $can_edit = true;
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="relative flex items-center">
                                                    <div class="text-sm">
                                                        {{-- <input class="form-control" type="text"
                                                            wire:model.lazy="inputs.{{ $key }}.id"
                                                            style=" @if (isset($input->id) && isset($input->building_number)) pointer-events: none; color: #676565; @endif"> --}}
                                                        <input class="form-control" type="text"
                                                            wire:model.lazy="inputs.{{ $key }}.id"
                                                            @if (!$only_create_can_edit) disabled @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center h-5 align-middle">
                                                <input class="form-control" type="date"
                                                    wire:model.lazy="inputs.{{ $key }}.date"
                                                    @if (!$can_edit) disabled @endif
                                                    required>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control"
                                                wire:model.lazy="inputs.{{ $key }}.species"
                                                @if (!$can_edit) disabled @endif
                                                required>
                                                {{-- <select class="form-control" id="species" type="text" placeholder="雞種" required> --}}
                                                <option value="AA" selected>AA</option>
                                                <option value="ROSS">ROSS</option>
                                                <option value="COBB">COBB</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.quantity" min="0"
                                                step="1"
                                                @if (!$can_edit) disabled @endif
                                                required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.gift_quantity"
                                                min="0" step="1" placeholder="0"
                                                @if (!$can_edit) disabled @endif
                                                required>
                                        </td>
                                        <td>
                                            <!-- 總數量 -->
                                            @php
                                                if (isset($inputs[$key]['quantity']) && isset($inputs[$key]['gift_quantity'])) {
                                                    $total_num = intval($inputs[$key]['quantity'] + $inputs[$key]['gift_quantity']);
                                                } else {
                                                    $total_num = 0;
                                                }
                                            @endphp
                                            <input class="form-control" type="number" min="0" step="1"
                                                disabled="disable" value="{{ $total_num }}">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.actual_quantity"
                                                min="0" step="1" required placeholder="{{ $total_num }}">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.price" min="0"
                                                step="0.01">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.package" min="0"
                                                step="1">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.avg_weight" min="0"
                                                step="0.01">
                                        </td>
                                        <td>
                                            <input class="form-control" type="number"
                                                wire:model.lazy="inputs.{{ $key }}.actual_avg_weight"
                                                min="0" step="0.01">
                                        </td>
                                        <td>
                                            <!-- 總重量 -->
                                            @php
                                                if (isset($inputs[$key]['avg_weight'])) {
                                                    $total_weight = round(($total_num * $inputs[$key]['avg_weight']) / 1000, 2);
                                                } else {
                                                    $total_weight = 0;
                                                }
                                            @endphp
                                            <input class="form-control" type="number" disabled="disable"
                                                value="{{ $total_weight }}">
                                        </td>
                                        <td>
                                            @php
                                                if (isset($inputs[$key]['quantity']) && isset($inputs[$key]['price'])) {
                                                    $sum = intval($inputs[$key]['quantity'] * $inputs[$key]['price']);
                                                } else {
                                                    $sum = 0;
                                                }
                                            @endphp
                                            <input class="form-control" type="number" disabled="disable"
                                                value="{{ $sum }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:8%">地址</td>
                                        <td colspan="4">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="inputs.{{ $key }}.address"
                                                style="font-size: 15px;">
                                        </td>
                                        <td class="pl-8"></td>
                                        <td style="width:4%">棟舍號碼</td>
                                        <td colspan="1">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="inputs.{{ $key }}.building_number" required
                                                @if (!$only_create_can_edit) disabled @endif>
                                        </td>
                                        {{-- <td class="pl-8"></td> --}}
                                        <td style="width:4%">雛雞來源</td>
                                        <td colspan="2">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="inputs.{{ $key }}.chicken_origin">
                                        </td>
                                        <td colspan="5" style="text-align: right"
                                            class=" @if (Auth::user()->permissions[1] < 4) cant_delete_permission @endif">
                                            <button class="btn-primary"
                                                style="background-color: red; color: white; @if (Auth::user()->permissions[1] < 4) background-color: gray; @endif"
                                                type="button"
                                                onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $key }})">刪除</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <!-- 如果inputs.{{ $key }}.date和合約截止日期比較小於50天 顯示剩餘天數 -->
                                            @php
                                                if (isset($inputs[$key]['date']) && isset($contract->end_date)) {
                                                    $date_diff = intval((strtotime($contract->end_date) - strtotime($inputs[$key]['date'])) / 86400);
                                                } else {
                                                    $date_diff = 0;
                                                }
                                                if (isset($inputs[$key]['building_number']) && isset($inputs[$key]['m_KUNAG']) && isset($inputs[$key]['id'])) {
                                                    if ($date_diff < 50 && $date_diff > 0) {
                                                        $color = 'red';
                                                        echo '<font color="' . $color . '"><b>合約快要到期了，入雛日期距離到期日剩餘' . $date_diff . '天！！！</b></font>';
                                                    } elseif ($date_diff < 0) {
                                                        $color = 'gray';
                                                        echo '<font color="' . $color . '"><b>合約已過期' . $date_diff * -1 . '天！！！</b></font>';
                                                    }
                                                }

                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($photos)
            Photo Preview:
            <div style="display:flex">
                @foreach ($photos as $key => $photo)
                    <img src="{{ $photos[$key]->temporaryUrl() }}" width="400" height="400">
                @endforeach
            </div>
        @endif
        <div class="flex justify-between">
            <button class="btn-primary" type="button" wire:click="addInput()">+</button>
            <div>
                {{-- <button class="btn-primary" type="update" wire:click="saveData">更新</button> --}}
                <button class="btn-primary" type="submit">保存</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    window.addEventListener('save-successful', event => {
        alert(event.detail.message);
    });
</script>

<style>
    .cant_edit_permission {
        pointer-events: none;
        color: #000;
    }

    .cant_delete_permission {
        pointer-events: none;
        color: #676565;
    }

    .form-control {
        /* 固定顯示10個字元 */
        min-width: 115px;
    }
</style>
