<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>福壽-飼育平台</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <button onclick="getData();">啟動</button>
<canvas id="myChart">
    
</canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getData() {
        fetch("/exePython")
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                updateChart(data);
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function updateChart(data) {
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.date,
                datasets: [
                    {
                        label: '實際重量',
                        data: data.weight.slice(0,5),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '預測重量',
                        data: Array.from({ length: 4 }).fill(null).concat(data.weight.slice(4,10)),
                        backgroundColor: 'rgba(54, 162, 235, 1)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
            ]
            },
            options: {
                title: {
                    display: true,
                    text: 'myChart',
                    fontColor: 'red',
                    fontSize: '24',
                }
            }
        });
    }
</script>
</body>


</html>

