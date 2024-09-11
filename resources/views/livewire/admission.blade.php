<a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>
<div class="my-2 py-5 border-gray-200">
    <h2 class="text-xl text-gray-800 leading-tight text-center"></h2>
</div>

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

            </tr>
        </thead>
    </table>

    <table class="max-w-full table-fixed container">
        <thead class="tableTrace">
            <tr>
                <td class="tdTrace">
                    入場批號
                </td>
                <td>
                    <a href="#" style="color: blue"> {{ '50068721006' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    本廠管理號碼
                </td>
                <td>
                    <input class="form-control" type="text" value="28">

                </td>
            </tr>

            <tr>
                <td class="tdTrace">
                    履歷品項
                </td>
                <td>
                    {{ '白肉雞' }}
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    品種名稱
                </td>
                <td>
                    <select>
                        <option>請選擇品種</option>
                        <option selected>哈巴ROSS</option>
                        <option>哈巴ROSS</option>
                        <option>哈巴ROSS</option>
                        <option>哈巴ROSS</option>
                        <option>哈巴ROSS</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    禽舍名稱
                </td>
                <td>
                    <!-- 這裡是選單 -->
                    <select>
                        <option>請選擇</option>
                        <option>臺北科技大學</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    入場日期
                </td>
                <td>
                    <input class="form-control" type="date" value="2021-06-01">
                </td>
            </tr>

            <tr>
                <td class="tdTrace">
                    本批進禽日齡
                </td>
                <td>
                    <div style="display:flex">
                        <input class="form-control" type="number" value="0">
                        <div style="margin: auto">(日)</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    本批進禽隻數
                </td>
                <td>
                    <div style="display:flex">
                        <input class="form-control" type="number" value="94860">
                        <div style="margin: auto">(隻)</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    剩餘隻數
                </td>
                <td>
                    {{ '94860' }}(隻)
                </td>
            </tr>
            <tr>
                <td class="tdTrace">
                    備註
                </td>
                <td>
                    <textarea></textarea>
                </td>

            </tr>
        </thead>
        <tbody>



        </tbody>
    </table>
</div>
