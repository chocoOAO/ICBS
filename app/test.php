<?php
    $batchNumber = 'G11211103';
    $sid = 57;
    $url = "http://1.34.47.251:28888/api/client/batch_query.php?sid={$sid}&batchNumber={$batchNumber}";
    // echo $url;

    $batchNumber = 'G11211103';
    // 截止日期
    $date = '20231115';
    $sensorID = 115;
    $sid = 57;
    $url2 = "http://1.34.47.251:28888/api/client/weightRaw.php?sid={$sid}&batchNumber={$batchNumber}&sensorID={$sensorID}&Date={$date}";
    echo $url2;
?>
