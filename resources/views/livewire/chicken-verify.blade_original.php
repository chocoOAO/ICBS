<form action="#" wire:submit.prevent="submit">
    @php
    // 宣告
    $quantity = 0;
    $disuse = 0;
    $price = 0;
    $totalSum = 0;
    @endphp
    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
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
                                <td style="width:9%">贈送%</td>
                                <td style="width:7%">淘汰</td>
                                <td style="width:9%">一週死亡</td>
                                <td style="width:9%">單價</td>
                                <td style="width:9%">手續費</td>
                                <td style="width:9%">金額</td>
                                <td style="width:9%">備註</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($inputs as $key => $input)
                            @php
                            // isset() 函数用于检测变量是否已设置并且非 NULL。
                            // 入雛收量 and 單價 and 淘汰數都不為null時，計算總價。
                            if (isset($inputs[$key]['quantity']) && isset($inputs[$key]['price']) &&
                            isset($inputs[$key]['disuse']) && isset($inputs[$key]['fee'])) {
                            // 字串轉整數
                            // 驗收單列金額 = ((入雛收量 - 淘汰數) * 單價) * 手續費
                            $fee = doubleval($inputs[$key]['fee'] / 100 + 1);
                            $sum = intval(($inputs[$key]['quantity'] - $inputs[$key]['disuse']) * $inputs[$key]['price']
                            * $fee);

                            $price = intval($inputs[$key]['price']);

                            // 初始化
                            $quantity = 0; // 入雛收量
                            $disuse = 0; // 淘汰數
                            $totalSum = 0; // 驗收單總金額

                            // 計算
                            for ($i = 0; $i < $key + 1; $i++) { $disuse=intval($inputs[$i]['disuse']); $quantity=intval($inputs[$i]['quantity']) + $quantity; $totalSum=$totalSum + $sum; } } else { $sum=0; $price=0; $quantity=0; $disuse=0; } @endphp <tr>
                                {{-- 項目 --}}
                                {{-- <td> --}}
                                <input class="form-control" type="hidden" wire:model.lazy="inputs.{{ $key }}.id">
                                {{-- 這裡暫時用id --}}
                                {{-- <input class="form-control" type="date"
                                        wire:model.lazy="inputs.{{ $key }}.item"> --}}

                                {{-- <input class="form-control" type="text" id="dummy"> --}}
                                {{-- </td> --}}

                                {{-- 客戶姓名 --}}
                                <td>
                                    <input class="form-control" type="text" wire:model.lazy="inputs.{{ $key }}.customer_id" placeholder="王大明">
                                </td>

                                {{-- 入雛時間 --}}
                                <td>
                                    <div class="flex items-center h-5 align-middle">
                                        <input class="form-control" type="date" wire:model.lazy="inputs.{{ $key }}.date">
                                    </div>
                                </td>

                                {{-- 入雛收量 --}}
                                <td>
                                    <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.quantity" placeholder="34500" min="0">
                                </td>

                                {{-- 贈送2% --}}
                                <td>
                                    {{-- <input class="form-control" type="number"
                                        wire:model.lazy="inputs.{{ $key }}.gift" placeholder="690"> --}}
                                    <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.gift" placeholder="2%" min="0">
                                    {{-- {{$inputs[$key]['quantity']}} --}}
                                    {{-- {{$input[$key]}} --}}

                                </td>

                                {{-- 淘汰 --}}
                                <td>
                                    <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.disuse" placeholder="0" min="0">
                                </td>

                                {{-- 週死 --}}
                                <td>
                                    <input class="form-control" type="number" wire:model="inputs.{{ $key }}.death_quantity" placeholder="512" min="0">
                                </td>
                                {{-- 單價 --}}
                                <td>
                                    <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.price" placeholder="31" min="0" step="0.01">
                                </td>
                                {{-- 手續費 %數 --}}
                                <td>
                                    <input class="form-control" type="number" wire:model.lazy="inputs.{{ $key }}.fee" placeholder="9%" min="0">
                                </td>
                                {{-- 金額  --}}
                                <td>
                                    {{-- ToDo：如果單價每個都不一樣 會有問題 --}}


                                    <input class="form-control" type="number" disabled="disable" value="{{ $sum }}">
                                </td>
                                {{-- 備註 --}}
                                <td>
                                    {{-- <input class="form-control" type="text"
                                        wire:model.lazy="inputs.{{ $key }}.memo" placeholder="契養"> --}}
                                    <span></span>
                                </td>

                                <td>
                                    {{-- @isset($input->id)
                                            <button style="background-color: red; color: white;" type="button"
                                                onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $input->id }})">刪除
                                    </button>
                                    @endisset --}}
                                    @if (isset($input->id))
                                    <button class="btn-primary" style="background-color: red; color: white;" type="button" onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()" wire:click="delete({{ $input->id }})">刪除</button>
                                    @else
                                    <button class="btn-primary" style="background-color: red; color: white;" type="button" disabled>刪除</button>
                                    @endif
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
                    {{ round($totalSum * 0.91) }} 元
                </td>
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
                    {{ round($totalSum * 0.93) }} 元
                </td>
                {{-- 單價 * 總收量 * 0.93  --}}
                </td>

                </td>
            </tr>
        </div>

    </table>

    <table class="max-w-full table-fixed">
        <hr class="my-5">
        <tr>
            <td>
                總經理
            </td>
            <td>
                陳冠臻001
            </td>
            <td>
                副總
            </td>
            <td>
                陳冠臻002
            </td>
        </tr>
        <tr>
            <td>
                協理
            </td>
            <td>
                陳冠臻003
            </td>
            <td>
                經理
            </td>
            <td>
                陳冠臻004
            </td>
        </tr>
        <tr>
            <td>
                課長
            </td>
            <td>
                陳冠臻005
            </td>
            <td>
                業務人員
            </td>
            <td>
                陳冠臻006
            </td>
        </tr>

    </table>
    <table class="max-w-full table-fixed">
        <hr class="my-5">

        <tr>
            <td>
                客戶簽收
            </td>

            <td>
                {{-- 點按鈕後 開新視窗 提供電子簽名 簽完按下確認 儲存簽名檔案  --}}
                <button class="btn-primary" type="button" wire:click="$toggle('isShow')">電子簽名</button>

                <button id="download">下載簽名</button>

                <canvas id="canvas" width="600" height="400"></canvas>


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
                <script>
                    // init canvas element
                    var canvas = document.getElementById('canvas')
                    var ctx = canvas.getContext("2d")

                    // 抗鋸齒
                    // ref: https://www.zhihu.com/question/37698502
                    let width = canvas.width,
                        height = canvas.height;
                    if (window.devicePixelRatio) {
                        canvas.style.width = width + "px";
                        canvas.style.height = height + "px";
                        canvas.height = height * window.devicePixelRatio;
                        canvas.width = width * window.devicePixelRatio;
                        ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
                    }

                    // mouse
                    function getMousePos(canvas, evt) {
                        var rect = canvas.getBoundingClientRect();
                        return {
                            x: evt.clientX - rect.left,
                            y: evt.clientY - rect.top
                        };
                    }

                    function mouseMove(evt) {
                        var mousePos = getMousePos(canvas, evt);
                        ctx.lineCap = "round";
                        ctx.lineWidth = 2;
                        ctx.lineJoin = "round";
                        ctx.shadowBlur = 1; // 邊緣模糊，防止直線邊緣出現鋸齒
                        ctx.shadowColor = 'black'; // 邊緣顏色
                        ctx.lineTo(mousePos.x, mousePos.y);
                        ctx.stroke();
                    }

                    canvas.addEventListener('mousedown', function(evt) {
                        var mousePos = getMousePos(canvas, evt);
                        ctx.beginPath();
                        ctx.moveTo(mousePos.x, mousePos.y);
                        evt.preventDefault();
                        canvas.addEventListener('mousemove', mouseMove, false);
                    });

                    canvas.addEventListener('mouseup', function() {
                        canvas.removeEventListener('mousemove', mouseMove, false);
                    }, false);

                    // touch
                    function getTouchPos(canvas, evt) {
                        var rect = canvas.getBoundingClientRect();
                        return {
                            x: evt.touches[0].clientX - rect.left,
                            y: evt.touches[0].clientY - rect.top
                        };
                    }

                    function touchMove(evt) {
                        // console.log("touchmove")
                        var touchPos = getTouchPos(canvas, evt);
                        // console.log(touchPos.x, touchPos.y)

                        ctx.lineWidth = 2;
                        ctx.lineCap = "round"; // 繪制圓形的結束線帽
                        ctx.lineJoin = "round"; // 兩條線條交匯時，建立圓形邊角
                        ctx.shadowBlur = 1; // 邊緣模糊，防止直線邊緣出現鋸齒
                        ctx.shadowColor = 'black'; // 邊緣顏色
                        ctx.lineTo(touchPos.x, touchPos.y);
                        ctx.stroke();
                    }

                    canvas.addEventListener('touchstart', function(evt) {
                        // console.log('touchstart')
                        // console.log(evt)
                        var touchPos = getTouchPos(canvas, evt);
                        ctx.beginPath(touchPos.x, touchPos.y);
                        ctx.moveTo(touchPos.x, touchPos.y);
                        evt.preventDefault();
                        canvas.addEventListener('touchmove', touchMove, false);
                    });

                    canvas.addEventListener('touchend', function() {
                        // console.log("touchend")
                        canvas.removeEventListener('touchmove', touchMove, false);
                    }, false);

                    document.getElementById('download').addEventListener('click', function(e) {
                        // let canvasUrl = canvas.toDataURL("image/jpeg", 0.5);
                        let canvasUrl = canvas.toDataURL("image/png");
                        console.log(canvasUrl);
                        const createEl = document.createElement('a');
                        createEl.href = canvasUrl;
                        createEl.download = "signature.png";
                        createEl.click();
                        createEl.remove();
                    });
                </script>
            </td>
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