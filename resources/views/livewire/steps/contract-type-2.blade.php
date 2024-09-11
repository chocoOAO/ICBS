<table class="w-100">
        <tbody>
            <tr>
                <td>
                    <h2 class="text-xl text-gray-800 leading-tight text-center">代養合約書計價方式</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="w-full table-border h-full">
                        <tbody>
                            <tr>
                                <td style="width: 3%; writing-mode: vertical-lr; text-align: center;">
                                    飼養報酬對照表
                                </td>
                                <td colspan="4">
                                    <table class="table-border w-full h-full">
                                        <tbody>
                                        <tr align="center">
                                                <td style="width:8%;" align="left">
                                                    <p>毛雞規格(KG)</p>
                                                </td>
                                                <td style="width:12%;">
                                                    <!-- 自定義寬度 style="width: 100px;" -->
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_1_1" min=0 step="any"> 以下
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_2_1" min=0 step="any"> ～
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_2_2" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_3_1" min=0 step="any"> ～
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_3_2" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_4_1" min=0 step="any"> ～
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_4_2" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_5_1" min=0 step="any"> ～
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_5_2" min=0 step="any">
                                                </td>

                                                <!-- @dump($extraData) 輸出extraData數據-->
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_7_1" min=0 step="any">
                                                    ～
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_7_2" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_weight_kg_6_1" min=0 step="any">
                                                    以上
                                                </td>
                                            </tr>
                                            <tr align="center">
                                                <td style="width:12%;" align="left">
                                                    <p>飼養報酬(元/羽)</p>
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price1" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price2" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price3" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price4" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price5" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price6" min=0 step="any">
                                                </td>
                                                <td style="width:12%;">
                                                    <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.chicken_allowance_price7" min=0 step="any">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            <tr>
                                <td colspan="5">
                                    <p>
                                        <font color="red">*</font>育成率97%以上，獎勵金
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_1" min="0" step="any">
                                        (元/羽)
                                    </p>
                                    <p>
                                        <font color="red">*</font><font color="orange">老客戶續約配合+
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_2" min="0" step="any">
                                        (元/羽)。</font>
                                    </p>
                                    <p>
                                        <font color="red">*</font>重效差達
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_3_1" min="0" step="any">
                                        %以上+
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_3_2" min="0" step="any">(元/羽)。
                                    </p>
                                    <p>
                                        <font color="red">*</font>飼養報酬計算羽數以實際上車羽數扣除電宰損失羽數(死雞+剔除雞)計算。
                                    </p>
                                    <p>
                                        <font color="red">*</font>
                                        電宰損失羽數(死雞+剔除雞)如高於上車羽數1%時，育成率計算基準以實際上車羽數扣除電宰損失羽數(死雞+剔除雞)後之實際羽數計算。
                                    </p>
                                    <p>
                                        <font color="red">*</font>
                                        配合提供符合產銷履歷認證牧場者,依實際上車羽數扣除電宰損失羽數(死雞+剔除雞)獎勵回饋,每羽
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_4" min="0" step="any">元。
                                    </p>
                                    <p>
                                        <font color="red">*</font>體重以全場出售平均重計算。
                                    </p>
                                    <p>
                                        <font color="red">*</font>
                                        正常飼養狀況下,因電宰廠排雞需求,出售均重低於
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_5_1" min="0" step="any">
                                        KG(含)以下時,以
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_5_2" min="0" step="any"> ～
                                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.contract2_unamed_5_3" min="0" step="any">KG之飼養報酬計算。
                                    </p>
                                    <p>
                                        <font color="red">*</font>
                                        雛雞羽數確認以入雛後第七日齡為原則，但如雛雞有異常汱損狀況，得延後至14日齡前確認，並以確認羽數做為育成率與生產指數依據。
                                    </p>
                                    <p>
                                        <font color="red">*</font>
                                        <font color="blue">若發現乙方有盜賣毛雞圖利情事經查證屬實者，甲方得逕行認定該批育成率為96%，低於該育成率之差數以每羽新台幣（下同）90元向乙方科處罰金。</font>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                            <td colspan="4">
                                <table class="table-border w-full">
                                    <tbody>
                                        <tr align="center">
                                        <td style="width:33%;" align="left">
                                        <div style="display: flex; align-items: center; margin-left: 10px;">
                                            <p style="margin: 0; margin-right: 10px; line-height: 1; white-space: nowrap;">毛雞重</p>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_0" min=0 step="any">
                                            <span style="margin: 0 4px;">～</span>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_1" min=0 step="any">
                                            <span style="margin-left: 20px; margin-right: 20px;">Kg</span>
                                        </div>
                                        </td>
                                            <td style="width:33%;" align="left">
                                            <div style="display: flex; align-items: center;">
                                                <p style="margin-left: 20px; margin-right: 10px; line-height: 1; white-space: nowrap;">飼效</p>
                                                <input type="number" class="form-control inline-block w-1/4 text-center" wire:model.lazy="extraData.feed_efficiency" min=0 step="any">
                                                <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">以下</p>
                                            </div>
                                            </td>
                                            <td style="width:33%;" align="left" colspan="2">
                                            <div style="display: flex; align-items: center;">
                                                <p style="margin-left: 20px; margin-right: 10px; line-height: 1; white-space: nowrap;">獎勵每羽</p>
                                                <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_reward1" placeholder="數字欄位，使用者自填" min=0 step="any">
                                                <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">元</p>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                        <td style="width:25%;" align="left">
                                            <div style="display: flex; align-items: center;">
                                                <p style="padding-left: 10px; line-height: 1; white-space: nowrap;">績優客戶</p>
                                            </div>
                                        </td>
                                        <td style="width:33%;" align="left">
                                        <div style="display: flex; align-items: center; margin-left: 10px;margin-top: 2px;">
                                            <p style="margin: 0; margin-right: 10px; line-height: 1; white-space: nowrap;">毛雞重</p>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_2" min=0 step="any">
                                            <span style="margin: 0 4px;">～</span>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_3" min=0 step="any">
                                            <span style="margin-left: 20px;margin-right: 20px;">Kg</span>
                                        </div>
                                        </td>
                                            <td style="width:33%;" align="left" colspan="2">
                                            <div style="display: flex; align-items: center;">
                                                <p style="margin-left: 20px; margin-right: 10px; line-height: 1; white-space: nowrap;">獎勵每羽</p>
                                                <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.live_chicken_weight_reward2" placeholder="數字欄位，使用者自填" min=0 step="any">
                                                <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">元</p>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                        <td colspan="2" style="width:33%;" align="left">
                                        <div style="display: flex; align-items: center; margin-left: 10px;margin-top:-20px;">
                                            <p style="margin: 0; margin-right: 15px; line-height: 1; white-space: nowrap;">臭爪</p>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.stinking_claw" min=0 step="any">
                                            <span style="margin-left: 10px;margin-right: 10px;">%(含)</span>
                                            <select class="form-control inline-block" wire:model.lazy="extraData.stinking_claw_type" style="margin-right: 10px;">
                                                <option value="non-choose">0.未選擇</option> <!-- 用於指示用戶需要選擇一個值 -->
                                                <option value="reward" >1.以下獎勵</option>
                                                <option value="deduction">2.以上扣款</option>
                                            </select>
                                        </div>
                                        </td>
                                            <td style="width:33%; " align="left">
                                            <div style="display: flex; align-items: center; margin-top:5px;">
                                                <p style="margin-left: 20px; margin-right: 10px; line-height: 1; white-space: nowrap;">每羽</p>
                                                <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.stinking_claw_reward" placeholder="數字欄位，使用者自填" step="any">
                                                <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">元</p>
                                            </div>
                                            <p style="color: red; font-size: small; margin-left: 20px;">若為扣款,請打負數 Ex:-0.1</p>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                        <td colspan="2" style="width:33%;" align="left">
                                        <div style="display: flex; align-items: center; margin-left: 10px;margin-top:-20px;">
                                            <p style="margin: 0; margin-right: 15px; line-height: 1; white-space: nowrap;">臭胸</p>
                                            <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.stinking_chest" min=0 step="any">
                                            <span style="margin-left: 10px; margin-right: 10px;">%(含)</span>
                                            <select class="form-control inline-block" wire:model.lazy="extraData.stinking_chest_type" style="margin-right: 10px;">
                                                <option value="non-choose">0.未選擇</option> <!-- 用於指示用戶需要選擇一個值 -->
                                                <option value="reward">1.以下獎勵</option>
                                                <option value="deduction">2.以上扣款</option>
                                            </select>
                                        </div>
                                        </td>
                                            <td style="width:33%; " align="left">
                                            <div style="display: flex; align-items: center;margin-top:5px;">
                                                <p style="margin-left: 20px; margin-right: 10px; line-height: 1; white-space: nowrap;">每羽</p>
                                                <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.stinking_chest_reward" placeholder="數字欄位，使用者自填" step="any">
                                                <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">元</p>
                                            </div>
                                            <p style="color: red; font-size: small; margin-left: 20px;">若為扣款,請打負數 Ex:-0.1</p>
                                            </td>
                                        </tr>
                                        @for ($i = 0; $i < 6; $i++)
                                            @php
                                                $descriptionType = 'extra_description_' . $i . '_type'; // 在每次循环中构建 $descriptionType 变量，并在 select 元素中正确引用它。这样可以确保在每次循环中都能正确处理动态变量。
                                            @endphp
                                            <tr align="center">
                                                <td colspan="2" style="width:75%;" align="left">
                                                    <div style="display: flex; align-items: center; margin-left: 10px;margin-top:-20px;">
                                                        <input type="text" class="form-control inline-block  text-center" style="width:80%;" wire:model.lazy="extraData.extra_description_{{ $i }}" placeholder="內容由使用者自行填入文字描述">
                                                        <select class="form-control inline-block " wire:model.lazy="extraData.extra_description_{{ $i }}_type" style="margin-left: 10px; margin-right: 10px; width:20%;">
                                                            <option value="non-choose">0.未選擇</option> <!-- 用於指示用戶需要選擇一個值 -->
                                                            <option value="reward">1.每羽</option>
                                                            <option value="deduction">2.每公斤</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td style="width:25%;" align="left">
                                                    <div style="display: flex; align-items: center; margin-top:5px;">
                                                        <input type="number" class="form-control inline-block w-1/5 text-center" wire:model.lazy="extraData.extra_description_{{ $i }}_reward" style="margin-left: 20px" placeholder="數字欄位，使用者自填" step="any">
                                                        <p style="margin-left: 10px; margin-right: 10px; line-height: 1; white-space: nowrap;">元</p>
                                                    </div>
                                                    <p style="color: red; font-size: small; margin-left: 20px;">若為扣款,請打負數 Ex:-0.1</p>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="5">注意事項：</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <ol>
                                        <p>第一條、作業規定:</p>
                                        <p style="margin-left:1%;">
                                            (一)、入雛數認定:為乙方實際點收之總雛數(不含2%贈予);如一週內死亡與淘汰隻數超過2%之贈予數時或乙方對該幼雛品質有異議時得即時提出，經與該交雛之種雞場三方共同確認後協議處理。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (二)、飼養日齡:雙方於飼養28至30日齡前磅雞，經確認體重後，如成雞每台平均體重達
                                            <input type="number" class="form-control inline-block w-20 text-center"  wire:model.lazy="extraData.ok_to_die" placeholder="1" min=0 step="any" required>
                                            公斤以上時，甲方即可全權處理抓雞事宜，乙方如未配合抓雞事宜，則依電宰公會辦法扣款之。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (三)、交雞程序:乙方應依甲方指定之時間內備妥足人力，將成雞交付於運雞車上由雙方會同過磅，抓雞工資由乙方支付。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (四)、藥物殘留:
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
                                            (七)、貨物收受承諾:甲方指定運送飼料給乙方，送貨單內載明乙方為收貨人，並經乙方本人、家屬或受僱人在送貨單上簽收者，視同乙方本人收受。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (八)、毛雞出售後，未用畢之飼料，乙方需於三日內通知甲方收回。
                                        </p>
                                        <p>第二條、毛雞驗收辦法:</p>
                                        <p style="margin-left:1%;">
                                            (一)、進廠毛雞須符合驗收標準，<font color="orange">以單台車為標準。</font>
                                        </p>
                                        <p style="margin-left:1%;">
                                            (二)、乙方接獲甲方通知後，應於出雞前六小時實施停料供水，不得強制餵食以符合屠宰衞生規定。
                                        </p>
                                        <p>第三條、有下列情形之一，甲方有權終止合作關係，乙方不得異議:</p>
                                        <p style="margin-left:1%;">
                                            (一)、乙方連續兩批飼養育成率低於 
                                            <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.breeding_rate" placeholder="1.9" min=0 step="any" required>%。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (二)、乙方建續兩批飼料換肉率高於
                                            <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.feed_conversion_rate_1"  placeholder="1.75" min=0 step="any" required>
                                            時;或一批飼料換肉率高於
                                            <input type="number" class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.feed_conversion_rate_2" placeholder="1.9" min=0 step="any" required>時。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (三)、乙方藥物投放使用不依規定或經驗出禁藥者。如甲方因此受有損害，並得請求損害賠償。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (四)、乙方飼養管理方法不符甲方要求標準或經甲方要求而未見改善者。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (五)、合約有效期間內
                                        </p>
                                        <p style="margin-left:3%;">
                                            1、如遇天災或人力不可抗拒事由，致無法續行時，甲方有權終止合約關係。
                                        </p>
                                        <p style="margin-left:3%;">
                                            2、如因所飼養白肉雞不幸感染禽流感等疫情，依法應予撲殺時，除本契約應提前終止外;倘乙方因而得受領政府相關單位補助款時，乙方除同意委任甲方代為領取外，所領款並以甲方為第一順位受償者，即由甲方先行扣除雛雞款、飼料總款後，餘款始歸乙方受償，並簽具 <font color="orange"> 委任書及受償順位同意書</font>。
                                        </p>
                                        <p>
                                            第四條、其他約定事項:
                                        </p>
                                        <p style="margin-left:1%;">
                                            (一)、毛雞統出後乙方應提具農民產品(物)收據供作甲方之進貨證明;甲方應於毛雞出售後15日工作天內核發給付乙方之收益。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (二)、乙方同意依每萬羽伍拾萬元整之比例面額開立本票乙張給予甲方，如乙方有違約或積欠甲方未清償之款項時，甲方可隨時無條件提示本票請求兑現，乙方不得異議。
                                        </p>
                                        <p style="margin-left:1%;">
                                            (三)、乙方同意本契約所生相關之帳款往來，指定下列匯款銀行與帳號供甲方付款之用。
                                        </p>
                                        <p style="margin-left:1%;">
                                            <font color="blue">(四)、乙方同意甲方於合約有效期間，依個人資料保護法之規定蒐集、處理及利用乙方所提供之個人資料，並於詳閱後簽署同意書。</font>
                                        </p>
                                        <p style="margin-left:1%;">
                                            <font color="blue">(五)、本合約書壹式兩份，雙方各執壹份為憑。</font>
                                        </p>
                                        <p style="margin-left:1%;">
                                            <font color="blue">(六)、如有未盡事宜，得由雙方協議後變更之，並信守誠信交易聲明。</font>
                                        </p>
                                        <p style="margin-left:1%;">
                                            <font color="blue">(七)、因本合約所生訴訟，雙方同意以臺灣臺中地方法院為第一審管轄法院。</font>
                                        </p>
                                    </ol>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>


    <div class="flex justify-between mt-2">
        @if (isset($isEdit) && $isEdit)
            <button class="btn-primary" type="submit">儲存合約</button>
        @elseif ($isView)
            <button class="btn-primary" type="submit">返回合約列表</button>
        @else
            <button class="btn-primary" type="submit" wire:click="Call_getUserPassword(3)">建立合約</button>
        @endif
    </div>

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
