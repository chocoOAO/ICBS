<head>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.3/dist/bootstrap-table.min.css">
</head>
<div>
    <table>
        <tr>
            <td>
                日期：<select class="form-select" aria-label="Default select example" wire:model="select_day"
                    wire:change="selectDay" style="margin-bottom: 20px">
                    <option value="0">全部</option>
                    <option value="7">一個禮拜</option>
                    <option value="14">兩個禮拜</option>
                    <option value="21">三個禮拜</option>
                    <option value="31">一個月</option>
                </select>
            </td>
            <td>
                重量：<select class="form-select" aria-label="Default select example" wire:model="select_weight"
                    wire:change="selectWeight" style="margin-bottom: 20px">
                    <option value="0">全部</option>
                    <option value="18">18公斤</option>
                    <option value="19">19公斤</option>
                    <option value="20">20公斤</option>
                    <option value="21">21公斤</option>
                </select>
            </td>
            {{-- <td>
                入雛日期：<select class="form-select" aria-label="Default select example" wire:model="select_import_day"
                    wire:change="selectImportDay" style="margin-bottom: 20px">
                    <option value="0">全部</option>
                    <option value="7">一個禮拜</option>
                    <option value="14">兩個禮拜</option>
                    <option value="21">三個禮拜</option>
                    <option value="31">一個月</option>
                </select>
            </td>
            <td>
                未來預估重量：<select class="form-select" aria-label="Default select example" wire:model="select_future_weight"
                    wire:change="selectFutureWeight" style="margin-bottom: 20px">
                    <option value="0">全部</option>
                    <option value="18">18公斤</option>
                    <option value="19">19公斤</option>
                    <option value="20">20公斤</option>
                    <option value="21">21公斤</option>
                </select>
            </td> --}}
        </tr>
    </table>
</div>

<div class="bg-white divide-y divide-gray-200">
    <table class="table table-striped table-hover table-bordered">
        {{-- 場區、最新飼養週期、毛雞重、增重、存活隻數、室內溫度 --}}
        <tr>
            <th data-sortable="true">
                場區
            </th>
            <th colspan="3" data-sortable="true">
                最新飼養週期
            </th>
            <th data-sortable="true">
                毛雞重
            </th>
            <th data-sortable="true">
                平均重
            </th>
            <th data-sortable="true">
                存活隻數
            </th>
            <th data-sortable="true">
                室內溫度
            </th>
        </tr>
        @foreach ($data as $key => $valuse)
            @php
                $start = strtotime('now');
                $end = strtotime($valuse->slaughter);
                $diff = $end - $start;
                $days = floor($diff / (60 * 60 * 24));
                if ($days < 0 || $valuse->avg_weight < $select_weight) {
                    continue;
                }
                if ($select_day == 0) {
                    $select_day = floor((strtotime($max_day) - $start) / (60 * 60 * 24));
                }
                $width = (($select_day + 0.1 - $days) * 100) / $select_day;

                $this->survivor = $valuse->amount;
                //把disuse的減掉
                foreach ($this->breeding_data as $key => $value) {
                    if ($value->chicken_import_id == $valuse->id) {
                        $this->survivor -= $value->disuse;
                    }
                }
                //dd($this->survivor);
                //dd(floor((strtotime($max_day) - $start)/ (60 * 60 * 24)));
            @endphp
            @if ($select_day != 0 && $days > $select_day)
                @continue
            @endif
            <tr>
                <td>
                    {{ $valuse->title }}
                </td>
                <td>
                    {{ $valuse->date }}
                </td>
                <td style="width: 33%">
                    <div>
                        {{-- <div style="position: absolute; top: 20%; right: 0px;">
                            剩餘{{ $days }}天
                        </div> --}}
                        <div class="progress"
                            style="height: 40px; margin-bottom: 20px; width: 90%; background-color: #ddd;  position: relative;">

                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $width }}%; background-color: #4caf50; position: relative;"
                                aria-valuenow="{{ $days }}" aria-valuemin="0"
                                aria-valuemax="{{ $days }}}">

                            </div>
                            <p style="position: absolute; top: 20%; left: 45%;">
                                剩餘{{ $days }}天
                            </p>

                        </div>
                    </div>
                </td>
                <td>
                    {{ $valuse->slaughter }}
                </td>
                <td>
                    {{ $valuse->total_weight }}
                </td>
                <td>
                    {{ $valuse->avg_weight }}
                </td>
                <td>
                    {{ $this->survivor }}
                </td>
                <td>
                    -18℃
                </td>
            </tr>
        @endforeach
    </table>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.3/dist/bootstrap-table.min.js"></script>
</div>

{{-- css --}}
<style>
    .table-hover tbody tr:hover td {
        background: rgba(229, 231, 82, 0.993);
    }
</style>

{{-- js --}}
