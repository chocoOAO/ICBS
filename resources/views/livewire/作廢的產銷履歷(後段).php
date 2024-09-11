<a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
<div class="my-2 py-5 border-gray-200">
    <h2 class="text-xl text-gray-800 leading-tight text-center">{{ '測試者001號' }}合約 {{ '001' }} 批號－產銷履歷</h2>
</div>
{{-- <p>產品名稱:</p>
<p>產品經營業者：</p>
<p>簡稱：</p>
<p>生產者姓名：</p>
<p>入雛日期</p>
<p>驗收日期</p>
<p>入屠日期</p>
<p>屠宰日期</p>
<p>出貨日期</p>
<p>產品經營業者地址：</p> --}}
<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tdTrace {
        background: #eafbbf
    }

    td {
        border: 1px solid #cccccc;

    }

    .tableTrace {
        border: 1px solid #cccccc;
    }
</style>

<div>
    <table class="max-w-full table-fixed container">
        <thead>
            <tr>
                <td>
                    <img src="https://www.newsmarket.com.tw/files/2016/01/10614172_647863435331800_4716133114694615234_n.jpg"
                        alt="chicken" width="300" height="250">
                </td>
                <td>
                    {{-- {{ 'QRCode' }} --}}
                    <img src="http://s05.calm9.com/qrcode/2023-02/XLY4I5M8ZH.png" alt="chickenQRCode" width="200"
                        height="200">
                </td>
            </tr>
        </thead>
    </table>

    <table class="max-w-full table-fixed container">
        <thead class="tableTrace">

            <tr>
                <td class="tdTrace">
                    產品名稱：
                </td>
                <td>
                    {{ '白肉雞' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    產品經營業者：
                </td>
                <td>
                    {{ '北科大' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    雞種：
                </td>
                <td>
                    {{ '白肉雞' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    批號：
                </td>
                <td>
                    {{ '白肉雞' }}
                </td>
            </tr>
            {{-- 細項資料 --}}
            {{-- ToDo：Button With Show/Closed or 彈跳視窗 --}}
            {{-- <div>
                <tr>
                    <td class="tdTrace">
                        日齡：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        疫苗/藥品/消毒：
                    </td>
                    <td>
                        {{ '狂雞症' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        總淘汰數：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        使用飼料：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        飼料料種：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        總飼料量：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        育成率：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        均重：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        飼效：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        生產指數：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdTrace">
                        重效差：
                    </td>
                    <td>
                        {{ '白肉雞' }}
                    </td>
                </tr>
            </div> --}}

            <tr>
                <td class="tdTrace">
                    生產者姓名：
                </td>
                <td>
                    {{ '王大臻' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    入雛日期：
                </td>
                <td>
                    {{ '2023-02-22' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    驗收日期：
                </td>
                <td>
                    {{ '2023-02-27' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    入屠日期：
                </td>
                <td>
                    {{ '2023-03-20' }}
                </td>
            </tr>
            {{-- <tr>
                <td class="tdTrace">
                    屠宰日期：
                </td>
                <td>
                    {{ '2023-03-21' }}
                </td>
            </tr> --}}
            <tr>
                <td class="tdTrace">
                    出貨日期：
                </td>
                <td>
                    {{ '2023-03-26' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    產品經營業者地址：
                </td>
                <td>
                    {{ '臺北市大安區新生南路一段1號' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    雞隻出貨商：
                </td>
                <td>
                    {{ '好吃雞肉養雞場' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    雞隻出貨來源地址：
                </td>
                <td>
                    {{ '臺北市大安區忠孝東路1號' }}
                </td>
            </tr>

            <hr>
            {{-- 雞種
            雛雞來源
            批號
            總日齡
            疫苗
            藥品
            消毒
            總淘汰數
            使用飼料
            料種 總飼料量

            育成率 均種 飼效
            生產指數
            重效差 --}}


            <tr>
                <td class="tdTrace">
                    牧場
                </td>
                <td>
                    {{ '臺北市大安區忠孝東路1號' }}
                </td>
            </tr>

        </thead>
        <tbody>



        </tbody>
    </table>
</div>
