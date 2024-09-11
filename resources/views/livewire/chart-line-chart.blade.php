<div>
    <table class="max-w-full table-fixed @if (Auth::user()->permissions[2] < 3) cant_edit @endif">
        <tbody>
            <tr>
                <td style="width: 8%;">
                    批號：
                </td>
                <td>
                    <select wire:model="selectedOption" >
                        <option value="-1" disabled>選擇一個批號</option>
                        @foreach ($importNumOptions as $options)
                            <option value="{{ $options['id'] }}">{{ $options['id'] }}</option>
                        @endforeach
                    </select>
                </td>

                <td style="width: 8%;">
                    棟別：
                </td>
                <td>
                    <select wire:model="selectedOption">
                        <option value="-1" disabled>選擇一個棟別</option>
                        @foreach ($buildingNumOptions as $key => $building_number)
                            <option value="{{ $building_number }}">{{ $building_number }}</option>
                        @endforeach
                    </select>
                </td>

                <td style="width: 8%;">
                    入雛日期：
                </td>
                <td>
                    <div>
                        <div class="relative flex items-center">
                            <div class="text-sm">
                                <form action="ChartComponent.php" method="post">
                                    <input class="form-control" type="text" wire:model.lazy="selectedDate" readonly>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 8%;">
                    雞種：
                </td>
                <td>
                    <div>
                        <div>
                            <div class="relative flex items-center">
                                <div class="text-sm">
                                    {{-- @dd($chicken_import['species']) --}}
                                    <input class="form-control" style="cursor: not-allowed;" type="text"
                                        wire:model.lazy="chicken_import.species" readonly="true">
                                </div>

                            </div>
                        </div>
                    </div>
                </td>

            </tr>
        </tbody>
    </table>

    <div>
        <canvas id="TestChart" width="400" height="200"></canvas>

        <script>
            const chartData = {
                // labels: combied_data.map(function(item) {
                //     return item.age + '天';
                // }),
                labels: Array.from({ length: 36 }, (_, i) => i),
                datasets: [{
                    label: 'ROSS 標準生長曲線',
                    data: [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,
                           1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            };

            // 創建圖表的代碼（假設你已經有一個canvas元素）
            const Testctx = document.getElementById('TestChart').getContext('2d');
            const TestChart = new Chart(Testctx, {
                type: 'line',
                data: chartData,
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: '日齡',
                                font: {
                                    size: 20
                                }
                            },
                            ticks: {
                                font: {
                                    size: 20
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '平均重量 (克)',
                                font: {
                                    size: 20
                                }
                            },
                            ticks: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20
                                }
                            }
                        }
                    }
                }
            });

            document.addEventListener('livewire:load', function () {
                window.addEventListener('update-chart', event => {
                    const selectedData = event.detail.selectedData;
                    const rawWeightsData = event.detail.rawWeightsData;
                    const rossData = event.detail.rossData;
                    const datasets = event.detail.chartDatasets;

                    let newDatasets = [];
                    //以從哪天開始補資料為斷點，用兩條線來表得一條線。 
                    let dataToShow = selectedData.data.slice(0, selectedData.index+1);
                    let dataToShow2 = selectedData.data.slice(selectedData.index, 36); // 更改這裡的切片範圍

                    if (selectedData) {
                        // 定義當前批號的資料集
                        let dataset1 = {
                            label: '當前批號',
                            data: dataToShow,
                            borderColor: "blue",
                            borderWidth: 1,
                            fill: false,
                            // 定義 x 軸的值，
                        };

                        // 定義當前批號2的資料集
                        let dataset2 = {
                            label: '當前批號(補標準資料)',
                            data: dataToShow2,
                            borderColor: 'gray', 
                            borderWidth: 1,
                            fill: false,
                            data: dataToShow2.map((value, index) => ({ x: selectedData.index + index, y: value })),
                        };

                        // 將資料集添加到 newDatasets 中
                        newDatasets.push(dataset1);
                        newDatasets.push(dataset2);
                    }

                    // 添加ROSS標準生長曲線
                    if (rossData) {
                        newDatasets.push({
                            label: 'ROSS 308 標準生長曲線',
                            data: rossData.weights,
                            borderColor: 'red',
                            borderWidth: 1,
                            fill: false
                        });
                    }

                    // 根據條件判斷是否添加第一批次的數據集
                    if (datasets && datasets.previous1st) {
                        newDatasets.push({
                            label: '前一筆',
                            data: datasets.previous1st.weights,
                            borderColor: 'green',
                            borderWidth: 1,
                            fill: false
                        });
                    }

                    // 根據條件判斷是否添加第二批次的數據集
                    if (datasets && datasets.previous2nd) {
                        newDatasets.push({
                            label: '前二筆',
                            data: datasets.previous2nd.weights,
                            borderColor: 'orange',
                            borderWidth: 1,
                            fill: false
                        });
                    }

                    // 根據條件判斷是否添加第三批次的數據集
                    if (datasets && datasets.previous3rd) {
                        newDatasets.push({
                            label: '前三筆',
                            data: datasets.previous3rd.weights,
                            borderColor: 'purple',
                            borderWidth: 1,
                            fill: false
                        });
                    }
                    TestChart.data.labels = selectedData.labels; // 假设所有數據集共用一個數據標籤

                    TestChart.data.datasets = newDatasets;
                    TestChart.update();
                });
            });
        </script>
        <script>
            document.addEventListener('livewire:load', function () {
                window.addEventListener('no-weight-data', event => {
                    alert(event.detail.message);
                });
            });
            </script>
    </div>
    </div>
