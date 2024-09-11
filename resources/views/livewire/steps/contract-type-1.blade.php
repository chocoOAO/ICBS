<table class="w-full table-border">
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
                                                    wire:model.lazy="extraData.chicken_weight_kg_1_1" type="text"
                                                    placeholder="1.75"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_1_2" type="text"
                                                    placeholder="1.89">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_2_1" type="text"
                                                    placeholder="1.90"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_2_2" type="text"
                                                    placeholder="1.99">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_3_1" type="text"
                                                    placeholder="2.0"> -
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_3_2" type="text"
                                                    placeholder="2.10">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-14 text-center"
                                                    wire:model.lazy="extraData.chicken_weight_kg_4_1" type="text"
                                                    placeholder="2.11">以上
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%;" align="left">
                                                <p>收購價(新台幣/斤)</p>
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_weight_price1" type="text"
                                                    placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_weight_price2" type="text"
                                                    placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_weight_price3" type="text"
                                                    placeholder="27.3">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_weight_price4" type="text"
                                                    placeholder="27.3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%;" align="left">
                                                <p>規格補助(元/羽)</p>
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_allowance_price1" type="text"
                                                    placeholder="2.0">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_allowance_price2" type="text"
                                                    placeholder="1.0">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_allowance_price3" type="text"
                                                    placeholder="0.5">
                                            </td>
                                            <td style="width:20%;">
                                                <input class="form-control inline-block w-auto text-center"
                                                    wire:model.lazy="extraData.chicken_allowance_price4" type="text"
                                                    placeholder="0.0">
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
                                        wire:model.lazy="extraData.contract1_unamed_1" type="text" placeholder="27.3"
                                        style="width: 5%; text-align:center">
                                    時，採
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.dividend" type="text" placeholder="4/6"
                                        style="width: 5%; text-align:center">
                                    分紅獎勵。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    出雞重量
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.contract1_unamed_2" type="text" placeholder="1.75">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.contract1_unamed_2_1" type="text" placeholder="2.0">
                                    KG時，於飼養裝況正常情形，基於電宰廠屠宰需求而排定出售，且育成率需達96%以上，使補助規格雞。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    若發現乙方有盜賣毛雞圖利情事經查證屬實者，甲方得逕行認定該批育成率為96%，低於該育成率之差數以每羽新台幣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.contract1_unamed_3" type="text" placeholder="90">
                                    元向乙方科處罰金元向乙方科處罰金。
                                </p>
                                <p>
                                    <font color="red">*</font>乙方同意於契約期間內使用甲方所提供之飼料，不得購用其他其他廠牌飼料。
                                </p>
                                <p>
                                    <font color="red">*</font>
                                    肉價：如出雞當日聯合報所載中華民國養雞協會肉雞產地交易行情表
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.contract1_unamed_4_1" type="text"
                                        placeholder="1.75">
                                    公斤至
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.contract1_unamed_4_2" type="text"
                                        placeholder="1.95">
                                    公斤隻平均報價【（北部＋中部＋嘉南）除３】。
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <font color="red">*</font>不良雞隻扣款作業標準：
                                </p>
                                <p style="margin-left:1%;">一、電宰業毛雞標準體重需求：
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_1_1" type="text" placeholder="1.75">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_1_2" type="text"
                                        placeholder="1.95">kg/隻。
                                </p>
                                <p style="margin-left:1%;">二、超大雞部份：</p>
                                <p style="margin-left:3%;">(1)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_1_1" type="text" placeholder="2.30">
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_1_2" type="text" placeholder="2.20"> --}}
                                    kg以上(以進場批次均重，非單台車)，扣0.9元/斤。
                                </p>
                                <p style="margin-left:3%;">(2)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_2" type="text" placeholder="2.251">
                                    kg以上上(以進場批次均重，非單台車)，扣0.6元/斤。
                                    {{-- <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_2_3" type="text" placeholder="議價">
                                    。 --}}
                                </p>
                                <p style="margin-left:1%;">三、超小雞部份：依不良雞作業標準。</p>
                                {{--<p style="margin-left:3%;">
                                     (1)、
                                    { <font color="black">1.75</font>
                                    <input class="form-control inline-block w-14 text-center"
                                    wire:model.lazy="extraData.debit_price_3_1_1" type="text" placeholder="1.70">
                                    〜
                                    <font color="black">1.65</font>
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_1_2" type="text" placeholder="1.65">
                                    kg扣
                                    <font color="black">0.3</font>
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_1_3" type="text"
                                        placeholder="0.3">
                                    元/台斤。
                                </p>
                                <p style="margin-left:3%;">(2)、
                                    <font color="black">1.64</font>

                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_2_1" type="text" placeholder="1.64">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_2_2" type="text" placeholder="1.60">
                                    <font color="black">1.60</font>

                                    kg扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_2_3" type="text"
                                        placeholder="1.0">
                                    1.0 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(3)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_3_1" type="text" placeholder="1.59">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_3_2" type="text" placeholder="1.55">
                                    kg扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_3_3" type="text"
                                        placeholder="2.0">元/台斤。
                                    1.59 〜 1.55 kg扣 2.0 元/台斤。
                                </p>
                                <p style="margin-left:3%;">(4)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_4_1" type="text" placeholder="1.54">
                                    〜
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_4_2" type="text" placeholder="1.51">
                                    kg扣
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_4_3" type="text"
                                        placeholder="4.0">元/台斤。
                                    1.54 〜 1.51 kg扣 4.0 元/台斤。
                                </p>
                                <p style="margin-left:3%;">
                                    (5)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_5_1" type="text" placeholder="1.49">
                                    kg以下，依當日報打
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_5_2" type="text" placeholder="6">折計價。
                                    1.49 kg以下，依當日報打六折計價。
                                </p>
                                <p style="margin-left:3%;">(6)、
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_6_1" type="text" placeholder="1.40">
                                    kg以下毛雞不得上車。

                                    1.40 kg以下毛雞不得上車。
                                </p>
                                <p style="margin-left:3%;">
                                    (7)、經屠宰後去爪全雞，屠體重在
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_7_1" type="text" placeholder="1.80">
                                    kg以下換算為毛雞重(屠體率68%)依實際毛雞價格打
                                    <input class="form-control inline-block w-14 text-center"
                                        wire:model.lazy="extraData.debit_price_3_7_2" type="text" placeholder="6">折計價。
                                    1.80 kg以下換算為毛雞重(屠體率68%)依實際毛雞價格打六折計價。
                                </p>
                                <p style="margin-left:3%;">(8)、無法吊掛隻超小雞依實際重量全數扣款。</p> --}}
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
                                <p style="margin-left:3%;">例：產出500kgx10.15%/0.6x19元=1607元</p>--}}
                                <p style="margin-left:1%;">
                                    六、飼料殘留：毛雞羽數ｘ抽測毛雞飼料殘留比率%ｘ每羽飼料殘留量(g)／1000g</p>
                                <p style="margin-left:3%;">例：3360
                                    隻*25%X50g/1000g=42kg</p>
                                <P style="margin-left:7%;">42kg/0.6x19元/斤=1330元</p>
                                {{----------------------------皮膚炎----------------------------}}
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
                        (二)、飼養日齡:雙方於飼養28至30日齡前磅雞，經確認體重後，如成雞每台平均體重達
                        <input class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.ok_to_die" type="text" placeholder="1" required>
                        公斤以上時，甲方即可全權處理抓雞事宜，乙方如未配合抓雞事宜，則依電宰公會辦法扣款之。
                    </p>
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
                    <p style="margin-left:1%;">(一)、乙方連續兩批飼養育成率低於
                        <input class="form-control inline-block w-20 text-center" wire:model.lazy="extraData.breeding_rate"
                            type="text" placeholder="1.9" required>
                        %。</p>
                    <p style="margin-left:1%;">(二)、乙方連續兩批飼料換肉率高於
                        <input class="form-control inline-block w-20 text-center"
                            wire:model.lazy="extraData.feed_conversion_rate_1" type="text" placeholder="1.75"
                            step="0.01" required>
                        時;或一批飼料換肉率高於
                        <input class="form-control inline-block w-20 text-center"
                            wire:model.lazy="extraData.feed_conversion_rate_2" type="text" step="0.01"
                            placeholder="1.9" required>時。
                    </p>
                    <p style="margin-left:1%;">
                        (三)、乙方藥物投放使用不依規定或經驗出禁藥者。如甲方因此受有損害，並得請求損害賠償。</p>
                    <p style="margin-left:1%;">(四)、乙方飼養管理方法不符甲方要求標準或經甲方要求而未見改善者。</p>
                    <p style="margin-left:1%;">(五)、合約有效期間內</p>
                    <p style="margin-left:3%;">1、如遇天災或人力不可抗拒事由，致無法續行時，甲方有權終止合約關係。</p>
                    <p style="margin-left:3%;">
                        2、如因所飼養白肉雞不幸感染禽流感等疫情，依法應予撲殺時，除本契約應提前終止外;倘乙方因而得受領政府相關單位補助款時，乙方除同意委任甲方代為領取外，所領款並以甲方為第一順位受償者，即由甲方先行扣除雛雞款、飼料總款後，餘款始歸乙方受償，並簽具委任書及受償順位同意書。
                    </p>
                    <p></p>第四條、其他約定事項:
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

<div class="flex justify-between mt-2">
    {{-- <button class="btn-primary" type="button" wire:click="prev">上一步</button> --}}
    @if (isset($isEdit) && $isEdit)
        <button class="btn-primary" type="submit">儲存合約</button>
    @elseif ($isView)
        <button class="btn-primary" type="submit">返回合約列表</button>
    @else
        <button class="btn-primary" type="submit">建立合約</button>
    @endif
</div>
