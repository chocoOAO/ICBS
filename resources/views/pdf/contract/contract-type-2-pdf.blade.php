<!DOCTYPE html>

<style>
    .font-zh {
        font-family: "NotoSansTC-VariableFont_wght";
    }

    .table-fixed {
        width: 100%;
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
</style>

<html lang="zh-Hant"> <!-- 設置語言屬性 lang 為繁體中文（台灣）。-->

@php
    use App\Models\Contract;
    // use App\Models\ContractDetail;
    $data['contract'] = Contract::where('id', $data['contract'])->get();
    $data['contract'] = $data['contract'][0];
@endphp

@include('pdf.contract.contract-basic-information-pdf') {{-- 套用合約基本版面 --}}

<body class="font-zh"> <!-- 指定字體，輸出台灣省繁體中文。 -->
    <div class="my-2 py-5 border-gray-200">
        <h1 class="text-xl text-gray-800 leading-tight text-center font-bold" style="text-align: center;">代養合約書計價方式</h1>
    </div>

    <table class="max-w-full mx-auto">
        <tbody>
            <tr>
                <td rowspan="2" style="width: 3%; text-align: center; border: 1px solid black;">
                    <p style="text-align: center;">飼</p>
                    <p style="text-align: center;">養</p>
                    <p style="text-align: center;">報</p>
                    <p style="text-align: center;">酬</p>
                    <p style="text-align: center;">對</p>
                    <p style="text-align: center;">照</p>
                    <p style="text-align: center;">表</p>                    
                </td>
                <td style="width: 5%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>毛雞規格（KG）</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_1_1'] }} KG以下</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_2_1'] }} KG ～ {{ $data['contract_details']['chicken_weight_kg_2_2'] }} KG</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_3_1'] }} KG ～ {{ $data['contract_details']['chicken_weight_kg_3_2'] }} KG</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_4_1'] }} KG ～ {{ $data['contract_details']['chicken_weight_kg_4_2'] }} KG</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_5_1'] }} KG ～ {{ $data['contract_details']['chicken_weight_kg_5_2'] }} KG</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_7_1'] }} KG ～ {{ $data['contract_details']['chicken_weight_kg_7_2'] }} KG</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_weight_kg_6_1'] }} KG以上</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 5%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>飼養報酬（元/羽）</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price1'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price2'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price3'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price4'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price5'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price6'] }} 元/羽</p>
                    </div>
                </td>
                <td style="width: 13%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>{{ $data['contract_details']['chicken_allowance_price7'] }} 元/羽</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="9">
                    <ol class="custom-list ml-4" style="margin-left:3%;">
                        <li>
                            育成率97%以上，獎勵金 {{ $data['contract_details']['contract2_unamed_1'] }}（元/羽）
                        </li>
                        <li style="color: orange">
                            老客戶續約配合加 {{ $data['contract_details']['contract2_unamed_2'] }}（元/羽）
                        </li>
                        <li>
                            重效差達 {{ $data['contract_details']['contract2_unamed_3_1'] }} %以上加 {{ $data['contract_details']['contract2_unamed_3_2'] }}（元/羽）
                        </li>
                        <li>
                            飼養報酬計算羽數以實際上車羽數扣除電宰損失羽數（死雞加剔除雞）計算。
                        </li>
                        <li>
                            電宰損失羽數（死雞加剔除雞）如高於上車羽數1%時，育成率計算基準以實際上車羽數扣除電宰損失羽數（死雞+剔除雞）後之實際羽數計算。
                        </li>
                        <li>
                            配合提供符合產銷履歷認證牧場者，依實際上車羽數扣除電宰損失羽數（死雞+剔除雞）獎勵回饋，每羽 {{ $data['contract_details']['contract2_unamed_4'] }} 元。
                        </li>
                        <li>
                            體重以全場出售平均重計算。
                        </li>
                        <li>
                            正常飼養狀況下，因電宰廠排雞需求，出售均重低於 {{ $data['contract_details']['contract2_unamed_5_1'] }} KG（含）以下時,以
                            {{ $data['contract_details']['contract2_unamed_5_2'] }} ～ {{ $data['contract_details']['contract2_unamed_5_3'] }} KG之飼養報酬計算。
                        </li>
                        <li>
                            雛雞羽數確認以入雛後第七日齡為原則，但如雛雞有異常汱損狀況，得延後至14日齡前確認，並以確認羽數做為育成率與生產指數依據。
                        </li>
                        <li style="color: blue">
                            若發現乙方有盜賣毛雞圖利情事經查證屬實者，甲方得逕行認定該批育成率為96%，低於該育成率之差數以每羽新台幣（下同）90元向乙方科處罰金。
                        </li>
                    </ol>                    
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 2px; margin-bottom: 2px;"></div> <!-- 在上下创建间隙 -->

    <table class="max-w-full mx-auto">
        <tbody>
            <tr>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>毛雞重 {{ $data['contract_details']['live_chicken_weight_0'] }} KG ～ {{ $data['contract_details']['live_chicken_weight_1'] }} KG</p>
                    </div>
                </td>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>飼效 {{ $data['contract_details']['feed_efficiency'] }} 以下</p>
                    </div>
                </td>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>獎勵每羽 {{ $data['contract_details']['live_chicken_weight_reward1'] }} 元</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>績優客戶</p>
                    </div>
                </td>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>毛雞重 {{ $data['contract_details']['live_chicken_weight_2'] }} KG ～ {{ $data['contract_details']['live_chicken_weight_3'] }} KG</p>
                    </div>
                </td>
                <td style="width:33%; text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>獎勵每羽 {{ $data['contract_details']['live_chicken_weight_reward2'] }} 元</p>
                    </div>
                </td>
            </tr>

            @php
            $translateValue = function($value) {
                switch ($value) {
                    case 'non-choose':
                        return '未選擇';
                    case 'reward':
                        return '以下獎勵';
                    case 'deduction':
                        return '以上扣款';
                    default:
                        return $value;
                }
            };
            @endphp

            <tr>
                <td colspan="2" style="text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p style="white-space: nowrap;">臭爪 {{ $data['contract_details']['stinking_claw'] }} %（含）{{ $translateValue($data['contract_details']['stinking_claw_type']) }}</p>
                    </div>
                </td>
                <td style="text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>每羽 {{ $data['contract_details']['stinking_claw_reward'] }} 元</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p style="white-space: nowrap;">臭胸 {{ $data['contract_details']['stinking_chest'] }} %（含）{{ $translateValue($data['contract_details']['stinking_chest_type']) }}</p>
                    </div>
                </td>
                <td style="text-align: center; border: 1px solid black;">
                    <div class="relative flex items-center mt-4 mb-4">
                        <p>每羽 {{ $data['contract_details']['stinking_chest_reward'] }} 元</p>
                    </div>
                </td>
            </tr>

            @php
            $translateValue = function($value) {
                switch ($value) {
                    case 'non-choose':
                        return '未選擇';
                    case 'reward':
                        return '每羽';
                    case 'deduction':
                        return '每公斤';
                    default:
                        return $value;
                }
            };
            @endphp

            @for ($i = 0; $i < 6; $i++)
                @php
                    $description = 'extra_description_' . $i ;
                    $descriptionType = 'extra_description_' . $i . '_type' ; // 在每次循环中构建 $descriptionType 变量
                    $descriptionReward = 'extra_description_' . $i . '_reward' ;
                @endphp
                <tr>
                    <td colspan="2" style="text-align: center; border: 1px solid black;">
                        <div class="relative flex items-center mt-4 mb-4">
                            <p>{{ $data['contract_details'][$description] }} {{ $translateValue($data['contract_details'][$descriptionType]) }}</p>
                        </div>
                    </td>
                    <td style="text-align: center; border: 1px solid black;">
                        <div class="relative flex items-center mt-4 mb-4">
                            <p style="white-space: nowrap;">每羽 {{ $data['contract_details'][$descriptionReward] }} 元</p>
                        </div>                        
                    </td>
                </tr>
            @endfor

            <tr>
                <td colspan="3">
                    <div class="relative flex items-center mt-4 mb-4 ml-4">
                        <p>〔注意事項〕</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="ml-4" style="margin-left:3%;">
                        <p>第一條、作業規定：</p>
                        <p style="margin-left:1%; white-space: nowrap;">
                            (一)、入雛數認定：為乙方實際點收之總雛數（不含2%贈予）；如一週內死亡與淘汰隻數超過2%之贈予數時或乙方對該幼雛品質有異議時得即時提出，經與該交雛之種雞場三方共同確認後協議處理。
                        </p>
                        <p style="margin-left:1%;">
                            (二)、飼養日齡：雙方於飼養28至30日齡前磅雞，經確認體重後，如成雞每台平均體重達 {{ $data['contract_details']['ok_to_die'] }} 公斤以上時，甲方即可全權處理抓雞事宜，乙方如未配合抓雞事宜，則依電宰公會辦法扣款之。
                        </p>
                        <p style="margin-left:1%;">
                            (三)、交雞程序：乙方應依甲方指定之時間內備妥足人力，將成雞交付於運雞車上由雙方會同過磅，抓雞工資由乙方支付。
                        </p>
                        <p style="margin-left:1%;">
                            (四)、藥物殘留：
                        </p>
                            <p style="margin-left:3%;">
                                1、乙方於入雛日起至21日齡之投藥需符合衛生署編印之飼料添加物使用管理手冊，21日齡後之投藥，需取得甲方之書面同意。
                            </p>
                            <p style="margin-left:3%;">
                                2、為防止藥物殘留，乙方須於入雛21日齡後使用無藥物的N肉雞3號飼料。
                            </p>
                        <p style="margin-left:1%;">
                            (五)、飼養期間內甲方得不定時派員進場服務。如有雞隻異常死亡現象，乙方應立即通知甲方人員到場認證。
                        </p>
                        <p style="margin-left:1%;">
                            (六)、乙方需逐日填寫記錄表供甲方人員參閲，並於每批出清後48小時內將飼養管理記錄表彙整完成遞交甲方。
                        </p>
                        <p style="margin-left:1%;">
                            (七)、貨物收受承諾：甲方指定運送飼料給乙方，送貨單內載明乙方為收貨人，並經乙方本人、家屬或受僱人在送貨單上簽收者，視同乙方本人收受。
                        </p>
                        <p style="margin-left:1%;">
                            (八)、毛雞出售後，未用畢之飼料，乙方需於三日內通知甲方收回。
                        </p>
                    </ol>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="ml-4" style="margin-left:3%;">
                        <p>第二條、毛雞驗收辦法：</p>
                        <p style="margin-left:1%;">
                            (一)、進廠毛雞須符合驗收標準，<font color="orange">以單台車為標準。</font>
                        </p>
                        <p style="margin-left:1%;">
                            (二)、乙方接獲甲方通知後，應於出雞前六小時實施停料供水，不得強制餵食以符合屠宰衞生規定。
                        </p>
                    </ol>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="ml-4" style="margin-left:3%;">
                        <p>第三條、有下列情形之一，甲方有權終止合作關係，乙方不得異議：</p>
                        <p style="margin-left:1%;">
                            (一)、乙方連續兩批飼養育成率低於 {{ $data['contract_details']['breeding_rate'] }} %。
                        </p>
                        <p style="margin-left:1%;">
                            (二)、乙方建續兩批飼料換肉率高於 {{ $data['contract_details']['feed_conversion_rate_1'] }} 時；或一批飼料換肉率高於 {{ $data['contract_details']['feed_conversion_rate_2'] }} 時。
                        </p>
                        <p style="margin-left:1%;">
                            (三)、乙方藥物投放使用不依規定或經驗出禁藥者。如甲方因此受有損害，並得請求損害賠償。
                        </p>
                        <p style="margin-left:1%;">
                            (四)、乙方飼養管理方法不符甲方要求標準或經甲方要求而未見改善者。
                        </p>
                        <p style="margin-left:1%;">
                            (五)、合約有效期間內：
                        </p>
                            <p style="margin-left:3%;">
                                1、如遇天災或人力不可抗拒事由，致無法續行時，甲方有權終止合約關係。
                            </p>
                            <p style="margin-left:3%;">
                                2、如因所飼養白肉雞不幸感染禽流感等疫情，依法應予撲殺時，除本契約應提前終止外；<!--
                                -->倘乙方因而得受領政府相關單位補助款時，乙方除同意委任甲方代為領取外，
                                所領款並以甲方為第一順位受償者，即由甲方先行扣除雛雞款、飼料總款後，餘款始歸乙方受償，並簽具<font color="orange">委任書及受償順位同意書</font>。
                            </p>
                    </ol>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="3" style="word-break: break-all; overflow-wrap: break-word;">
                    <div class="relative flex items-center justify-center mt-4 mb-4 ml-4" style="word-wrap: break-word; white-space: normal;">
                    <ol class="ml-4" style="margin-left:3%;">
                        <p>第四條、其他約定事項：</p>
                        <p style="margin-left:1%;">
                            (一)、毛雞統出後乙方應提具農民產品（物）收據供作甲方之進貨證明；甲方應於毛雞出售後15日工作天內核發給付乙方之收益。
                        </p>
                        <p style="margin-left:1%;">
                            (二)、乙方同意依每萬羽伍拾萬元整之比例面額開立本票乙張給予甲方，如乙方有違約或積欠甲方未清償之款項時，甲方可隨時無條件提示本票請求兑現，乙方不得異議。
                        </p>
                        <p style="margin-left:1%;">
                            (三)、乙方同意本契約所生相關之帳款往來，指定下列匯款銀行與帳號供甲方付款之用。
                        </p>
                        <p style="margin-left:1%;">
                            <font color="blue">
                            (四)、乙方同意甲方於合約有效期間，依個人資料保護法之規定蒐集、處理及利用乙方所提供之個人資料，並於詳閱後簽署同意書。
                            </font>
                        </p>
                        <p style="margin-left:1%;">
                            <font color="blue">
                            (五)、本合約書壹式兩份，雙方各執壹份為憑。
                            </font>
                        </p>
                        <p style="margin-left:1%;">
                            <font color="blue">
                            (六)、如有未盡事宜，得由雙方協議後變更之，並信守誠信交易聲明。
                            </font>
                        </p>
                        <p style="margin-left:1%;">
                            <font color="blue">
                            (七)、因本合約所生訴訟，雙方同意以臺灣臺中地方法院為第一審管轄法院。
                            </font>
                        </P>
                    </ol>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
