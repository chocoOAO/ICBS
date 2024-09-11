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

    .page-break {
        page-break-before: always;
    }
</style>

<html lang="zh-Hant"> <!-- 設置語言屬性 lang 為繁體中文（台灣）。-->

@php
    use App\Models\Contract;
    // use App\Models\ContractDetail;
    $data['contract'] = Contract::where('id', $data['contract'])->get(); // 透過Contract的id來尋找資料
    $data['contract'] = $data['contract'][0];
@endphp

@include('pdf.contract.contract-basic-information-pdf') {{-- 套用合約基本版面 --}}

<body class="font-zh"> <!-- 指定字體，輸出台灣省繁體中文。 -->
<table class="max-w-full mx-auto">
    <tbody>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="ml-4" style="margin-left:3%;">
                    <p>第一條、作業規定：</p>
                    <p style="margin-left:1%; white-space: nowrap;">
                        (一)、入雛數認定：為乙方實際點收之總雛數（不含2%贈予）；如一週內死亡與淘汰隻數超過2%之贈數時或乙方對該幼雛品質有異議時得即時提出，經與該交雛之種雞場三方共同確認後協議處理。
                    </p>
                    <p style="margin-left:1%;">
                        (二)、飼養日齡：雙方於飼養28至30日齡前磅雞，經確認體重後，如成雞每台平均體重達 {{ $data['contract_details']['ok_to_die'] }} 公斤以上時，甲方即可全權處理抓雞事宜，乙方如未配合抓雞事宜，則依電宰公會辦法扣款之。
                    </p>
                    <p style="margin-left:1%;">
                        (三)、交雞程序：乙方應依甲方指定之時間內備妥足人力，將成雞交付於運雞車上，由雙方會同過磅，抓雞工資由乙方支付。
                    </p>
                    <p style="margin-left:1%;">
                        (四)、藥物殘留：
                    </p>
                        <p style="margin-left:3%;">
                            1、乙方於入日起至21日之投需符合衛生署編印之飼料添加物使用管理手冊，21日齡後之投藥，需取得甲方之書面同意。
                        </p>
                        <p style="margin-left:3%;">
                            2、為防止藥物殘留，乙方須於入雛21日齡後使用無藥物的N肉雞3號飼料。
                        </p>
                    <p style="margin-left:1%;">
                        (五)、養期間內甲方得不定時派員進場服務。如有雞隻異常死亡現象，乙方應立即通知甲方人員到場認證。
                    </p>
                    <p style="margin-left:1%;">
                        (六)、乙方需逐日填寫記錄表供甲方人員參閱，並於每批出清後48小時內將飼養管理記錄表彙整完成遞交甲方。
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
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="ml-4" style="margin-left:3%;">
                    <p>第二條、毛雞驗收辦法：</p>
                    <p style="margin-left:1%;">
                        (一)、進廠毛雞須符合驗收標準，以單台車為標準。
                    </p>
                    <p style="margin-left:1%;">
                        (二)、乙方接獲甲方通知後，應於出雞前六小時實施停料供水，不得強制餵食以符合屠宰衛生規定。
                    </p>
                </ol>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="ml-4" style="margin-left:3%;">
                    <p>第三條、有下列情形之一，甲方有權終止合作關係，乙方不得異議：</p>
                    <p style="margin-left:1%;">
                        (一)、乙方連續兩批飼養育成率低於 {{ $data['contract_details']['breeding_rate'] }}%。
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
                            2、如因所飼養白肉雞不幸感染禽流感等疫情，依法應予撲殺時，除本契約應提前終止外;倘乙方因而得受领政府相關單位補助款時，乙方除同意委任甲方代為领取外，
                            所领款並以甲方為第一順位受償者，即由甲方先行扣除雛雞款、飼料總款後，餘款始歸乙方受償，並簽具委任書及受償順位同意書。
                        </p>
                </ol>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="ml-4" style="margin-left:3%;">
                    <p>第四條、其他約定事項：</p>
                    <p style="margin-left:1%;">
                        (一)、毛雞統出後乙方應提具農民產品（物）收據供作甲方之進货證明；甲方應於毛雞出售後15日工作天內核發給付乙方之收益。
                    </p>
                    <p style="margin-left:1%;">
                        (二)、乙方同意依每萬羽伍拾萬元整之比例面額開立本票乙張給予甲方，如己方有違約或積欠甲方未清償之款項時，甲方可隨時無條件提示本票請求兌現，乙方不得異議。
                    </p>
                    <p style="margin-left:1%;">
                        (三)、乙方同意本契約所生相關之帳款往來，指定下列匯款銀行與帳號供甲方付款之用。
                    </p>
                </ol>    
                </div>
            </td>
        </tr>

        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center ml-4" style="word-wrap: break-word; white-space: normal; margin-left:3%;">
                    <p>
                        <font color="red">*</font>
                        <font color="orange"> 乙方同意出售電宰廠雞隻，依電宰廠收購之不良雞隻扣款作業標準:</font>
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center ml-4" style="word-wrap: break-word; white-space: normal; margin-left:3%;">
                    <p style="margin-left:1%;">
                        一、電宰業毛雞標準體重需求：{{ $data['contract_details']['Electric_industry_weight_1'] }} KG/隻 ～ {{ $data['contract_details']['Electric_industry_weight_2'] }} KG/隻。
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center ml-4" style="word-wrap: break-word; white-space: normal; margin-left:3%;">
                    <font color="orange">
                    <p style="margin-left:1%;">
                        二、超大雞部份：
                    </p>
                    <p style="margin-left:3%;">
                        (1)、{{ $data['contract_details']['contract_big_chicken_wieght_1'] }} KG ～ {{ $data['contract_details']['contract_big_chicken_wieght_2'] }} KG 扣超大雞 {{ $data['contract_details']['contract_big_chicken_price_1'] }} 元/台斤。
                    </p>
                    <p style="margin-left:3%;">
                        (2)、{{ $data['contract_details']['contract_big_chicken_wieght_3'] }} KG ～ {{ $data['contract_details']['contract_big_chicken_wieght_4'] }} KG 扣超大雞 {{ $data['contract_details']['contract_big_chicken_price_2'] }} 元/台斤。
                    </p>
                    <p style="margin-left:3%;">
                        (3)、{{ $data['contract_details']['contract_big_chicken_wieght_5'] }} KG ～ {{ $data['contract_details']['contract_big_chicken_wieght_6'] }} KG 扣超大雞 {{ $data['contract_details']['contract_big_chicken_price_3'] }} 元/台斤。
                    </p>
                    </font>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center ml-4" style="word-wrap: break-word; white-space: normal; margin-left:3%;">
                    <p style="margin-left:1%;">
                        三、超小雞部份：依不良雞作業標準，嘉義以南參照如下述，嘉義以北則採雙方協議，基礎以扣除客戶負擔部分，剩餘扣款由雙方各半分擔。
                    </p>
                    <p style="margin-left:3%;">
                        {{ $data['contract_details']['contract_little_chicken_wieght_0'] }} KG以下 扣超小雞 {{ $data['contract_details']['contract_little_chicken_price_0'] }} 元/台斤。
                    </p>
                </div>
            </td>
        </tr>
        <br>
    </tbody>
</table>

{{-- --------------------------臭爪smelly-------------------------- --}}
<font color="orange">
<table class="max-w-full mx-auto">
    <thead>
        <tr>
            <th colspan="4" style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                    <p style="margin-left:1%;">
                        3.1 臭爪部份：抽測20%以下不扣款，20%以上依照下列方式扣款。
                    </p>
                </div>            
            </th>
        </tr>
        <tr>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>抽測</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>總扣款</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>公司吸收</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>實際扣款</p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_0'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>不扣款</p>
                </div>
            </td>
            <td></td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>不扣款</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_1-1'] }}% ～ {{ $data['contract_details']['contract_SmellyClaw_%_1-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_SmellyClaw_deduction_1-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_absorb_1'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_deduction_1-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_2-1'] }}% ～ {{ $data['contract_details']['contract_SmellyClaw_%_2-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_SmellyClaw_deduction_2-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_absorb_2'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_deduction_2-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_3-1'] }}% ～ {{ $data['contract_details']['contract_SmellyClaw_%_3-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_SmellyClaw_deduction_3-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_absorb_3'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_deduction_3-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_4-1'] }}% ～ {{ $data['contract_details']['contract_SmellyClaw_%_4-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_SmellyClaw_deduction_4-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_absorb_4'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_deduction_4-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_%_5'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_SmellyClaw_deduction_5-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_absorb_5'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_SmellyClaw_deduction_5-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</font>
{{-- --------------------------臭爪smelly-------------------------- --}}
<div style="margin-top: 2px; margin-bottom: 2px;"></div> <!-- 在上下创建间隙 -->
{{-- --------------------------皮膚炎-------------------------- --}}
<font color="orange">
<table class="max-w-full mx-auto">
    <thead>
        <tr>
            <th colspan="4" style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                    <p style="margin-left:1%;">
                        3.2 皮膚炎（結痂）：抽測10%以下不扣款，10%以上依照以下方式扣款。
                    </p>
                </div>            
            </th>
        </tr>
        <tr>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>抽測</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>總扣款</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>公司吸收</p>
                </div>
            </th>
            <th style="width:25%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>實際扣款</p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_0'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>不扣款</p>
                </div>
            </td>
            <td></td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>不扣款</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_1-1'] }}% ～ {{ $data['contract_details']['contract_Dermatitis_%_1-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_Dermatitis_deduction_1-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_absorb_1'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_deduction_1-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_2-1'] }}% ～ {{ $data['contract_details']['contract_Dermatitis_%_2-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_Dermatitis_deduction_2-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_absorb_2'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_deduction_2-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_3-1'] }}% ～ {{ $data['contract_details']['contract_Dermatitis_%_3-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_Dermatitis_deduction_3-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_absorb_3'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_deduction_3-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_4-1'] }}% ～ {{ $data['contract_details']['contract_Dermatitis_%_4-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_Dermatitis_deduction_4-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_absorb_4'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_deduction_4-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_%_5'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_Dermatitis_deduction_5-1'] }} 元/台斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_absorb_5'] }} 元/斤</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_Dermatitis_deduction_5-2'] }} 元/斤</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</font>
{{-- --------------------------皮膚炎-------------------------- --}}
<div class="page-break"></div>
{{-- --------------------------臭胸-------------------------- --}}
<font color="orange">
<table class="max-w-full mx-auto">
    <thead>
        <tr>
            <th colspan="2" style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                    <p style="margin-left:1%;">
                        五、臭胸部份：20%以下不扣款，20%以上依照以下方式扣款。
                    </p>
                </div>            
            </th>
        </tr>
        <tr>
            <th style="width:50%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>抽測</p>
                </div>
            </th>
            <th style="width:50%; text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>總扣款</p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_0'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>不扣款</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_1-1'] }}% ～ {{ $data['contract_details']['contract_smelly_breasts_%_1-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_smelly_breasts_deduction_1'] }} 元/台斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_2-1'] }}% ～ {{ $data['contract_details']['contract_smelly_breasts_%_2-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_smelly_breasts_deduction_2'] }} 元/台斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_3-1'] }}% ～ {{ $data['contract_details']['contract_smelly_breasts_%_3-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_smelly_breasts_deduction_3'] }} 元/台斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_4-1'] }}% ～ {{ $data['contract_details']['contract_smelly_breasts_%_4-2'] }}%</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_smelly_breasts_deduction_4'] }} 元/台斤</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>{{ $data['contract_details']['contract_smelly_breasts_%_5'] }}%以下</p>
                </div>
            </td>
            <td style="text-align: center; border: 1px solid black;">
                <div class="relative flex items-center mt-4 mb-4">
                    <p>扣 {{ $data['contract_details']['contract_smelly_breasts_deduction_5'] }} 元/台斤</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</font>
{{-- --------------------------臭胸-------------------------- --}}
<div style="margin-top: 2px; margin-bottom: 2px;"></div> <!-- 在上下创建间隙 -->

<table class="max-w-full mx-auto table-fixed">
    <tbody>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="ml-4" style="margin-left:3%;">
                    <p style="margin-left:1%;">
                        六、飼料殘留：毛雞羽數 × 抽測毛雞飼料殘留比率% × 每羽飼料殘留量(g)/1000g
                    </p>
                        <p style="margin-left:3%;">
                            例：3360隻 × 25% × 50g ÷ 1000g = 42kg 
                        </p>
                            <P style="margin-left:7%;">
                                42kg ÷ 0.6 × 19元/斤 = 1330元
                            </P>
                    
                    <p style="margin-left:1%;">
                        八、病雞：防檢局駐廠獸醫站實際剔除羽數×毛雞平均重。
                    </p>
                        <p style="margin-left:3%;">
                            例：100隻 × 1.6kg × 19元/斤 ÷ 0.6 = 5067元
                        </p>

                    <p style="margin-left:1%;">
                        九、心肫剔除：防檢局駐廠獸醫站實際剔除之重量。
                    </p>
                        <p style="margin-left:3%;">
                            例：10kg ÷ 0.6 × 19元/斤=317元
                        </p>

                    <p style="margin-left:1%;">
                        十、關節炎：毛雞總重（kg）× 抽測不良率棒腿產出率13.02%
                    </p>
                        <p style="margin-left:3%;">
                            例：6460kg × 15% × 13.02% = 126kg
                        </p>
                            <p style="margin-left:7%;">
                                126kg × (90-50) = 5040元
                            </p>

                    <p style="margin-left:1%;">
                        十一、腹水部份：經篩選後依實際重量全部扣款。
                    </p>

                    <p style="margin-left:1%;">
                        十二、毛雞含水：
                    </p>
                        <p style="margin-left:3%;">
                            (1)、小雨扣實重1%，中雨扣實重3%，雨扣實重4%（大、中、小雨由相關人員認定之）。
                        </p>
                        <p style="margin-left:3%;">
                            (2)、天氣炎熱時，應在產地總重過完磅才可淋水。
                        </p>
                    
                    <p style="margin-left:1%;">
                        十三、死雞容許量：
                    </p>
                        <p style="margin-left:3%;">
                            (1)、熱季（{{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_SummerMonth_Beginning'] }}月 ～ {{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_SummerMonth_End'] }}月）
                            每車 {{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_Summer'] }} 隻。
                        </p>
                        <p style="margin-left:3%;">
                            (2)、涼季（{{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_Winter_Beginning'] }}月 ～ {{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_Winter_End'] }}月）
                            每車 {{ $data['contract_details']['contract_Tolerance-Of-DeadChicken_Winter'] }} 隻。
                        </p>
                    
                    <p style="margin-left:1%;">
                        十四、以上所列均以每車次為單位。
                    </p>

                    <p style="margin-left:1%;">
                        十五、已派車卻無雞可抓或隻數不足者，依實際情況由賣方補足買方運費。
                    </p>

                    <p style="margin-left:1%;">
                        十六、自設地磅校磅差異於±30kg/車者，仍以±30kg/車為收購標準。
                    </p>
                </ol>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                    <p>〔飼養作業規定〕</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="list-decimal ml-4" style="margin-left:3%;">
                    <li>
                        <p>飼養隻數標準：</p>
                    </li>

                    <div class="flex justify-center">
                        <table class="text-center" style="width: 90%;">
                            <thead>
                                <tr>
                                    <th style="width: 20%; text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center justify-center">
                                            <p>雞種</p>
                                        </div>            
                                    </th>
                                    <th style="width: 40%; text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center justify-center">
                                            <p>期間</p>
                                        </div>            
                                    </th>
                                    <th style="width: 40%; text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center justify-center">
                                            <p>數量（羽/每坪）</p>
                                        </div>            
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="2" style="text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center mt-4 mb-4">
                                            <p>白肉雞</p>
                                        </div>
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center mt-4 mb-4">
                                            <p>夏（三至九月）</p>
                                        </div>
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center mt-4 mb-4">
                                            <p>{{ $data['contract_details']['feed_work_rule_1_1_1'] }} ± {{ $data['contract_details']['feed_work_rule_1_1_2'] }}%</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center mt-4 mb-4">
                                            <p>冬（十至二月）</p>
                                        </div>
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                        <div class="relative flex items-center mt-4 mb-4">
                                            <p>{{ $data['contract_details']['feed_work_rule_1_2_1'] }} ± {{ $data['contract_details']['feed_work_rule_1_2_2'] }}%</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <li>
                        <p>乙方入雛時間或入雛前十天，應通知甲方數量，並經甲乙雙方協定後確定，如有變更需經甲方同意。</p>
                    </li>
                    <li>
                        <p>甲乙雙方協議之飼養天數：雞隻重達 {{ $data['contract_details']['feed_work_rule_3_1'] }} 公斤至 {{ $data['contract_details']['feed_work_rule_3_2'] }} 公斤（每車）或飼養天數達三十日齡，即由甲方指定之電宰廠處理抓雞事宜，最長不得逾三十八日齡。</p>
                    </li>
                    <li>
                        <p style="word-wrap: break-word; white-space: normal;">
                        為防止藥物殘留，乙方於入雛日起至21日齡之加藥需符合『行政院農業委員會動植物防疫檢疫局』編印之「飼料添加動物用藥品安全管理手冊」規定。21日齡後之投藥，需取得甲方之書面同意。
                        另乙方同意與甲方簽訂切結書如附表（六），以嚴格遵守出雞前七天至十天停藥期之約定。
                        </p>
                    </li>
                </ol>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="relative flex items-center justify-start mt-4 mb-4 ml-4">
                    <p>〔出雞作業規定〕</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="word-break: break-all; overflow-wrap: break-word;">
                <div class="relative flex items-center justify-center" style="word-wrap: break-word; white-space: normal;">
                <ol class="list-decimal ml-4" style="margin-left:3%;">
                    <li>
                        <p>出雞日期：甲方必須在25天至28天磅雞，確認體重後，於出雞前三日通知乙方出雞時間。</p>
                    </li>
                    <li>
                        <p>交雞程序：乙方應依甲方合作電宰廠指定時間配合抓雞，由雙方會同過磅抓雞，工資由乙方自付。</p>
                    </li>
                    <li>
                        <p>出雞前餵飼之控制：乙方應在甲方通知抓雞時間八小時前停止餵飼，以確保屠宰衛生。</p>
                    </li>
                    <li>
                        <p>每批雞隻遇有有下列情形之一，甲方有權決定不協助出售作業：</p>
                    </li>

                        <ol class="ml-4" style="list-style-type: none;">
                            <li>
                                <p>(1).逾飼養天數，每隻平均重量低於 {{ $data['contract_details']['chick_out_rule_4'] }} 公斤。</p>
                            </li>
                            <li>
                                <p>(2).藥物投放使用不符規定時。</p>
                            </li>                    
                        </ol>
                </ol>
                </div>
            </td>
        </tr>
        <br>
    </tbody>
</table>
</body>
