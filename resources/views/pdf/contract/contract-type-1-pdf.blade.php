<!DOCTYPE html>
<style>
    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght";
    }

    .table-fixed {
        width: 100%;
    }

    .form-control {
        display: block;
        flex: 1;
        border-radius: 0.375rem;
        border-color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(79, 139, 255, 0.5);
        font-size: 0.875rem;
        width: 100%;
        font-family: "NotoSansTC-VariableFont_wght";
        pointer-events: none;
        color: #000;
    }
</style>
<html>

@php
    use App\Models\Contract;
    use App\Models\ContractDetail;
    $data['inputs'] = Contract::where('id', $data['contract'])->get();
    // dd($data['inputs']->toArray(), $data['contract_details']);
@endphp

<div class="my-2 py-5 border-gray-200">
    <h2 class="text-xl text-gray-800 leading-tight text-center font-zh">白肉雞合作飼養合約書</h2>
</div>

<table class="max-w-full table-fixed font-zh">
    <tbody>
        <tr>
            <td>
                <font color="red">*</font>立書合約人
            </td>
            <td colspan="2">
                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            甲方
                        </div>
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="text" value={{ $data['inputs'][0]['m_NAME'] }}
                                id="A">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            乙方
                        </div>
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="text"
                                value={{ $data['inputs'][0]['name_b'] . $data['inputs'][0]['m_KUNAG'] }}>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <font color="red">*</font>本合約有效時間
            </td>
            <td>
                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            開始日期
                        </div>
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="text" value={{ $data['inputs'][0]['begin_date'] }}>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            結束日期
                        </div>
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="text" value={{ $data['inputs'][0]['end_date'] }}>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>約定入雛羽數
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="order_quantity"
                    value={{ $data['contract_details']['order_quantity'] }}>
            </td>
            <td colspan="2">
                <font color="red">*</font>
                <font color="orange">約定入雛羽數合約期間內若甲方對於合約內容或條件有變動時，甲方得終止本合約。</font>
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>飼養地址
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="adress"
                    value={{ $data['contract_details']['address'] }}>
            </td>
            <td colspan="2" rowspan="3">
                <p>
                    <font color="red">*</font>上述地點若為租用，乙方需提供雞舍及土地租賃契約書或土地使用權同意書。
                </p>
                @if ($data['contract_details']['type'] == 2)
                    <p>
                        <font color="red">*</font>乙方不得於上述地點或周圍飼養非經甲方同意之家禽。
                    </p>
                @endif

                @if ($data['contract_details']['type'] == 3)
                    <p>
                        <font color="red">*</font>
                        <font color="blue">乙方不得將上述地點之外之飼養家禽，非經甲方同意不得出售於指定電宰廠。</font>
                    </p>
                @endif
            </td>
        <tr>
            <td>
                飼養地段及飼號
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="feed_area"
                    value={{ $data['contract_details']['feed_area'] }}>
                <input class="form-control" type="text" id="feed_number"
                    value={{ $data['contract_details']['feed_number'] }}>
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>飼養面積
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="area" value={{ $data['contract_details']['area'] }}
                    min="0">
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <font color="red">*</font>飼養雞舍棟數
                </p>
            </td>
            <td colspan="4">
                <table class="table-fixed">
                    <tr>
                        <td>棟</td>
                        <td>飼養量</td>
                        <!--
                        <td>棟</td>
                        <td>飼養量</td>
                        <td>棟</td>
                        <td>飼養量</td>
                        -->
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control" type="text" id="building_name1"
                                value={{ $data['contract_details']['building_name1'] }}>
                        </td>
                        <td>
                            <input class="form-control" type="text" id="feed_amount1"
                                value={{ $data['contract_details']['feed_amount1'] }}>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>同意飼養隻數(每批)
            </td>
            <td colspan="0">
                <input class="form-control" type="text" id="per_batch_chick_amount"
                    value={{ $data['contract_details']['per_batch_chick_amount'] }}>
            </td>
        </tr>
        <tr class="border-b">
            <td colspan="5">
                {{-- 新增/修改過的合約內容暫時以藍字顯示 --}}
                {{-- 新舊不一的內容暫時以橘字顯示 --}}
                @if ($data['contract_details']['type'] == 2)
                    <p>
                        <font color="red">*</font>
                        <font color="blue">依本合約約定飼養之雞隻，除甲方同意外，應全數交回甲方處理，或由甲方指定之屠宰場逕與乙方締結新合約，乙方無權處分。</font>
                    </p>
                    <p>
                        <font color="red">*</font>
                        <font color="blue">乙方同意於合約期間，由甲方提供入雛相關事宜，入雛日期由甲方安排。雛雞由甲方提供，費用由甲方支付，購買雛雞之折扣歸甲方所有。</font>
                    </p>
                    <p>
                        <font color="red">*</font>
                        <font color="blue">乙方同意提供並支付雞舍設備、飼養勞務與管理及一切相關之開支。</font>
                    </p>
                    <p>
                        <font color="red">*</font>為達合作飼養之目的，乙方同意自行提供疫苗、藥品、人工、設備及什支等費用。
                    </p>
                    <p>
                        <font color="red">*</font>乙方應遵守完全使用甲方提供『福壽牌』飼料之約定。
                    </p>
                @endif
                @if ($data['contract_details']['type'] == 3)
                    <font color="red">*</font>飼料議定單價(
                    <input class="form-control inline-block w-auto" type="date"
                        value={{ $data['contract_details']['feeding_price_date'] }}>報價，散裝價)：肉雞一號每公斤
                    <input class="form-control inline-block w-20" type="text"
                        value={{ $data['contract_details']['chicken_n1_feeding_price'] }}>元，肉雞二號每公斤
                    <input class="form-control inline-block w-20" type="text"
                        value={{ $data['contract_details']['chicken_n2_feeding_price'] }}>元，肉雞三號每公斤
                    <input class="form-control inline-block w-20" type="text"
                        value={{ $data['contract_details']['chicken_n3_feeding_price'] }}>元，雛雞計價
                    <input class="form-control inline-block w-20" type="text"
                        value={{ $data['contract_details']['chicken_price'] }}>元/羽
                    <p>
                        <font color="red">*</font>
                        <font color="blue">乙方同意於契約期間內使用甲方所提供之飼料，不得購用其他廠牌飼料，飼料價格另訂之。</font>
                    </p>
                    <p>
                        <font color="red">*</font>
                        <font color="blue">
                            合作飼養之雞隻，雙方同意由甲方指定之電宰廠全數收買，並由乙方開立農漁民收據予電宰廠。乙方同意由甲方向電宰廠收取雞隻款，扣除合約所載應扣款項後餘額再交付乙方。</font>
                    </p>
                    <p>
                        <font color="red">*</font>
                        <font color="blue">契約期間單價依本公司初次交易為報價基準，並依市場行情變動而隨時調整。</font>
                    </p>
                @endif
                @if ($data['contract_details']['type'] == 1)
                    <p>
                        <font color="red">*</font>袋裝料每公斤加
                        <input class="form-control inline-block w-20" type="text"
                            value={{ $data['contract_details']['feeding_each_kg_plus_price'] }}>元。
                    </p>
                @endif
                @if ($data['contract_details']['type'] == 2)
                    <p>
                        <font color="red">*</font>不退料獎金新台幣參仟元整，剩料由乙方自行處理。
                    </p>
                    <p>
                        <font color="red">*</font>所合作飼養之雞隻應全數繳回甲方，乙方無權處分。
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center pt-5" colspan="2">
                <font color="red">*</font>金融機構、郵局名稱及分行名稱
            </td>
            <td class="text-center pt-5" colspan="2">
                <font color="red">*</font>金融帳號 (附存摺影本)
            </td>

            <td class="text-center pt-5">
                <font color="red">*</font>月支酬勞
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="grid grid-flow-col auto-cols-max w-full">
                    <div>
                        <div class="mt-1">
                            <input class="form-control w-full" type="text"
                                value={{ $data['inputs'][0]['bank_name'] }}>
                        </div>
                    </div>
                    <div>
                        <div class="mt-1">
                            <input class="form-control w-full" type="text"
                                value={{ $data['inputs'][0]['bank_branch'] }}>
                        </div>
                    </div>
                </div>
            </td>
            <td colspan="2">
                <input class="form-control" type="text" value={{ $data['inputs'][0]['bank_account'] }}>
            </td>
            <td>
                <input class="form-control" type="text" value={{ $data['inputs'][0]['salary'] }}>
            </td>
        </tr>
        <tr>
            {{-- 只有契養有這幾條 藍色為新增 --}}
            @if ($data['contract_details']['type'] == 3)
                <td colspan="5">
                    <p>
                        <font color="red">*</font>
                        乙方須提供存摺影本予甲方，若非乙方本人存摺須另簽訂匯款同意書以便甲方付款使用。甲方於電宰廠抓雞作業完成後於十五日工作天內，依電宰廠之結算款項扣除飼料款後，餘額匯款入乙方指定之帳號。
                    </p>
                    <p>
                        <font color="red">*</font>若電宰廠之結算款項不足支付飼料款時，乙方應開立足額支票或現款支付甲方。
                    </p>
                    <p>
                        <font color="red">*</font>扣除不良雞隻扣款作業標準所列情形與剔除雞以外者，上車補貼每羽新台幣<input
                            class="form-control inline-block w-20" type="text"
                            value={{ $data['contract_details']['each_chicken_car_price'] }} min="0">元
                    </p>
                    <p>
                        <font color="red">*</font>抓雞工資由乙方負責支付。
                    </p>
                    <p>
                        <font color="red">*</font>
                        <font color="blue">本合約如有訴訟時，雙方同意以台灣台中地方法院為第一審管轄法院。</font>
                    </p>
                </td>
            @endif
        </tr>
        <tr>
            <td>
                <font color="red">*</font>連絡電話<br>（請擇一填寫）
            </td>
            <td colspan="4">

                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">公司</span>
                    <input type="text" id="office_tel" value={{ $data['inputs'][0]['office_tel'] }}
                        class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                </div>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">住家</span>
                    <input type="text" id="home_tel" value={{ $data['inputs'][0]['home_tel'] }}
                        class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                </div>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">手機</span>
                    <input type="text" id="mobile_tel" value={{ $data['inputs'][0]['mobile_tel'] }}
                        class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="w-full mt-5 font-zh">
    <tbody>
        {{-- 代養/契養word合約沒看到這部分，用灰色顯示 --}}
        <tr class="border-b">
            <td>一、雙方約定事項如下：</td>
        </tr>
        <tr>
            <td>
                <ol class="list-decimal ml-5" style="margin-left:3%;">
                    <font color="gray">
                        <li>甲方提供育成毛雞由乙方處理屠宰及出售事宜，乙方所需毛雞時間、數量，由雙方議定排定之。</li>
                        <li>甲方提供毛雞需經藥殘檢驗合格。</li>
                        <li>毛雞規格為1.80～2.25公斤為原則，2.251～2.30公斤以下扣0.6元(若經協商大雞屠宰需求，則不在此列扣款)，2.3公斤以上扣0.9元，於入雛日後26～30天磅雞後，由雙方議定抓雞日期；若市場特殊需求得經雙方同意調整規格。
                        </li>
                        <li>毛雞每斤計價方式：依出雞當日聯合報，中華民國養雞協會肉雞產地交易行情表1.75～2.2公斤毛雞之北、中、嘉南、高屏區電宰之報價結算：毛雞均重達1.90公斤(含以上)以新台幣2.3元/斤(手續費)計價，毛雞均重達1.90公斤(以下)以新台幣2.0元/斤(手續費)計價，產銷履歷場以新台幣-0.3元/斤(手續費)計價。
                        </li>
                        <li>異常扣款依『台灣區電動屠宰同業公會』業界規則及附件所示112年洽富公司扣款項目處理之。</li>
                        <li>甲方運費補貼乙方：</li>
                        <ol type="a">
                            <li>a. 台中市、彰化縣、南投縣、苗栗縣為基準不予補貼(南投埔里、魚池、仁愛等每車次補貼油費新台幣參百元/車)，每超越一縣補貼油費新台幣伍佰元/車以此類推。</li>
                            <li>b. 未經乙方許可，空車折返補貼新台幣肆千元/車。</li>
                        </ol>
                        <li>雛雞折扣回饋：甲方由種雞場雛雞回饋金額中，依實際電宰時存量提出每羽1元金額回饋給乙方(時價除外)，雛雞價低於20元/羽時依價格5%計算。</li>
                        <li>由富祥種雞場提供雛雞時，依實際入雛羽數提出每羽1元回饋金時，則回饋予乙方。</li>
                        <li>其他未盡事宜則依『台灣區電動屠宰同業公會』及業界規則處理之。</li>
                    </font>
                </ol>
            </td>
        </tr>
        <tr>
        <tr class="border-b">
            <td>二、價金結算方式：</td>
        </tr>
        <tr>
            <td>
                <ol class="list-decimal ml-5" style="margin-left:3%;">
                    <li>每批交貨完畢後，乙方一週內應提供結算清單，供甲方核對。甲方核對無誤後開立請款憑證供乙方為付款依據。</li>
                    <li>乙方需於抓雞結束後，月結90日匯款予甲方。</li>
                </ol>
            </td>
        </tr>
        <tr class="border-b">
            <td>三、本契約一式二份，於雙方蓋章後生效並各執一份為憑。</td>
        </tr>
    </tbody>
</table>

<br>

<table class="w-full table-border font-zh">
    <tbody>
        <tr>
            <td>
                <h2 class="text-xl text-gray-800 leading-tight text-center">保價契養合約書計價</h2>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td class="text-center" style="width:18%;">
                                電宰收購
                            </td>
                            <td>
                                <table class="text-center">
                                    <tbody>
                                        <tr>
                                            <td style="width:20%;">毛雞規格(KG)</td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_1_1'] }}
                                                    type="text" placeholder="1.75"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_1_2'] }}
                                                    type="text" placeholder="1.89">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_2_1'] }}
                                                    type="text" placeholder="1.90"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_2_2'] }}
                                                    type="text" placeholder="1.99">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_3_1'] }}
                                                    type="text" placeholder="2.0"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_3_2'] }}
                                                    type="text" placeholder="2.10">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    value={{ $data['contract_details']['chicken_weight_kg_4_1'] }}
                                                    type="text" placeholder="2.11">以上
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%;" align="left">
                                                <p>收購價(新台幣/斤)</p>
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_weight_price1'] }}
                                                    type="text" placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_weight_price2'] }}
                                                    type="text" placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_weight_price3'] }}
                                                    type="text" placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_weight_price4'] }}
                                                    type="text" placeholder="27.3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%;" align="left">
                                                <p>規格補助(元/羽)</p>
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_allowance_price1'] }}
                                                    type="text" placeholder="2.0">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_allowance_price2'] }}
                                                    type="text" placeholder="1.0">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_allowance_price3'] }}
                                                    type="text" placeholder="0.5">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    value={{ $data['contract_details']['chicken_allowance_price4'] }}
                                                    type="text" placeholder="0.0">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <font color="red">*</font>大雞價高於
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_1'] }} type="text"
                                        style="width: 5%; text-align:center">
                                    時，採
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['dividend'] }} type="text"
                                        style="width: 5%; text-align:center">
                                    分紅獎勵。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    出雞重量
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_2'] }} type="text">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_2_1'] }} type="text">
                                    KG時，於飼養裝況正常情形，基於電宰廠屠宰需求而排定出售，且育成率需達96%以上，使補助規格雞。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    若發現乙方有盜賣毛雞圖利情事經查證屬實者，甲方得逕行認定該批育成率為96%，低於該育成率之差數以每羽新台幣
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_3'] }} type="text">
                                    元向乙方科處罰金元向乙方科處罰金。
                                </p>
                                <p>
                                    <font color="red">*</font>乙方同意於契約期間內使用甲方所提供之飼料，不得購用其他其他廠牌飼料。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    肉價：如出雞當日聯合報所載中華民國養雞協會肉雞產地交易行情表
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_4_1'] }}type="text">
                                    公斤至
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['contract1_unamed_4_2'] }} type="text">
                                    公斤隻平均報價【（北部＋中部＋嘉南）除３】。
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <font color="red">*</font>不良雞隻扣款作業標準：
                                </p>
                                <p style="margin-left:1%;">一、電宰業毛雞標準體重需求：</p>
                                <input class="form-control inline-block w-14 text-center"
                                    value={{ $data['contract_details']['debit_price_1_1'] }} type="text"
                                    placeholder="1.75">
                                〜
                                <input class="form-control inline-block w-14 text-center"
                                    value={{ $data['contract_details']['debit_price_1_2'] }} type="text"
                                    placeholder="1.95">kg/隻。

                                <p style="margin-left:1%;">二、超大雞部份：</p>
                                <p style="margin-left:3%;">(1)、</p>
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['debit_price_2_1_1'] }} type="text"
                                        placeholder="2.30">
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_1_2" type="text" placeholder="2.20"> --}}
                                    kg以上(以進場批次均重，非單台車)，扣0.9元/斤。

                                <p style="margin-left:3%;">(2)、</p>
                                    <input class="form-control inline-block w-14 text-center"
                                        value={{ $data['contract_details']['debit_price_2_2'] }} type="text"
                                        placeholder="2.251">
                                    kg以上上(以進場批次均重，非單台車)，扣0.6元/斤。
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_3" type="text" placeholder="議價">
                                    。 --}}

                                <p style="margin-left:1%;">三、超小雞部份：依不良雞作業標準。</p>
                                <p style="margin-left:1%;">四、臭爪部份：抽測
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_0_1" type="text"
                                        placeholder="20">%以下不扣款，
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_0_2" type="text"
                                        placeholder="20">%以上依照以下方式扣款: --}}
                                    20%以下不扣款，20%以上依照以下方式扣款：
                                </p>
                                <p style="margin-left:3%;">(1)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_1_1" type="text" placeholder="21">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_1_2" type="text" placeholder="30">
                                    %扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_1_3" type="text" placeholder="0.1">元/
                                    台斤。 --}}
                                    20 〜 29 %，不扣。
                                </p>
                                <p style="margin-left:3%;">(2)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_2_1" type="text" placeholder="31">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_2_2" type="text" placeholder="40">
                                    %扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_2_3" type="text"
                                        placeholder="0.2">元/台斤。 --}}
                                    30 〜 39 %，扣 0.1 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(3)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_3_1" type="text" placeholder="41">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_3_2" type="text" placeholder="50">
                                    %扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_3_3" type="text" placeholder="0.3">
                                    元/台斤。 --}}
                                    40 〜 49 %，扣 0.2 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(4)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_4_1" type="text" placeholder="51">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_4_2" type="text" placeholder="60">
                                    %扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_4_3" type="text"
                                        placeholder="0.4">元/台斤。 --}}
                                    50 〜 59 %，扣 0.3 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(5)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_5_1" type="text" placeholder="61">
                                    %以上 扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_4_5_2" type="text"
                                        placeholder="0.5">元/台斤。 --}}
                                    60 %以上 ，扣 0.3 元/台斤。
                                </p>
                                <p style="margin-left:1%;">五、臭胸部份：20%以下不扣款，20%以上依照以下方式扣款：
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_5_1" type="text"
                                        placeholder="10.15">%，依實際產出重量扣款。 --}}
                                </p>
                                <p style="margin-left:3%;">(1)、
                                    20 〜 29 %，扣 0.1 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(2)、
                                    30 〜 39 %，扣 0.2 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(3)、
                                    40 〜 49 %，扣 0.3 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(4)、
                                    50 〜 59 %，扣 0.4 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(5)、
                                    60 %以上，扣 0.5 元/台斤。
                                </p>
                                {{-- <p style="margin-left:3%;">臭胸總重ｘ胸皮產出率／
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_5_2" type="text"
                                        placeholder="0.6">ｘ單價＝扣款金額
                                    0.6 ｘ 單價＝扣款金額
                                </p>
                                <p style="margin-left:3%;">例：產出500kgx10.15%/0.6x19元=1607元</p> --}}
                                <p style="margin-left:1%;">
                                    六、飼料殘留：毛雞羽數ｘ抽測毛雞飼料殘留比率%ｘ每羽飼料殘留量(g)／1000g</p>
                                <p style="margin-left:3%;">例：3360
                                    隻*25%X50g/1000g=42kg</p>
                                <P style="margin-left:7%;">42kg/0.6x19元/斤=1330元</p>
                                {{-- --------------------------皮膚炎-------------------------- --}}
                                <p style="margin-left:1%;">七、皮膚炎(結痂)：抽測
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_0_1" type="text"
                                        placeholder="10">%以下不扣款，
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_0_2" type="text"
                                        placeholder="10">%以上依照以下方式扣款 --}}
                                    10%以下不扣款，10%以上依照以下方式扣款：
                                </p>
                                <p style="margin-left:3%;">(1)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_1_1" type="text" placeholder="11">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_1_2" type="text" placeholder="20">%扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_1_3" type="text"
                                        placeholder="0.1">元/台斤。 --}}
                                    10 〜 19 %，不扣。
                                </p>
                                <p style="margin-left:3%;">(2)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_2_1" type="text" placeholder="21">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_2_2" type="text" placeholder="30">%扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_2_3" type="text"
                                        placeholder="0.2">元/台斤。 --}}
                                    20 〜 29 %，不扣。
                                </p>
                                <p style="margin-left:3%;">(3)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_3_1" type="text" placeholder="31">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_3_2" type="text" placeholder="40">%扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_3_3" type="text"
                                        placeholder="0.3">元/台斤。 --}}
                                    30 〜 39 %，扣 0.1 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(4)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_4_1" type="text" placeholder="41">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_4_2" type="text" placeholder="50">%扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_4_3" type="text"
                                        placeholder="0.4">元/台斤。 --}}
                                    40 〜 49 %扣 0.2 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(5)、
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_5_1" type="text" placeholder="50">%以上扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_7_5_2" type="text"
                                        placeholder="0.5">元/台斤。 --}}
                                    50 %以上，扣 0.3 元/台斤。
                                </p>
                                <p style="margin-left:1%;">八、病雞：防檢局駐廠獸醫站實際剔除羽數*毛雞平均重。</p>
                                <p style="margin-left:3%;">例：100隻*1.6k*x19(元/斤)/0.6=5067元</p>
                                <p style="margin-left:1%;">九、心肫剔除：防檢局駐廠獸醫站實際剔除之重量。</p>
                                <p style="margin-left:3%;">例：10k/0.6*19元/斤=37元</p>
                                <p style="margin-left:1%;">十、關節炎：毛雞總重(kg)ｘ抽測不良率棒腿產出率
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_10_1" type="text" placeholder="13.02">% --}}
                                    13.02 %
                                </p>
                                <p style="margin-left:3%;">
                                    例:6460kg*15%*13.02%=126kg，126kgx(90-50)=5040元</p>
                                <p style="margin-left:1%;">十一、腹水部份：經篩選後依實際重量全部扣款。</p>
                                <p style="margin-left:1%;">十二、毛雞含水：</p>
                                <p style="margin-left:3%;">
                                    (1)小雨扣實重1%，中雨扣實重3%，雨扣實重4%(大、中、小雨由相關人員認定之)。</p>
                                <p style="margin-left:3%;">(2)天氣炎熱時，應在產地總重過完磅才可淋水。</p>
                                <p style="margin-left:1%;">十三、死雞容許量：</p>
                                <p style="margin-left:3%;">(1)熱季(5月〜10月)每車
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_13_1" type="text" placeholder="20">隻。 --}}
                                    20 隻。
                                </p>
                                <p style="margin-left:3%;">(2)涼季(11月〜4月)每車
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_13_2" type="text" placeholder="10">隻。 --}}
                                    10 隻。
                                </p>
                                <p style="margin-left:1%;">十四、以上所列均以每車次為單位。</p>
                                <p style="margin-left:1%;">十五、已派車卻無雞可抓或隻數不足者，依實際情況由賣方補足買方運費。</p>
                                <p style="margin-left:1%;">十六、自設地磅校磅差異於±30kg/車者，仍以±30kg/車為收購標準。</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>注意事項：</td>
        </tr>
        <tr>
            <td colspan="5">
                <ol>
                    <p>第一條、作業規定:</p>
                    <p style="margin-left:1%;">
                        (一)、入雛數認定:為乙方實際點收之總雛數(不含2%贈予);如一週內死亡與淘汰隻數超過2%之贈數時或乙方對該幼雛品質有異議時得即時提出，經與該交雛之種雞場三方共同確認後協議處理。
                    </p>
                    <p style="margin-left:1%;">
                        (二)、飼養日齡:雙方於飼養28至30日齡前磅雞，經確認體重後，如成雞每台平均體重達</p>
                        <input class="form-control inline-block w-20 text-center"
                            value={{ $data['contract_details']['ok_to_die'] }} type="text" placeholder="1"
                            required>
                        公斤以上時，甲方即可全權處理抓雞事宜，乙方如未配合抓雞事宜，則依電宰公會辦法扣款之。

                    <p style="margin-left:1%;">(三)、交雞程序:乙方應依甲方指定之時間內備妥足人力，將成雞交付於運雞車上
                        由雙方會同過磅，抓雞工資由乙方支付。</p>
                    <p style="margin-left:1%;">(四)、藥物殘留:</p>
                    <p style="margin-left:3%;">
                        1、乙方於入日起至21日之投需符合衞生署編印之飼料添加物使用管理手冊，21日齡後之投藥，需取得甲方之書面同意。</p>
                    <p style="margin-left:3%;">2、為防止藥物殘留，乙方須於入雛21日齡後使用無藥物的N肉雞3號飼料。</p>
                    <p style="margin-left:1%;">
                        (五)、養期間內甲方得不定時派員進場服務。如有雞隻異常死亡現象，乙方應立即通知甲方人員到場認證。</p>
                    <p style="margin-left:1%;">
                        (六)、乙方需逐日填寫記錄表供甲方人員參閲，並於每批出清後48小時內將飼養管理記錄表彙整完成遞交甲方。</p>
                    <p style="margin-left:1%;">
                        (七)、貨物收受承諾:甲方指定運送飼料給乙方，送貨單內載明乙方為收貨人，並經乙方本人、家屬或受僱人在送貨單上簽收者，視同乙方本人收受。
                    </p>
                    <p style="margin-left:1%;">(八)、毛雞出售後，未用畢之飼料，乙方需於三日內通知甲方收回。</p>
                    <p>第二條、毛雞驗收辦法:</p>
                    <p style="margin-left:1%;">(一)、進廠毛雞須符合驗收標準，以單台車為標準。</p>
                    <p style="margin-left:1%;">
                        (二)、乙方接獲甲方通知後，應於出雞前六小時實施停料供水，不得強制餵食以符合屠宰衞生規定。</p>
                    <p>第三條、有下列情形之一，甲方有權終止合作關係，乙方不得異議:</p>
                    <p style="margin-left:1%;">(一)、乙方連續兩批飼養育成率低於</p>
                        <input class="form-control inline-block w-20 text-center"
                            value={{ $data['contract_details']['breeding_rate'] }} type="text" placeholder="1.9"
                            required>
                        %。

                    <p style="margin-left:1%;">(二)、乙方連續兩批飼料換肉率高於</p>
                        <input class="form-control inline-block w-20 text-center"
                            value={{ $data['contract_details']['feed_conversion_rate_1'] }} type="text"
                            placeholder="1.75" step="0.01" required>
                        時;或一批飼料換肉率高於
                        <input class="form-control inline-block w-20 text-center"
                            value={{ $data['contract_details']['feed_conversion_rate_2'] }} type="text"
                            step="0.01" placeholder="1.9" required>時。

                    <p style="margin-left:1%;">
                        (三)、乙方藥物投放使用不依規定或經驗出禁藥者。如甲方因此受有損害，並得請求損害賠償。</p>
                    <p style="margin-left:1%;">(四)、乙方飼養管理方法不符甲方要求標準或經甲方要求而未見改善者。</p>
                    <p style="margin-left:1%;">(五)、合約有效期間內</p>
                    <p style="margin-left:3%;">1、如遇天災或人力不可抗拒事由，致無法續行時，甲方有權終止合約關係。</p>
                    <p style="margin-left:3%;">
                        2、如因所飼養白肉雞不幸感染禽流感等疫情，依法應予撲殺時，除本契約應提前終止外;倘乙方因而得受領政府相關單位補助款時，乙方除同意委任甲方代為領取外，所領款並以甲方為第一順位受償者，即由甲方先行扣除雛雞款、飼料總款後，餘款始歸乙方受償，並簽具委任書及受償順位同意書。
                    </p>
                    <p>第四條、其他約定事項:</p>
                    <p style="margin-left:1%;">
                        (一)、毛雞統出後乙方應提具農民產品(物)收據供作甲方之進貨證明;甲方應於毛雞出售後15日工作天內核發給付乙方之收益。</p>
                    <p style="margin-left:1%;">
                        (二)、乙方同意依每萬羽伍拾萬元整之比例面額開立本票乙張給予甲方，如己方有違約或積欠甲方未清償之款項時，甲方可隨時無條件提示本票請求兑現，乙方不得異議。
                    </p>
                    <p style="margin-left:1%;">(三)、乙方同意本契約所生相關之帳款往來，指定下列匯款銀行與帳號供甲方付款之用。
                    </p>
                </ol>
            </td>
        </tr>
    </tbody>
</table>
