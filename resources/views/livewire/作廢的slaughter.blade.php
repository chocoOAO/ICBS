

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> --}}
    <div class="bg-white divide-y divide-gray-200">
        <table data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true"
            data-search="true" data-show-search-clear-button="true" data-show-refresh="true" data-show-toggle="true"
            data-show-columns="true" data-show-columns-toggle-all="true">
            <thead>
                {{-- 場區、最新飼養週期、毛雞重、增重、存活隻數、室內溫度 --}}
                <tr>
                    <th data-field="title" data-sortable="true">場區</th>
                    <th data-field="import" data-sortable="true">入雛日期</th>
                    <th data-field="date" data-sortable="true">最新飼養週期</th>
                    <th data-field="export" data-sortable="true">預估日期</th>
                    <th data-field="total_weight" data-sortable="true">毛雞重</th>
                    <th data-field="avg_weight" data-sortable="true">平均重</th>
                    <th data-field="survivor" data-sortable="true">存活隻數</th>
                    <th data-field="temperature" data-sortable="true">室內溫度</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $valuse)
                    @php
                        $valuse = (object) $valuse;
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
                        <td>
                            <div>
                                {{-- <div style="position: absolute; top: 20%; right: 0px;">
                            剩餘{{ $days }}天
                        </div> --}}
                                <div class="progress"
                                    style="height: 40px; width: 90%; background-color: #ddd;  position: relative;">

                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $width }}%; background-color: #4caf50; position: relative;"
                                        aria-valuenow="{{ $days }}" aria-valuemin="0"
                                        aria-valuemax="{{ $days }}}">

                                    </div>
                                    <p style="position: absolute; top: 30%; left: 30%;">
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
    </div>


<style>
    .table-hover tbody tr:hover td {
        background: rgba(235, 236, 163, 0.993);
    }

</style>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
