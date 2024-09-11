<form action="#" wire:submit.prevent="submit">
    <div class="my-2 py-5 border-gray-200">
        <h2 class="text-xl text-gray-800 leading-tight text-center">飼養入雛表</h2>
    </div>

    <table class="max-w-full table-fixed">
        <tbody>
            <tr>
                <td style="width: 8%;">
                    <font color="red">*</font>批號：
                </td>
                <td colspan="10">
                    <div>
                        <div class="relative flex items-center">

                            <div class="text-sm">
                                <input class="form-control" type="text" wire:model.lazy="data.vendorName"
                                    id="vendorName" readonly="true">
                            </div>
                        </div>
                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="11">
                    <table class="table-fixed">

                        <script language="JavaScript">
                            // document.write(screen.width);
                            for (i = 0; i < screen.width / 12; i++) {
                                document.write("-");
                            }
                        </script>

                        <tr>
                            <td style="width:9%">日期</td>
                            <td style="width:9%">入雛</td>
                            <td style="width:9%">贈送</td>
                            <td style="width:9%">總數</td>
                            <td style="width:9%">包裝</td>
                            <td style="width:9%">箱</td>
                            <td style="width:9%">平均雞重(g)</td>
                            <td style="width:9%">雞重(kg)</td>
                            <td style="width:9%">單價(元/羽)</td>
                            <td style="width:9%">總價</td>
                            <td style="width:9%">收執聯照片</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center h-5 align-middle">
                                    <input class="form-control" type="date" wire:model.lazy="data.end_date">
                                </div>
                            </td>
                            <td>
                                <input class="form-control" type="number" id="chickIn"
                                    wire:model.lazy="extraData.chickIn" placeholder="16000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="present"
                                    wire:model.lazy="extraData.present" placeholder="2000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="sum"
                                    wire:model.lazy="extraData.sum" placeholder="18000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package"
                                    wire:model.lazy="extraData.package" placeholder="3000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package_sum"
                                    wire:model.lazy="extraData.package_sum" placeholder="6" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="avg_weight"
                                    wire:model.lazy="extraData.avg_weight" placeholder="12.5" min="0"
                                    step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="weight"
                                    wire:model.lazy="extraData.weight" placeholder="225" min="0" step="100">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="price"
                                    wire:model.lazy="extraData.price" placeholder="20" min="0" step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="total_price"
                                    wire:model.lazy="extraData.total_price" placeholder="360000" min="0">
                            </td>
                            <td align="center">
                                <a href="12344.jpg" target="_blank">查看</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="flex items-center h-5 align-middle">
                                    <input class="form-control" type="date" wire:model.lazy="data.end_date2">
                                </div>
                            </td>
                            <td>
                                <input class="form-control" type="number" id="chickIn2"
                                    wire:model.lazy="extraData.chickIn2" placeholder="16000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="present2"
                                    wire:model.lazy="extraData.present2" placeholder="2000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="sum2"
                                    wire:model.lazy="extraData.sum2" placeholder="18000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package"
                                    wire:model.lazy="extraData.package2" placeholder="3000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package_sum2"
                                    wire:model.lazy="extraData.package_sum2" placeholder="6" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="avg_weight2"
                                    wire:model.lazy="extraData.avg_weight2" placeholder="12.5" min="0"
                                    step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="weight2"
                                    wire:model.lazy="extraData.weight2" placeholder="225" min="0"
                                    step="100">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="price2"
                                    wire:model.lazy="extraData.price2" placeholder="20" min="0"
                                    step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="total_price2"
                                    wire:model.lazy="extraData.total_price2" placeholder="360000" min="0">
                            </td>
                            <td align="center">
                                <a href="12344.jpg" target="_blank">查看</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center h-5 align-middle">
                                    <input class="form-control" type="date" wire:model.lazy="data.end_date3">
                                </div>
                            </td>
                            <td>
                                <input class="form-control" type="number" id="chickIn3"
                                    wire:model.lazy="extraData.chickIn3" placeholder="16000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="present3"
                                    wire:model.lazy="extraData.present3" placeholder="2000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="sum3"
                                    wire:model.lazy="extraData.sum3" placeholder="18000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package3"
                                    wire:model.lazy="extraData.package3" placeholder="3000" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="package_sum3"
                                    wire:model.lazy="extraData.package_sum3" placeholder="6" min="0">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="avg_weight3"
                                    wire:model.lazy="extraData.avg_weight3" placeholder="12.5" min="0"
                                    step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="weight3"
                                    wire:model.lazy="extraData.weight3" placeholder="225" min="0"
                                    step="100">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="price3"
                                    wire:model.lazy="extraData.price3" placeholder="20" min="0"
                                    step="1">
                            </td>
                            <td>
                                <input class="form-control" type="number" id="total_price3"
                                    wire:model.lazy="extraData.total_price3" placeholder="360000" min="0">
                            </td>
                            <td align="center">
                                <a href="12344.jpg" target="_blank">查看</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>

            </tr>


            <tr>

                <td colspan="5">

                    <div class="flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">備註</span>
                        <input type="text" id="memo" wire:model.lazy="data.memo"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300"
                            placeholder="">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-end">
        <button class="btn-primary" type="submit">下一步</button>
    </div>
</form>
