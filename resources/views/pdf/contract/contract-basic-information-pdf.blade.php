<!DOCTYPE html>
<style>
    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght";
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
    }

    th, td {
        border-collapse: collapse;
    }

    .max-w-full {
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
    .text-gray {
        color: gray;
    }

    ol.custom-list {
        list-style: none; /* 移除原有的編號 */
        counter-reset: list-counter; /* 重置計數器 */
    }
    ol.custom-list li {
        counter-increment: list-counter; /* 計數器自增 */
        margin-bottom: 4px; /* 底部間距，可選 */
        position: relative; /* 使偽元素定位相對於li */
    }
    ol.custom-list li::before {
        content: '\002A'; /* 使用[*]作為列表符號 */
        position: absolute; /* 絕對定位偽元素 */
        left: -1.5em; /* 調整偽元素位置 */
        color: red; /* 設置顏色為紅色 */
    }
    
    .page-break {
        page-break-before: always;
    }

    .ml-4 {
        margin-left: 4px;;
    }

    .mt-4 {
        margin-top: 4px;;
    }
    .mb-4 {
        margin-bottom: 4px;;
    }

</style>

<html lang="zh-Hant"> <!-- 設置語言屬性 lang 為繁體中文（台灣）。-->

@php
    use App\Models\Contract;
    $data['contract'] = Contract::where('id', $data['contract']['id'])->get();
    $data['contract'] = $data['contract'][0];
@endphp

<body class="font-zh"> <!-- 指定字體，輸出台灣省繁體中文。 -->
    <div class="my-2 py-5 border-gray-200">
        <h1 class="text-xl text-gray-800 leading-tight text-center font-bold" style="text-align: center;">白肉雞合作飼養合約書</h1>
    </div>

    <table class="max-w-full mx-auto">
        <tbody>
            <tr>
                <td style="width: 10%;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>立書合約人
                    </div>
                </td>                
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        甲方：{{ $data['contract']['m_NAME'] }}
                    </div>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        乙方：{{ $data['contract']['name_b'] }}
                    </div>
                </td>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>本合約有效時間
                    </div>
                </td>
                <td style="width: 30%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        開始日期：{{ $data['contract']['begin_date'] }}
                    </div>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        結束日期：{{ $data['contract']['end_date'] }}
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>約定入雛羽數
                    </div>
                </td>                
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        {{ $data['contract_details']['order_quantity'] }}隻                       
                    </div>
                </td>
                <td colspan="2">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        <span style="color: orange;">約定入雛羽數合約期間內若甲方對於合約內容或條件有變動時，甲方得終止本合約。</span>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>飼養地址
                    </div>
                </td>
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        {{ $data['contract_details']['address'] }}                       
                    </div>
                </td>
                <td colspan="2" rowspan="5" style="vertical-align: top;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        <font color="red">*</font>上述地點若為租用，乙方需提供雞舍及土地租賃契約書或土地使用權同意書。
                    </div>
                    
                    @if ($data['contract']['type'] == 2)
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        <font color="red">*</font>乙方不得於上述地點或周圍飼養非經甲方同意之家禽。
                    </div>
                    
                    @elseif ($data['contract']['type'] == 3)
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        <font color="red">*</font><font color="blue">乙方不得將上述地點之外之飼養家禽，非經甲方同意不得出售於指定電宰廠。</font>
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        飼養地段及飼號
                    </div>
                </td>
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        飼養地段：{{ $data['contract_details']['feed_area'] }}
                    </div>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        飼號：{{ $data['contract_details']['feed_number'] }}
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>飼養面積
                    </div>
                </td>
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        {{ $data['contract_details']['area'] }}
                    </div>                        
                </td>
            </tr>

            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>飼養雞舍棟數
                    </div>
                </td>
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        棟：{{ $data['contract_details']['building_name1'] }}
                    </div>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        飼養量：{{ $data['contract_details']['feed_amount1'] }}隻
                    </div>
                </td>
            </tr>
            
            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>同意飼養隻數
                        （每批）
                    </div>
                </td>
                <td style="width: 50%; border: 1px solid black;">
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        {{ $data['contract_details']['per_batch_chick_amount'] }}隻                       
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan='4' style="border: 1px solid black;">
                    @if ($data['contract']['type'] == 2)
                    <ol class="custom-list ml-4">
                        <li class="mt-4 mb-4">
                            <font color="blue">依本合約約定飼養之雞隻，除甲方同意外，應全數交回甲方處理，或由甲方指定之屠宰場逕與乙方締結新合約，乙方無權處分。</font>
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">乙方同意於合約期間，由甲方提供入雛相關事宜，入雛日期由甲方安排。雛雞由甲方提供，費用由甲方支付，購買雛雞之折扣歸甲方所有。</font>
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">乙方同意提供並支付雞舍設備、飼養勞務與管理及一切相關之開支。</font>
                        </li>
                        <li class="mt-4 mb-4">
                            為達合作飼養之目的，乙方同意自行提供疫苗、藥品、人工、設備及什支等費用。
                        </li>
                        <li class="mt-4 mb-4">
                            乙方應遵守完全使用甲方提供『福壽牌』飼料之約定。
                        </li>
                        <li class="mt-4 mb-4">
                            不退料獎金新台幣參仟元整，剩料由乙方自行處理。
                        </li>
                        <li class="mt-4 mb-4">
                            所合作飼養之雞隻應全數繳回甲方，乙方無權處分。
                        </li>
                    </ol>
                    
                    @elseif ($data['contract']['type'] == 3)
                    <ol class="custom-list ml-4">
                        <li class="mt-4 mb-4">
                            飼料議定單價（{{ $data['contract_details']['feeding_price_date'] }} 報價，散裝價）：<!--
                            -->肉雞一號每公斤 {{ $data['contract_details']['chicken_n1_feeding_price'] }} 元，
                            肉雞二號每公斤 {{ $data['contract_details']['chicken_n2_feeding_price'] }} 元，
                            肉雞三號每公斤 {{ $data['contract_details']['chicken_n3_feeding_price'] }} 元，
                            雛雞計價 {{ $data['contract_details']['chicken_price'] }} 元/羽。
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">
                            乙方同意於契約期間內使用甲方所提供之飼料，不得購用其他廠牌飼料，飼料價格另訂之。
                            </font>
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">
                            合作飼養之雞隻，雙方同意由甲方指定之電宰廠全數收買，並由乙方開立農漁民收據予電宰廠。乙方同意由甲方向電宰廠收取雞隻款，扣除合約所載應扣款項後餘額再交付乙方。
                            </font>
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">
                            契約期間單價依本公司初次交易為報價基準，並依市場行情變動而隨時調整。
                            </font>
                        </li>
                    </ol>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="max-w-full mx-auto">
        <tbody>
            <tr>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center">
                        <font color="red">*</font>金融機構、郵局名稱
                    </div>
                </td>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center">
                        <font color="red">*</font>分行名稱
                    </div>
                </td>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center">
                        <font color="red">*</font>金融帳號 (附存摺影本)
                    </div>
                </td>
                <td colspan="1" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center">
                        <font color="red">*</font>月支酬勞
                    </div>
                </td>        
            </tr>
            <tr>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center word-wrap: break-word; white-space: normal;">
                        {{ $data['contract']['bank_name'] }}                       
                    </div>
                </td>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center word-wrap: break-word; white-space: normal;">
                        {{ $data['contract']['bank_branch'] }} <!-- 分行名稱 -->
                    </div>
                </td>
                <td colspan="2" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center word-wrap: break-word; white-space: normal;">
                        {{ $data['contract']['bank_account'] }} <!-- 銀行帳號 -->
                    </div>
                </td>
                <td colspan="1" class="text-center pt-5" style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid black; border-collapse: collapse;">
                    <div class="relative flex items-center justify-center word-wrap: break-word; white-space: normal;">
                        {{ $data['contract']['salary'] }} <!-- 酬勞 -->
                    </div>
                </td>
            </tr>
            
            @if ($data['contract']['type'] == 3)
            <tr>
                <td colspan="7" style="border: 1px solid black;">
                    <ol class="custom-list ml-4">
                        <li class="mt-4 mb-4" style="word-wrap: break-word; white-space: normal;">
                            乙方須提供存摺影本予甲方，若非乙方本人存摺須另簽訂匯款同意書以便甲方付款使用。甲方於電宰廠抓雞作業完成後於十五日工作天內，依電宰廠之結算款項扣除飼料款後，餘額匯款入乙方指定之帳號。
                        </li>
                        <li class="mt-4 mb-4">
                            若電宰廠之結算款項不足支付飼料款時，乙方應開立足額支票或現款支付甲方。
                        </li>
                        <li class="mt-4 mb-4">
                            扣除不良雞隻扣款作業標準所列情形與剔除雞以外者，上車補貼每羽新台幣 {{ $data['contract_details']['each_chicken_car_price'] }} 元。
                        </li>
                        <li class="mt-4 mb-4">
                            抓雞工資由乙方負責支付。
                        </li>
                        <li class="mt-4 mb-4">
                            <font color="blue">
                            本合約如有訴訟時，雙方同意以台灣台中地方法院為第一審管轄法院。
                            </font>
                        </li>
                    </ol>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    
    <table class="max-w-full mx-auto">
        <tbody>
            <tr>
                <td rowspan="3" style="width: 10%; border: 1px solid black;">
                    <div class="mt-4 mb-4 ml-4">
                        <font color="red">*</font>連絡電話
                    </div>
                </td>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <span class="inline-flex items-center px-3 text-gray-500">公司</span>
                    </div>
                </td>
                <td style="width: 80%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        {{ $data['contract']['office_tel'] !== '' ? $data['contract']['office_tel'] : '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <span class="inline-flex items-center px-3 text-gray-500">住家</span>
                    </div>
                </td>
                <td style="width: 80%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        {{ $data['contract']['home_tel'] !== '' ? $data['contract']['home_tel'] : '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 10%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <span class="inline-flex items-center px-3 text-gray-500">手機</span>
                    </div>
                </td>
                <td style="width: 80%; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        {{ $data['contract']['mobile_tel'] !== '' ? $data['contract']['mobile_tel'] : '' }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- 分頁 -->
    <div class="page-break"></div>

    <table class="max-w-full mx-auto" style="table-layout: fixed;"> <!-- 添加 table-layout: fixed;：控制表格的布局，确保列宽一致。 -->
        <tbody>
            <tr>
                <td>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        一、雙方約定事項如下：
                    </div>
                </td>
            </tr>
            <tr>
                <td style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="list-decimal ml-4" style="margin-left:3%;">
                        <li class="text-gray">
                            甲方提供育成毛雞由乙方處理屠宰及出售事宜，乙方所需毛雞時間、數量，由雙方議定排定之。
                        </li>
                        <li class="text-gray">
                            甲方提供毛雞需經藥殘檢驗合格。
                        </li>
                        <li class="text-gray">
                            毛雞規格為1.80～2.25公斤為原則，2.251～2.30公斤以下扣0.6元（若經協商大雞屠宰需求，則不在此列扣款），2.3公斤以上扣0.9元，於入雛日後26～30天磅雞後，由雙方議定抓雞日期；
                            若市場特殊需求得經雙方同意調整規格。
                        </li>
                        <li class="text-gray">
                            毛雞每斤計價方式：依出雞當日聯合報，中華民國養雞協會肉雞產地交易行情表
                            {{ $data['contract_details']['trading_market_table_0'] }} ～ {{ $data['contract_details']['trading_market_table_1'] }}
                            公斤毛雞之北、中、嘉南、高屏區電宰之報價結算：毛雞均重達 {{ $data['contract_details']['trading_market_table_2'] }} 公斤（含以上）以新台幣
                            {{ $data['contract_details']['trading_market_table_3'] }} 元/斤（手續費）計價，毛雞均重達 {{ $data['contract_details']['trading_market_table_4'] }}
                            公斤（以下）以新台幣 {{ $data['contract_details']['trading_market_table_5'] }}

                            @if ($data['contract']['type'] == 3)
                            元/斤（手續費）計價，產銷履歷場以毛雞均重達 {{ $data['contract_details']['trading_market_table_7'] }} 公斤（含以上）以新台幣 {{ $data['contract_details']['trading_market_table_8'] }}
                            元/斤（手續費）計價，毛雞均重達 {{ $data['contract_details']['trading_market_table_9'] }} 公斤（以下）以新台幣 {{ $data['contract_details']['trading_market_table_10'] }} 元/斤（手續費）計價。

                            @elseif ($data['contract']['type'] == 2)
                                元/斤（手續費）計價，產銷履歷場以新台幣 {{ $data['contract_details']['trading_market_table_6'] }} 元/斤（手續費）計價。
                            @endif
                        </li>
                        <li class="text-gray">
                            異常扣款依『台灣區電動屠宰同業公會』業界規則及附件所示112年洽富公司扣款項目處理之。
                        </li>
                        <li class="text-gray">
                            甲方運費補貼乙方：
                        </li>
                            <ol type="a">
                                <li class="text-gray">
                                    台中市、彰化縣、南投縣、苗栗縣為基準不予補貼（南投埔里、魚池、仁愛等每車次補貼油費新台幣 {{ $data['contract_details']['compensation_0'] }} 元/車）
                                    ，每超越一縣補貼油費新台幣 {{ $data['contract_details']['compensation_1'] }} 元/車以此類推。
                                </li>
                                <li class="text-gray">
                                    未經乙方許可，空車折返補貼新台幣 {{ $data['contract_details']['compensation_2'] }} 元/車。
                                </li>
                            </ol>

                        @if ($data['contract']['type'] == 3)
                            <li class="text-gray">
                                雛雞折扣回饋：乙方由種雞場雛雞回饋金額中，依實際電宰時存量提出每羽 {{ $data['contract_details']['discount_reward_0'] }} 元金額回饋給甲方（時價除外），
                                雛雞價低於 {{ $data['contract_details']['discount_reward_1'] }} 元/羽時依價格 {{ $data['contract_details']['discount_reward_2'] }} %計算。                                
                            </li>
                            <li class="text-gray">
                                由富祥種雞場提供雛雞時，依實際入雛羽數提出每羽 {{ $data['contract_details']['Feedback_0'] }} 元回饋金時，則回饋予甲方。
                            </li>

                        @else
                            <li class="text-gray">
                                雛雞折扣回饋：甲方由種雞場雛雞回饋金額中，依實際電宰時存量提出每羽1元金額回饋給乙方（時價除外），
                                雛雞價低於 {{ $data['contract_details']['discount_reward_0'] }} 元/羽時依價格 {{ $data['contract_details']['discount_reward_1'] }} %計算。
                            </li>
                            <li class="text-gray">
                                由富祥種雞場提供雛雞時，依實際入雛羽數提出每羽1元回饋金時，則回饋予乙方。
                            </li>
                        @endif

                        <li class="text-gray">
                            其他未盡事宜則依『台灣區電動屠宰同業公會』及業界規則處理之。
                        </li>
                        <li class="text-gray">
                            剔除雞：防檢局駐場獸醫師、屠檢人員實際剃除羽數×毛雞平均重。
                        </li>
                    </ol>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        二、價金結算方式：
                    </div>
                </td>
            </tr>
            <tr>
                <td style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="list-decimal ml-4" style="margin-left:3%;">
                        <li class="text-gray">
                            每批交貨完畢後，乙方一週內應提供結算清單，供甲方核對。甲方核對無誤後開立請款憑證供乙方為付款依據。
                        </li>
                        <li class="text-gray">
                            乙方需於抓雞結束後，月結90日匯款予甲方。
                        </li>
                    </ol>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                        三、本契約一式二份，於雙方蓋章後生效並各執一份為憑。
                    </div>
                </td>
            </tr>
            <br>
        </tbody>
    </table>
</body>

<!-- 分頁 -->
<div class="page-break"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 选择所有具有 'dynamic-width' 类的输入框
        const inputs = document.querySelectorAll('.dynamic-width');

        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                adjustInputWidth(this);
            });

            // 初始调整
            adjustInputWidth(input);
        });

        function adjustInputWidth(inputElement) {
            const inputContentLength = inputElement.value.length;
            const newWidth = inputContentLength > 20 ? inputContentLength : 20; // 如果字符数大于20，则调整宽度
            inputElement.style.width = `${newWidth}ch`; // 使用 "ch" 单位
        }
    });
</script>


