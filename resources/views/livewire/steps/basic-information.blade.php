<style>
    .dynamic-width {
        min-width: 20ch; /* 設定最小寬度，確保 <input> 元素的寬度不會因為數字輸入的長度而變小 */
    }
</style>

<div class="my-2 py-5 border-gray-200">
    <h2 class="text-xl text-gray-800 leading-tight text-center">白肉雞合作飼養合約書</h2>
</div>

<table class="max-w-full table-fixed">
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
                            <input class="form-control" style="width: 150%;" type="text" wire:model.lazy="data.m_NAME" id="A" required>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            乙方
                        </div>

                        @if($contractType == 3)
                            <div class="ml-3 text-sm">
                                @php
                                    $edit_m_KUNAG = isset($isEdit) && $isEdit && !$isCopy ? 1 : 0; // 判斷當前是否在編輯模式並且不是複製模式，如果是在編輯模式，則設置 $edit_m_KUNAG 為 1，否則為 0。
                                @endphp
                                @if (!(isset($data['id']))) <!--因為沒有id，所以可以判斷是在合約建立版面。 (都還沒建立哪來的id)-->
                                    <input class="form-control" style="width: 150%;" type="text" id="name_b" wire:model="data.name_b" wire:change="Verify_m_KUNAG()" required>
                                @else <!--反之，因為有id，可以判斷是在合約管理版面。 (至少要先建立後才會有id啊！)-->
                                    <input class="form-control" style="width: 150%; @if($edit_m_KUNAG) pointer-events: none; background-color: rgb(197, 197, 197); @endif;" type="text" id="name_b" wire:model="data.name_b" wire:change="Verify_m_KUNAG()" required> <!-- 要注意這裡是用name_b唷！ --> 
                                @endif
                            </div>
                            @if(isset($RemindMessage) && $RemindMessage != null)
                                <span>请核实数据</span>
                            @endif
                        @else
                            <div class="ml-3 text-sm">
                                @php
                                    if (auth()->user()->m_KUNAG) {
                                        $z_cus_kna1 = DB::table('z_cus_kna1s')
                                            ->where('m_KUNAG', auth()->user()->m_KUNAG)
                                            ->get()
                                            ->toArray();
                                    }
                                    else{
                                        $z_cus_kna1 = DB::table('z_cus_kna1s')
                                        ->get()
                                        ->toArray();
                                    }
                                    $edit_m_KUNAG = isset($isEdit) && $isEdit && !$isCopy ? 1 : 0;
                                @endphp
                                <select class="form-control" wire:model.lazy="data.m_KUNAG" style=" @if($edit_m_KUNAG) pointer-events: none; background-color: rgb(197, 197, 197); @endif" required>  <!-- pointer-events: none; 使得元素及其子元素不响应鼠标事件，如点击。 -->
                                    <option selected="selected" hidden {{ empty($data['m_KUNAG']) ? '' : 'disabled' }} >請選擇</option>
                                    @foreach ($z_cus_kna1 as $type => $value)
                                        <option value="{{ $value->m_KUNAG }}">
                                            {{ $value->m_NAME . $value->m_KUNAG }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
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
                            <input class="form-control" type="date" wire:model.lazy="data.begin_date" required>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="relative flex items-center">
                        <div class="flex items-center h-5 align-middle">
                            結束日期
                        </div>
                        <div class="ml-3 text-sm">
                            <input class="form-control" type="date" wire:model.lazy="data.end_date" required>
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
                <input class="form-control" type="number" id="order_quantity" wire:model.lazy="extraData.order_quantity" min=0 step=1 required>
            </td>
            <td colspan="2">
                <font color="red">*</font><font color="orange">約定入雛羽數合約期間內若甲方對於合約內容或條件有變動時，甲方得終止本合約。</font>
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>飼養地址
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="adress" wire:model.lazy="extraData.address" required>
            </td>
            <td colspan="2" rowspan="3">
                <p>
                    <font color="red">*</font>上述地點若為租用，乙方需提供雞舍及土地租賃契約書或土地使用權同意書。
                </p>
                @if ($contractType == 2)
                <p>
                    <font color="red">*</font>乙方不得於上述地點或周圍飼養非經甲方同意之家禽。
                </p>
                @endif

                @if ($contractType == 3)
                <p>
                    <font color="red">*</font><font color="blue">乙方不得將上述地點之外之飼養家禽，非經甲方同意不得出售於指定電宰廠。</font>
                </p>
                @endif
            </td>
        <tr>
            <td>
                飼養地段及飼號
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="feed_area" wire:model.lazy="extraData.feed_area" placeholder="飼養地段">
                <input class="form-control" type="text" id="feed_number" wire:model.lazy="extraData.feed_number" placeholder="飼號">
            </td>
        </tr>
        <tr>
            <td>
                <font color="red">*</font>飼養面積
            </td>
            <td colspan="2">
                <input class="form-control" type="text" id="area" wire:model.lazy="extraData.area" min="0" required>
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
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control" type="text" id="building_name1" wire:model.lazy="extraData.building_name1" required>
                        </td>
                        <td>
                            <input class="form-control" type="number" id="feed_amount1" wire:model.lazy="extraData.feed_amount1" min=0 stpe=1 required>
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
                <input class="form-control" type="number" id="per_batch_chick_amount" wire:model.lazy="extraData.per_batch_chick_amount" min=0 step=1 required>
            </td>
        </tr>
        <tr class="border-b">
            <td colspan="5">
                {{-- 新增/修改過的合約內容暫時以藍字顯示 --}}
                {{-- 新舊不一的內容暫時以橘字顯示 --}}
                @if ($contractType == 2)
                    <p>
                        <font color="red">*</font><font color="blue">依本合約約定飼養之雞隻，除甲方同意外，應全數交回甲方處理，或由甲方指定之屠宰場逕與乙方締結新合約，乙方無權處分。</font>
                    </p>
                    <p>
                        <font color="red">*</font><font color="blue">乙方同意於合約期間，由甲方提供入雛相關事宜，入雛日期由甲方安排。雛雞由甲方提供，費用由甲方支付，購買雛雞之折扣歸甲方所有。</font>
                    </p>
                    <p>
                        <font color="red">*</font><font color="blue">乙方同意提供並支付雞舍設備、飼養勞務與管理及一切相關之開支。</font>
                    </p>
                    <p>
                        <font color="red">*</font>為達合作飼養之目的，乙方同意自行提供疫苗、藥品、人工、設備及什支等費用。
                    </p>
                    <p>
                        <font color="red">*</font>乙方應遵守完全使用甲方提供『福壽牌』飼料之約定。
                    </p>
                @endif

                @if ($contractType == 3)
                    <font color="red">*</font>飼料議定單價(
                    <input class="form-control inline-block w-auto" type="date" wire:model.lazy="extraData.feeding_price_date" required>報價，散裝價)：肉雞一號每公斤
                    <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.chicken_n1_feeding_price" min=0 step="any" required>元，肉雞二號每公斤
                    <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.chicken_n2_feeding_price" min=0 step="any" required>元，肉雞三號每公斤
                    <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.chicken_n3_feeding_price" min=0 step="any" required>元，雛雞計價
                    <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.chicken_price" min=0 step="any" required>元/羽
                    <p>
                        <font color="red">*</font><font color="blue">乙方同意於契約期間內使用甲方所提供之飼料，不得購用其他廠牌飼料，飼料價格另訂之。</font>
                    </p>
                    <p>
                        <font color="red">*</font><font color="blue">合作飼養之雞隻，雙方同意由甲方指定之電宰廠全數收買，並由乙方開立農漁民收據予電宰廠。乙方同意由甲方向電宰廠收取雞隻款，扣除合約所載應扣款項後餘額再交付乙方。</font>
                    </p>
                    <p>
                        <font color="red">*</font><font color="blue">契約期間單價依本公司初次交易為報價基準，並依市場行情變動而隨時調整。</font>
                    </p>
                @endif

                @if ($contractType == 1) <!-- 停用的合約 -->
                    <p>
                        <font color="red">*</font>袋裝料每公斤加
                        <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.feeding_each_kg_plus_price" min=0 step="any" required>元。
                    </p>
                @endif
                
                @if ($contractType == 2)
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
                            <select class="form-control" wire:model.lazy="data.bank_name" required>
                                <option value="" selected="selected" hidden>請選擇</option>
                                <option>中華郵政</option>
                                <option>台灣銀行</option>
                                <option>台灣土地銀行</option>
                                <option>合作金庫商業銀行</option>
                                <option>第一商業銀行</option>
                                <option>華南商業銀行</option>
                                <option>彰化商業銀行</option>
                                <option>上海商業儲蓄銀行</option>
                                <option>台北富邦商業銀行</option>
                                <option>國泰世華商業銀行</option>
                                <option>中國輸出入銀行</option>
                                <option>中華開發工業銀行</option>
                                <option>兆豐國際商業銀行</option>
                                <option>高雄銀行</option>
                                <option>台灣工業銀行</option>
                                <option>台灣中小企業銀行</option>
                                <option>台中商業銀行</option>
                                <option>京城商業銀行</option>
                                <option>大台北商業銀行</option>
                                <option>華泰商業銀行</option>
                                <option>台灣新光商業銀行</option>
                                <option>陽信商業銀行</option>
                                <option>板信商業銀行</option>
                                <option>三信商業銀行</option>
                                <option>聯邦商業銀行</option>
                                <option>遠東國際商業銀行</option>
                                <option>元大商業銀行</option>
                                <option>永豐商業銀行</option>
                                <option>玉山商業銀行</option>
                                <option>萬泰商業銀行</option>
                                <option>台新國際商業銀行</option>
                                <option>大眾商業銀行</option>
                                <option>日盛國際商業銀行</option>
                                <option>安泰商業銀行</option>
                                <option>中國信託商業銀行</option>
                                <option>花旗商業銀行</option>
                                <option>美商美國銀行</option>
                                <option>泰國盤谷銀行</option>
                                <option>美商美國運通銀行</option>
                                <option>菲商菲律賓首都銀行</option>
                                <option>美商大通銀行</option>
                                <option>日商東海銀行</option>
                                <option>美商美國紐約梅隆銀行</option>
                                <option>新加坡商大華銀行</option>
                                <option>美商道富銀行</option>
                                <option>加拿大商多倫多道明銀行</option>
                                <option>新加坡商華聯銀行</option>
                                <option>澳美商波士頓銀行</option>
                                <option>美商夏威夷銀行</option>
                                <option>英商澳紐建利銀行</option>
                                <option>法商法國興業銀行</option>
                                <option>百利銀行</option>
                                <option>澳商澳盛銀行集團</option>
                                <option>渣打國際商業銀行</option>
                                <option>德商德意志銀行</option>
                                <option>美商信孚銀行</option>
                                <option>香港商東亞銀行</option>
                                <option>美商摩根大通銀行</option>
                                <option>加拿大商加拿大皇家銀行</option>
                                <option>新加坡商星展銀行</option>
                                <option>法商法國巴黎銀行</option>
                                <option>新加坡商新加坡華僑銀行</option>
                                <option>法商東方匯理銀行</option>
                                <option>斐商標準銀行</option>
                                <option>澳商澳洲國民銀行</option>
                                <option>加拿大商豐業銀行</option>
                                <option>美商加州聯合銀行</option>
                                <option>瑞士商瑞士銀行</option>
                                <option>荷蘭商安智銀行</option>
                                <option>加拿大商加拿大帝國商業銀行</option>
                                <option>美商美聯銀行</option>
                                <option>澳商澳盛銀行集團</option>
                                <option>美商富國銀行</option>
                                <option>日商三菱東京日聯銀行</option>
                                <option>比利時商比利時聯合銀行</option>
                                <option>法商佳信銀行</option>
                                <option>日商三井住友銀行</option>
                                <option>華南金融控股股份有限公司</option>
                                <option>富邦金融控股股份有限公司</option>
                                <option>中華開發金融控股股份有限公司</option>
                                <option>國泰金融控股股份有限公司</option>
                                <option>中國信託金融控股股份有限公司</option>
                                <option>永豐金融控股股份有限公司</option>
                                <option>玉山金融控股股份有限公司</option>
                                <option>元大金融控股股份有限公司</option>
                                <option>台新金融控股股份有限公司</option>
                                <option>新光金融控股股份有限公司</option>
                                <option>兆豐金融控股股份有限公司</option>
                                <option>第一金融控股股份有限公司</option>
                                <option>國票金融控股股份有限公司</option>
                                <option>臺灣金融控股股份有限公司</option>
                                <option>合作金庫金融控股股份有限公司</option>
                                <option>臺灣銀行股份有限公司</option>
                                <option>臺灣土地銀行股份有限公司</option>
                                <option>合作金庫商業銀行股份有限公司</option>
                                <option>第一商業銀行股份有限公司</option>
                                <option>華南商業銀行股份有限公司</option>
                                <option>彰化商業銀行股份有限公司</option>
                                <option>上海商業儲蓄銀行股份有限公司</option>
                                <option>台北富邦商業銀行股份有限公司</option>
                                <option>國泰世華商業銀行股份有限公司</option>
                                <option>高雄銀行股份有限公司</option>
                                <option>兆豐國際商業銀行股份有限公司</option>
                                <option>花旗(台灣)商業銀行股份有限公司</option>
                                <option>王道商業銀行股份有限公司</option>
                                <option>臺灣中小企業銀行股份有限公司</option>
                                <option>渣打國際商業銀行股份有限公司</option>
                                <option>台中商業銀行股份有限公司</option>
                                <option>京城商業銀行股份有限公司</option>
                                <option>滙豐(台灣)商業銀行股份有限公司</option>
                                <option>瑞興商業銀行股份有限公司</option>
                                <option>華泰商業銀行股份有限公司</option>
                                <option>臺灣新光商業銀行股份有限公司</option>
                                <option>陽信商業銀行股份有限公司</option>
                                <option>板信商業銀行股份有限公司</option>
                                <option>三信商業銀行股份有限公司</option>
                                <option>聯邦商業銀行股份有限公司</option>
                                <option>遠東國際商業銀行股份有限公司</option>
                                <option>元大商業銀行股份有限公司</option>
                                <option>永豐商業銀行股份有限公司</option>
                                <option>玉山商業銀行股份有限公司</option>
                                <option>凱基商業銀行股份有限公司</option>
                                <option>星展(台灣)商業銀行股份有限公司</option>
                                <option>台新國際商業銀行股份有限公司</option>
                                <option>安泰商業銀行股份有限公司</option>
                                <option>中國信託商業銀行股份有限公司</option>
                                <option>將來商業銀行股份有限公司</option>
                                <option>連線商業銀行股份有限公司</option>
                                <option>樂天國際商業銀行股份有限公司</option>
                                <option>兆豐票券金融股份有限公司</option>
                                <option>中華票券金融股份有限公司</option>
                                <option>國際票券金融股份有限公司</option>
                                <option>大中票券金融股份有限公司</option>
                                <option>台灣票券金融股份有限公司</option>
                                <option>萬通票券金融股份有限公司</option>
                                <option>大慶票券金融股份有限公司</option>
                                <option>合作金庫票券金融股份有限公司</option>
                                <option>美商美國紐約梅隆銀行股份有限公司</option>
                                <option>美商道富銀行股份有限公司</option>
                                <option>德商德意志銀行股份有限公司</option>
                                <option>香港商東亞銀行有限公司</option>
                                <option>美商摩根大通銀行股份有限公司</option>
                                <option>法商法國巴黎銀行股份有限公司</option>
                                <option>瑞士商瑞士銀行股份有限公司</option>
                                <option>日商瑞穗銀行股份有限公司</option>
                                <option>美商美國銀行股份有限公司</option>
                                <option>泰國盤谷銀行股份有限公司</option>
                                <option>菲商菲律賓首都銀行股份有限公司</option>
                                <option>新加坡商大華銀行有限公司</option>
                                <option>法商法國興業銀行股份有限公司</option>
                                <option>澳商澳盛銀行集團股份有限公司</option>
                                <option>新加坡商星展銀行股份有限公司</option>
                                <option>英商渣打銀行股份有限公司</option>
                                <option>新加坡商新加坡華僑銀行股份有限公司</option>
                                <option>法商東方匯理銀行股份有限公司</option>
                                <option>荷蘭商安智銀行股份有限公司</option>
                                <option>美商富國銀行股份有限公司</option>
                                <option>日商三菱日聯銀行股份有限公司</option>
                                <option>日商三井住友銀行股份有限公司</option>
                                <option>美商花旗銀行股份有限公司</option>
                                <option>香港商香港上海滙豐銀行股份有限公司</option>
                                <option>西班牙商西班牙對外銀行股份有限公司</option>
                                <option>法商法國外貿銀行股份有限公司</option>
                                <option>印尼商印尼人民銀行股份有限公司</option>
                                <option>韓商韓亞銀行股份有限公司</option>
                                <option>臺灣大來卡股份有限公司</option>
                                <option>財團法人聯合信用卡處理中心</option>
                                <option>新加坡商萬事達卡股份有限公司台灣分公司</option>
                                <option>台灣威士卡股份有限公司</option>
                                <option>台灣樂天信用卡股份有限公司</option>
                                <option>台灣美國運通國際股份有限公司</option>
                                <option>香港商台灣環滙亞太信用卡股份有限公司台灣分公司</option>
                                <option>台灣吉世美國際股份有限公司</option>
                                <option>有限責任台北市第五信用合作社</option>
                                <option>有限責任基隆第一信用合作社</option>
                                <option>有限責任基隆市第二信用合作社</option>
                                <option>有限責任淡水第一信用合作社</option>
                                <option>有限責任新北市淡水信用合作社</option>
                                <option>有限責任宜蘭信用合作社</option>
                                <option>有限責任桃園信用合作社</option>
                                <option>有限責任新竹第一信用合作社</option>
                                <option>有限責任新竹第三信用合作社</option>
                                <option>有限責任台中市第二信用合作社</option>
                                <option>有限責任彰化第一信用合作社</option>
                                <option>有限責任彰化第五信用合作社</option>
                                <option>有限責任彰化第六信用合作社</option>
                                <option>有限責任彰化第十信用合作社</option>
                                <option>保證責任彰化縣鹿港信用合作社</option>
                                <option>保證責任嘉義市第三信用合作社</option>
                                <option>有限責任臺南第三信用合作社</option>
                                <option>保證責任高雄市第三信用合作社</option>
                                <option>有限責任花蓮第一信用合作社</option>
                                <option>有限責任花蓮第二信用合作社</option>
                                <option>保證責任澎湖縣第一信用合作社</option>
                                <option>有限責任澎湖第二信用合作社</option>
                                <option>有限責任金門縣信用合作社</option>
                                <option>加拿大商蒙特利爾銀行股份有限公司台北代表人辦事處</option>
                                <option>德商德國商業銀行股份有限公司在臺代表人辦事處</option>
                                <option>菲律賓商金融銀行股份有限公司臺北代表人辦事處</option>
                                <option>香港商恒生銀行股份有限公司在臺代表人辦事處</option>
                                <option>美商美國國泰銀行股份有限公司在臺代表人辦事處</option>
                                <option>越南商越南投資發展商業銀行股份有限公司台北代表人辦事處</option>
                                <option>日商福岡銀行股份有限公司在臺代表人辦事處</option>
                                <option>日商秋田銀行股份有限公司在臺代表人辦事處</option>
                                <option>日商鹿兒島銀行股份有限公司在臺代表人辦事處</option>
                                <option>日商肥後銀行股份有限公司在臺代表人辦事處</option>
                                <option>臺灣銀行</option>
                                <option>南化區農會</option>
                                <option>中和地區農會</option>
                                <option>獅潭鄉農會</option>
                                <option>芳苑鄉農會</option>
                                <option>鳥松區農會</option>
                                <option>臺灣土地銀行</option>
                                <option>七股區農會</option>
                                <option>淡水區農會</option>
                                <option>頭屋鄉農會</option>
                                <option>斗六市農會</option>
                                <option>大樹區農會</option>
                                <option>南投市農會</option>
                                <option>樹林區農會</option>
                                <option>三灣鄉農會</option>
                                <option>虎尾鎮農會</option>
                                <option>內門區農會</option>
                                <option>埔里鎮農會</option>
                                <option>鶯歌區農會</option>
                                <option>大湖地區農會</option>
                                <option>西螺鎮農會</option>
                                <option>東港鎮農會</option>
                                <option>竹山鎮農會</option>
                                <option>三峽區農會</option>
                                <option>板橋區農會</option>
                                <option>斗南鎮農會</option>
                                <option>恆春鎮農會</option>
                                <option>中寮鄉農會</option>
                                <option>蘆洲區農會</option>
                                <option>關西鎮農會</option>
                                <option>古坑鄉農會</option>
                                <option>麟洛鄉農會</option>
                                <option>魚池鄉農會</option>
                                <option>五股區農會</option>
                                <option>新埔鎮農會</option>
                                <option>大埤鄉農會</option>
                                <option>九如鄉農會</option>
                                <option>水里鄉農會</option>
                                <option>林口區農會</option>
                                <option>竹北市農會</option>
                                <option>莿桐鄉農會</option>
                                <option>里港鄉農會</option>
                                <option>國姓鄉農會</option>
                                <option>泰山區農會</option>
                                <option>湖口鄉農會</option>
                                <option>二崙鄉農會</option>
                                <option>坎頂鄉農會</option>
                                <option>鹿谷鄉農會</option>
                                <option>坪林區農會</option>
                                <option>芎林鄉農會</option>
                                <option>崙背鄉農會</option>
                                <option>南州地區農會</option>
                                <option>信義鄉農會</option>
                                <option>八里區農會</option>
                                <option>寶山鄉農會</option>
                                <option>台西鄉農會</option>
                                <option>琉球鄉農會</option>
                                <option>全國農業金庫</option>
                                <option>仁愛鄉農會</option>
                                <option>金山地區農會</option>
                                <option>峨眉鄉農會</option>
                                <option>褒忠鄉農會</option>
                                <option>滿州鄉農會</option>
                                <option>菲律賓首都銀行台北分行</option>
                                <option>東山區農會</option>
                                <option>瑞芳地區農會</option>
                                <option>北埔鄉農會</option>
                                <option>四湖鄉農會</option>
                                <option>枋山地區農會</option>
                                <option>澳商澳盛銀行台北分行</option>
                                <option>頭城鎮農會</option>
                                <option>新店地區農會</option>
                                <option>竹東地區農會</option>
                                <option>口湖鄉農會</option>
                                <option>屏東市農會</option>
                                <option>王道商業銀行</option>
                                <option>羅東鎮農會</option>
                                <option>深坑區農會</option>
                                <option>橫山地區農會</option>
                                <option>嘉義市農會</option>
                                <option>車城地區農會</option>
                                <option>臺灣中小企業銀行</option>
                                <option>礁溪鄉農會</option>
                                <option>石碇區農會</option>
                                <option>新豐鄉農會</option>
                                <option>朴子市農會</option>
                                <option>屏東縣農會</option>
                                <option>壯圍鄉農會</option>
                                <option>平溪區農會</option>
                                <option>新竹市農會</option>
                                <option>布袋鎮農會</option>
                                <option>枋寮地區農會</option>
                                <option>員山鄉農會</option>
                                <option>石門區農會</option>
                                <option>田尾鄉農會</option>
                                <option>大林鎮農會</option>
                                <option>竹田鄉農會</option>
                                <option>五結鄉農會</option>
                                <option>三芝區農會</option>
                                <option>北投區農會</option>
                                <option>民雄鄉農會</option>
                                <option>萬丹鄉農會</option>
                                <option>美商摩根大通銀行台北分行</option>
                                <option>蘇澳地區農會</option>
                                <option>中埔鄉農會</option>
                                <option>士林區農會</option>
                                <option>溪口鄉農會</option>
                                <option>長治鄉農會</option>
                                <option>滙豐(台灣)商業銀行</option>
                                <option>三星地區農會</option>
                                <option>阿里山鄉農會</option>
                                <option>內湖區農會</option>
                                <option>東石鄉農會</option>
                                <option>林邊鄉農會</option>
                                <option>瑞興商業銀行</option>
                                <option>中華民國農會</option>
                                <option>東勢區農會</option>
                                <option>南港區農會</option>
                                <option>義竹鄉農會</option>
                                <option>佳冬鄉農會</option>
                                <option>高雄地區農會</option>
                                <option>清水區農會</option>
                                <option>木柵區農會</option>
                                <option>鹿草鄉農會</option>
                                <option>高樹鄉農會</option>
                                <option>臺灣新光商業銀行</option>
                                <option>基隆市農會</option>
                                <option>梧棲區農會</option>
                                <option>景美區農會</option>
                                <option>太保市農會</option>
                                <option>萬巒地區農會</option>
                                <option>臺中市臺中地區農會</option>
                                <option>大甲區農會</option>
                                <option>水上鄉農會</option>
                                <option>潮州鎮農會</option>
                                <option>基隆第一信用合作社</option>
                                <option>鹿港鎮農會</option>
                                <option>沙鹿區農會</option>
                                <option>番路鄉農會</option>
                                <option>新園鄉農會</option>
                                <option>基隆巿第二信用合作社</option>
                                <option>和美鎮農會</option>
                                <option>霧峰區農會</option>
                                <option>竹崎地區農會</option>
                                <option>吉安鄉農會</option>
                                <option>溪湖鎮農會</option>
                                <option>太平區農會</option>
                                <option>梅山鄉農會</option>
                                <option>壽豐鄉農會</option>
                                <option>淡水第一信用合作社</option>
                                <option>田中鎮農會</option>
                                <option>烏日區農會</option>
                                <option>新港鄉農會</option>
                                <option>富里鄉農會</option>
                                <option>新竹第一信用合作社</option>
                                <option>北斗鎮農會</option>
                                <option>后里區農會</option>
                                <option>凱基商業銀行</option>
                                <option>六腳鄉農會</option>
                                <option>新秀地區農會</option>
                                <option>新竹第三信用合作社</option>
                                <option>線西鄉農會</option>
                                <option>大雅區農會</option>
                                <option>星展(台灣)商業銀行</option>
                                <option>新營區農會</option>
                                <option>關山鄉農會</option>
                                <option>台中第二信用合作社</option>
                                <option>伸港鄉農會</option>
                                <option>潭子區農會</option>
                                <option>鹽水區農會</option>
                                <option>成功鎮農會</option>
                                <option>花壇鄉農會</option>
                                <option>石岡區農會</option>
                                <option>佳里區農會</option>
                                <option>池上鄉農會</option>
                                <option>彰化第六信用合作社</option>
                                <option>大村鄉農會</option>
                                <option>新社區農會</option>
                                <option>善化區農會</option>
                                <option>東河鄉農會</option>
                                <option>高雄第三信用合作社</option>
                                <option>社頭鄉農會</option>
                                <option>大肚區農會</option>
                                <option>雲林區漁會</option>
                                <option>六甲區農會</option>
                                <option>長濱鄉農會</option>
                                <option>花蓮第一信用合作社</option>
                                <option>二水鄉農會</option>
                                <option>外埔區農會</option>
                                <option>嘉義區漁會</option>
                                <option>西港區農會</option>
                                <option>台東地區農會</option>
                                <option>花蓮第二信用合作社</option>
                                <option>大城鄉農會</option>
                                <option>大安區農會</option>
                                <option>南市區漁會</option>
                                <option>將軍區農會</option>
                                <option>鹿野地區農會</option>
                                <option>蘇澳區漁會</option>
                                <option>溪州鄉農會</option>
                                <option>龍井區農會</option>
                                <option>南縣區漁會</option>
                                <option>北門區農會</option>
                                <option>太麻里地區農會</option>
                                <option>頭城區漁會</option>
                                <option>埔鹽鄉農會</option>
                                <option>和平區農會</option>
                                <option>高雄區漁會</option>
                                <option>玉井區農會</option>
                                <option>澎湖縣農會</option>
                                <option>桃園區漁會</option>
                                <option>福興鄉農會</option>
                                <option>花蓮市農會</option>
                                <option>小港區漁會</option>
                                <option>歸仁區農會</option>
                                <option>連江縣農會</option>
                                <option>新竹區漁會</option>
                                <option>彰化市農會</option>
                                <option>瑞穗鄉農會</option>
                                <option>興達港區漁會</option>
                                <option>永康區農會</option>
                                <option>小港區農會</option>
                                <option>通苑區漁會</option>
                                <option>北港鎮農會</option>
                                <option>玉溪地區農會</option>
                                <option>林園區漁會</option>
                                <option>楠西區農會</option>
                                <option>集集鎮農會</option>
                                <option>南龍區漁會</option>
                                <option>土庫鎮農會</option>
                                <option>鳳榮地區農會</option>
                                <option>彌陀區漁會</option>
                                <option>鳳山區農會</option>
                                <option>柳營區農會</option>
                                <option>彰化區漁會</option>
                                <option>東勢鄉農會</option>
                                <option>光豐地區農會</option>
                                <option>永安區漁會</option>
                                <option>岡山區農會</option>
                                <option>台北市第五信用合作社</option>
                                <option>瑞芳區漁會</option>
                                <option>水林鄉農會</option>
                                <option>大里區農會</option>
                                <option>梓官區漁會</option>
                                <option>旗山區農會</option>
                                <option>新北市淡水信用合作社</option>
                                <option>萬里區漁會</option>
                                <option>元長鄉農會</option>
                                <option>苗栗市農會</option>
                                <option>琉球區漁會</option>
                                <option>美濃區農會</option>
                                <option>宜蘭信用合作社</option>
                                <option>基隆區漁會</option>
                                <option>麥寮鄉農會</option>
                                <option>新北市汐止區農會</option>
                                <option>東港區漁會</option>
                                <option>橋頭區農會</option>
                                <option>桃園信用合作社</option>
                                <option>新化區農會</option>
                                <option>林內鄉農會</option>
                                <option>新北市新莊區農會</option>
                                <option>林邊區漁會</option>
                                <option>燕巢區農會</option>
                                <option>彰化第一信用合作社</option>
                                <option>宜蘭市農會</option>
                                <option>內埔地區農會</option>
                                <option>頭份市農會</option>
                                <option>枋寮區漁會</option>
                                <option>田寮區農會</option>
                                <option>彰化第五信用合作社</option>
                                <option>白河區農會</option>
                                <option>大溪區農會</option>
                                <option>竹南鎮農會</option>
                                <option>新港區漁會</option>
                                <option>阿蓮區農會</option>
                                <option>彰化第十信用合作社</option>
                                <option>麻豆區農會</option>
                                <option>桃園區農會</option>
                                <option>通霄鎮農會</option>
                                <option>澎湖區漁會</option>
                                <option>路竹區農會</option>
                                <option>彰化鹿港信用合作社</option>
                                <option>後壁區農會</option>
                                <option>平鎮區農會</option>
                                <option>苑裡鎮農會</option>
                                <option>金門區漁會</option>
                                <option>湖內區農會</option>
                                <option>嘉義第三信用合作社</option>
                                <option>下營區農會</option>
                                <option>楊梅區農會</option>
                                <option>冬山鄉農會</option>
                                <option>豐原區農會</option>
                                <option>茄萣區農會</option>
                                <option>台南第三信用合作社</option>
                                <option>官田區農會</option>
                                <option>大園區農會</option>
                                <option>後龍鎮農會</option>
                                <option>神岡區農會</option>
                                <option>彌陀區農會</option>
                                <option>澎湖第一信用合作社</option>
                                <option>大內區農會</option>
                                <option>蘆竹區農會</option>
                                <option>卓蘭鎮農會</option>
                                <option>名間鄉農會</option>
                                <option>永安區農會</option>
                                <option>澎湖第二信用合作社</option>
                                <option>學甲區農會</option>
                                <option>龜山區農會</option>
                                <option>西湖鄉農會</option>
                                <option>員林市農會</option>
                                <option>梓官區農會</option>
                                <option>金門縣信用合作社</option>
                                <option>新市區農會</option>
                                <option>八德區農會</option>
                                <option>草屯鎮農會</option>
                                <option>二林鎮農會</option>
                                <option>林園區農會</option>
                                <option>安定區農會</option>
                                <option>新屋區農會</option>
                                <option>公館鄉農會</option>
                                <option>秀水鄉農會</option>
                                <option>大寮區農會</option>
                                <option>山上區農會</option>
                                <option>龍潭區農會</option>
                                <option>銅鑼鄉農會</option>
                                <option>埔心鄉農會</option>
                                <option>仁武區農會</option>
                                <option>左鎮區農會</option>
                                <option>復興區農會</option>
                                <option>三義鄉農會</option>
                                <option>永靖鄉農會</option>
                                <option>大社區農會</option>
                                <option>仁德區農會</option>
                                <option>觀音區農會</option>
                                <option>造橋鄉農會</option>
                                <option>埤頭鄉農會</option>
                                <option>杉林區農會</option>
                                <option>關廟區農會</option>
                                <option>土城區農會</option>
                                <option>南庄鄉農會</option>
                                <option>竹塘鄉農會</option>
                                <option>甲仙地區農會</option>
                                <option>龍崎區農會</option>
                                <option>三重區農會</option>
                                <option>臺南市臺南地區農會</option>
                                <option>芬園鄉農會</option>
                                <option>六龜區農會</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="mt-1">
                            <input class="form-control w-full" type="text" wire:model.lazy="data.bank_branch" placeholder="分行名稱" required>
                        </div>
                    </div>
                </div>
            </td>
            <td colspan="2">
                <input class="form-control" type="text" wire:model.lazy="data.bank_account" placeholder="銀行帳號" required>
            </td>
            <td>
                <input class="form-control" type="text" wire:model.lazy="data.salary" placeholder="酬勞" required>
            </td>
        </tr>
        <tr>
            {{-- 只有契養有這幾條 藍色為新增--}}
            @if ($contractType == 3)
                <td colspan="5">
                    <p>
                        <font color="red">*</font>
                        乙方須提供存摺影本予甲方，若非乙方本人存摺須另簽訂匯款同意書以便甲方付款使用。甲方於電宰廠抓雞作業完成後於十五日工作天內，依電宰廠之結算款項扣除飼料款後，餘額匯款入乙方指定之帳號。
                    </p>
                    <p>
                        <font color="red">*</font>若電宰廠之結算款項不足支付飼料款時，乙方應開立足額支票或現款支付甲方。
                    </p>
                    <p>
                        <font color="red">*</font>扣除不良雞隻扣款作業標準所列情形與剔除雞以外者，上車補貼每羽新台幣
                        <input class="form-control inline-block w-20" type="number" wire:model.lazy="extraData.each_chicken_car_price" min=0 step="any" required>元
                    </p>
                    <p>
                        <font color="red">*</font>抓雞工資由乙方負責支付。
                    </p>
                    <p>
                        <font color="red">*</font><font color="blue">本合約如有訴訟時，雙方同意以台灣台中地方法院為第一審管轄法院。</font>
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
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">公司</span>
                    <input type="text" id="office_tel" wire:model.lazy="data.office_tel" class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" placeholder="請填寫電話號碼">
                </div>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">住家</span>
                    <input type="text" id="home_tel" wire:model.lazy="data.home_tel" class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" placeholder="請填寫電話號碼">
                </div>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">手機</span>
                    <input type="text" id="mobile_tel" wire:model.lazy="data.mobile_tel" class="form-control flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" placeholder="請填寫電話號碼">
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="w-full mt-5">
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
                    <li>毛雞規格為1.80～2.25公斤為原則，2.251～2.30公斤以下扣0.6元(若經協商大雞屠宰需求，則不在此列扣款)，2.3公斤以上扣0.9元，於入雛日後26～30天磅雞後，由雙方議定抓雞日期；若市場特殊需求得經雙方同意調整規格。</li>
                    <li>毛雞每斤計價方式：依出雞當日聯合報，中華民國養雞協會肉雞產地交易行情表
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_0" min=0 step="any">～
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_1" min=0 step="any">
                        公斤毛雞之北、中、嘉南、高屏區電宰之報價結算：毛雞均重達
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_2" min=0 step="any">
                        公斤(含以上)以新台幣
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_3" min=0 step="any">
                        元/斤(手續費)計價，毛雞均重達
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_4" min=0 step="any">
                        公斤(以下)以新台幣
                        <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_5" min=0 step="any">

                        @if($contractType == 3)
                            元/斤(手續費)計價，產銷履歷場以毛雞均重達
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_7" min=0 step="any">
                            公斤(含以上)以新台幣          
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_8" min=0 step="any">  
                            元/斤(手續費)計價，毛雞均重達    
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_9" min=0 step="any">
                            公斤(以下)以新台幣
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_10" min=0 step="any">
                            元/斤(手續費)計價。
                        @else
                            元/斤(手續費)計價，產銷履歷場以新台幣
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.trading_market_table_6" min=0 step="any">
                            元/斤(手續費)計價。
                        @endif

                    </li>
                    <li>異常扣款依『台灣區電動屠宰同業公會』業界規則及附件所示112年洽富公司扣款項目處理之。</li>
                    <li>甲方運費補貼乙方：</li>

                    <ol type="a">
                        <li>
                            a. 台中市、彰化縣、南投縣、苗栗縣為基準不予補貼(南投埔里、魚池、仁愛等每車次補貼油費新台幣
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.compensation_0" min=0 step="any">
                            元/車)，每超越一縣補貼油費新台幣
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.compensation_1" min=0 step="any">
                            元/車以此類推。
                        </li>
                        <li>
                            b. 未經乙方許可，空車折返補貼新台幣
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.compensation_2" min=0 step="any">
                            元/車。
                        </li>
                    </ol>
                    
                    @if($contractType == 3)
                        <li>雛雞折扣回饋：乙方由種雞場雛雞回饋金額中，依實際電宰時存量提出每羽
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" type="text" wire:model.lazy="extraData.discount_reward_0" min=0 step="any">             
                            元金額回饋給甲方(時價除外)，雛雞價低於
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" type="text" wire:model.lazy="extraData.discount_reward_1" min=0 step="any">
                            元/羽時依價格
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" type="text" wire:model.lazy="extraData.discount_reward_2" min=0 step="any">
                            %計算。
                        </li>
                    @else
                        <li>雛雞折扣回饋：甲方由種雞場雛雞回饋金額中，依實際電宰時存量提出每羽1元金額回饋給乙方(時價除外)，雛雞價低於
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.discount_reward_0" min=0 step="any">
                            元/羽時依價格
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" wire:model.lazy="extraData.discount_reward_1" min=0 step="any">
                            %計算。
                        </li>
                    @endif

                    @if($contractType == 3)
                        <li>由富祥種雞場提供雛雞時，依實際入雛羽數提出每羽
                            <input type="number" class="form-control inline-block w-20 text-center dynamic-width" type="text" wire:model.lazy="extraData.Feedback_0" min=0 step="any">
                            元回饋金時，則回饋予甲方。
                        </li>
                    @else
                        <li>由富祥種雞場提供雛雞時，依實際入雛羽數提出每羽1元回饋金時，則回饋予乙方。</li>
                    @endif
                    <li>其他未盡事宜則依『台灣區電動屠宰同業公會』及業界規則處理之。</li>
                    <li>剔除雞:防檢局駐場獸醫師、屠檢人員實際剃除羽數×毛雞平均重。</li>
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
            inputElement.style.minwidth = `20ch`; // 使用 "ch" 单位
        }
    });
</script>