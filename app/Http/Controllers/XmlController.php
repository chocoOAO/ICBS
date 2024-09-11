<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ChickenImport;
use App\Models\FeedingLog;
use App\Models\BreedingLog;
use DOMDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ExternalAPIController;

class XmlController extends Controller
{
    // 掛載資料夾路徑
    // $fileLocation = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder';
    // $fileWithError = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/error_folder';
    // $fileComplete = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/complete_folder';

    // 取得資料夾內的所有XML檔案
    // 1.輸入欲存取之資料夾路徑
    // 2.取得資料夾內的所有XML檔案
    // 3.回傳所有XML檔案名稱
    public function getFolderFiles($fileLocation = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/')
    {
        // $fileLocation = '/mnt/bpm_test/ToFSFMS/';
        $xmlFiles = File::glob($fileLocation . '*.xml'); // 取得所有以 .xml 結尾的檔案
        $fileNames = array_map('basename', $xmlFiles); // 提取文件名部分
        return $fileNames;
    }

    // 讀取XML的檔案內容
    // 1.getFolderFiles() -> getFileNames
    // 2.將xml檔案內的資料轉換成陣列
    // 3.回傳陣列
    public function readXMLFile($fileName, $fileLocation = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/')
    {
        $xmlData = [];
        $xmlPath = $fileLocation . $fileName;

        if (file_exists($xmlPath)) {
            $xml = simplexml_load_file($xmlPath);

            foreach ($xml->children() as $child) {
                $xmlData[] = $child;
            }
        }
        return $xmlData;
    }

    // 寫入SQL
    public function writeInDB()
    {
        /**
         * <SN2>G11208104</SN2> 飼養批次
         * <RearingMethod>代養</RearingMethod> 合約種類
         * <CustomerID>    飼主編號(客戶編號)
         * <CustomerName>    飼主名稱(客戶名稱)
         * <TotalIncomeCount>    共入雛(羽)(預計羽數)
         * <Ctype>    雞種
         * <IncomeDate> 入雛日期
         * <IncomeCount> 等校於tOTALINCOMECOUNT
         * <IncomeSource> 雛雞來源 (暫時沒用到)
         * <m_PROCESS_DATE> 沒用到
         * <m_PROCESS_TIME> 沒用到
         * <m_FRGZU>
         *
         */

        /*
        <FEED>
        <SN2>G11210401</SN2>
        <DATE>20231203</DATE>
        <FEED_TYPE>A</FEED_TYPE>
        <FEED_ITME>Ｎ肉雞１號碎粒(添)  P</FEED_ITME>
        <FEED_QUANTITY>8360</FEED_QUANTITY>
        <ADD_ANTIBIOTICS>YES</ADD_ANTIBIOTICS>
        </FEED>
         */

        // 取得所有檔案名稱
        $fileNames = $this->getFolderFiles();

        // 離線測試
        // $fileNames = $this->getFolderFiles("XML Format/北科飼育平台/接收範例/");

        $feedFiles = [];
        $otherFiles = [];

        foreach ($fileNames as $file) {
            if (strpos($file, 'FEED') === 0) {
                $feedFiles[] = $file;
            } else {
                $otherFiles[] = $file;
            }
        }

        // 批次讀取所有檔案的XML
        foreach ($otherFiles as $file) {
            $xmlData = $this->readXMLFile($file);
            $dateOnly = null; // 或者其他有效的日期字符串
            // dd($xmlData, $xmlData[0]->CustomerID, Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->exists());
            //  如果成功寫入DB 一併執行創建新的XML的動作
            //  如果失敗跳出錯誤訊息
            // dd($xmlData);
            try {

                // 如果xmlDate的CustomerID有對應的Contract的m_KUNAG
                // 取得Contract的ID 寫入 ChickenImport的contract_id
                // 寫入其他資料
                if (Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->whereDate('end_date', '>', now())->exists()) {
                    $contract_id = Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->whereDate('end_date', '>', now())->first()->id;

			//dd($contract_id);

                    for ($i = 1; $i < count($xmlData); $i++) {

                        $incomeDate = (string) $xmlData[$i]->IncomeDate;
                        preg_match('/(\d{4}\/\d{1,2}\/\d{1,2})/', $incomeDate, $matches);
                        $dateOnly = $matches[1];

                        // 尝试写入数据库
                        ChickenImport::create([
                            'id' => $xmlData[0]->SN2,
                            'contract_id' => $contract_id,
                            'm_KUNAG' => $xmlData[0]->CustomerID,
                            'date' => $dateOnly, // 此處應該包含有效的 'Y-m-d' 格式日期字符串
                            'species' => $xmlData[0]->Ctype,
                            'quantity' => $xmlData[$i]->IncomeCount,
                            'gift_quantity' => floatval($xmlData[$i]->IncomeCount) * 0.02,
                            'building_number' => empty($xmlData[$i]->Coop) ? 'A' : $xmlData[$i]->Coop,
                            'chicken_origin' => $xmlData[$i]->IncomeSource,
                            // 'amount' => floatval($xmlData[0]->TotalIncomeCount) * 1.02,
                            // 'creater' => $xmlData[0]->ApplyAccount,
                        ]);
                        $ExternalAPIController = new ExternalAPIController();
                        $sensorData = $ExternalAPIController->getSensor();
                    }                    
		
                    // $startDate = Carbon::parse($dateOnly); // 使用已有的日期数据
                    // $endDate = $startDate->copy()->addDays(30);

                    // $weightIncrement = 2000;
                    // $currentWeight = 10000;

                    // while ($startDate->lte($endDate)) {
                    //     $fake_raw_weights = [
                    //         'batchNumber' => $xmlData[0]->SN2,
                    //         'Date' => $startDate->toDateString(),
                    //         'time' => '00:00:00',
                    //         'sensorID' => strval(ChickenImport::count()),
                    //         'weight' => $currentWeight, // 使用当前权重值
                    //     ];

                    //     RawWeight::create($fake_raw_weights);

                    //     $startDate->addDay(); // 增加一天
                    //     $currentWeight += $weightIncrement; // 递增权重
                    // }

                    // 成功写入数据库后执行创建新 XML 文件的操作

                    $this->writeXMLFile($xmlData[0]->RTaskID, 'OK', '');
                    // 成功生成後將檔案移動至Complete資料夾
                    File::move("/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/" . $file, "/mnt/bpm_test/ToFSFMS/fushou_folder/complete_folder/" . $file);
		    }

		else {
                    // 如果沒有對應的Contract的m_KUNAG
                    // 將檔案移動至error_folder資料夾
                    File::move("/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/" . $file, "/mnt/bpm_test/ToFSFMS/fushou_folder/error_folder/" . $file);
                    // 生成一個log.txt，如果沒有則建立一個，寫入序號-時間戳記-filename-錯誤訊息
                    $log = fopen("/mnt/bpm_test/ToFSFMS/log.txt", "a");
                    $time = now()->addHours(8)->toDateTimeString();
                    fwrite($log, $xmlData[0]->SN2 . "-" . $time . "-" . $file . "-" . "沒有對應的Contract的m_KUNAG" . "\n");
                    fclose($log);

                    // 输出错误消息
                    $this->writeXMLFile($xmlData[0]->RTaskID, 'ER', "沒有對應的Contract的m_KUNAG");
		    
                    echo "沒有對應的Contract的m_KUNAG";

                }

            } catch (Exception $e) {
                // 失敗後將檔案移動至Process資料夾

                File::move("/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/" . $file, "/mnt/bpm_test/ToFSFMS/fushou_folder/error_folder/" . $file);
                // 生成一個log.txt，如果沒有則建立一個，寫入序號-時間戳記-filename-錯誤訊息
                $log = fopen("/mnt/bpm_test/ToFSFMS/log.txt", "a");
                $time = now()->addHours(8)->toDateTimeString();
                fwrite($log, $xmlData[0]->SN2 . "-" . $time . "-" . $file . "-" . $e->getMessage() . "\n");
                fclose($log);

                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    // 如果包含关键字，将错误消息设置为“已有相同数据”
                    $errorMessage = '已有相同數據';
                } else {
                    // 否则，将错误消息设置为原始的异常消息
                    $errorMessage = 'Error: ' . $e->getMessage();
			echo ($errorMessage);
                }

                // 输出错误消息
                $this->writeXMLFile($xmlData[0]->RTaskID, 'ER', $errorMessage);

                echo $errorMessage;

            }
        }
        $this->processFeedFile($feedFiles);
    }
    public function processFeedFile($feedFiles, $fileLocation = '/mnt/bpm_test/ToFSFMS/fushou_folder/newCreate_folder/')
    {
        $logFilePath = $fileLocation . "feedlog.txt";
        if (empty($feedFiles)) { $this->writeToLog("未找到以 FEED 開頭的 XML 文件", $logFilePath); }

        foreach ($feedFiles as $feedFile) {
            try {
                $feedXmlData = $this->readXMLFile(basename($feedFile));

                foreach ($feedXmlData as $data) {
                    $sn2 = (string) $data->SN2;

                    $matchingBreedingLog = BreedingLog::where('chicken_import_id', $sn2)->get();
                    $totalDisuse = $matchingBreedingLog->sum('disuse');
                    $matchingChickenImports = ChickenImport::where('id', $sn2)->get();

                    if ($matchingChickenImports->isNotEmpty()) {
                        $totalActualQuantity = $matchingChickenImports->sum('actual_quantity') - $totalDisuse; # 總實際數量($totalActualQuantity) = 實際數量-總淘汰數 

                        if ($totalActualQuantity > 0) {

                            //計算分完後的飼料輛是否等於實際飼料數量
                            $sumFeedQuantity = 0;

                            foreach ($matchingChickenImports as $chickenImport) {
                                $DisuseForThisImport = $matchingBreedingLog->where('building_number', $chickenImport->building_number)->sum('disuse');
                                $ActualQuantityForThisImport = ($chickenImport->actual_quantity) - $DisuseForThisImport;
                                $proportion = $ActualQuantityForThisImport / $totalActualQuantity;
                                $feedQuantityForThisImport = $proportion * (int) $data->FEED_QUANTITY;

                                $sumFeedQuantity += (int) $feedQuantityForThisImport;
                                //如果為最後一筆入雛，把剩下的飼料數量加進去
                                if ($chickenImport->building_number === $matchingChickenImports->last()->building_number) {
                                    $feedQuantityForThisImport += ((int) $data->FEED_QUANTITY - $sumFeedQuantity);
                                }
                                FeedingLog::create([
                                    'm_KUNAG' => $chickenImport->m_KUNAG,
                                    'contract_id' => $chickenImport->contract_id,
                                    'chicken_import_id' => $chickenImport->id,
                                    'building_number' => $chickenImport->building_number,
                                    'date' => (string) $data->DATE,
                                    'feed_type' => (string) $data->FEED_TYPE,
                                    'feed_item' => empty($data->FEED_ITEM) ? $data->FEED_ITME : $data->FEED_ITEM,
                                    'feed_quantity' => (int)$feedQuantityForThisImport,
                                    'add_antibiotics' => (string) $data->ADD_ANTIBIOTICS === 'YES' ? 1 : 0,
                                ]);
                            }
                        } else {
                            $this->writeToLog($sn2,"該入雛表扣除了淘汰隻數的實際雞數量為0 ", $logFilePath);
                            continue;
                        }
                    } else {
                        echo "查詢不到符合的入雛表批號：" . $sn2;
                        $this->writeToLog("未找到符合 SN2: " . $sn2 . " 的入雛表批號", $logFilePath);
                        continue;
                    }
                }
                if($matchingChickenImports->sum('actual_quantity') != 0 or $matchingChickenImports->sum('actual_quantity') != NULL){
                    File::move($fileLocation . "newCreate_folder/" .$feedFile, $fileLocation . "complete_folder/" . basename($feedFile));
                }

            } catch (Exception $e) {
                $this->writeToLog("處理 FEED 文件時發生異常: " . $e->getMessage(), $logFilePath);
            }
        }
    }

    private function writeToLog($message, $logFilePath)
    {
        try {
            if (!file_exists($logFilePath)) {
                // 如果日誌文件不存在，則創建它
                touch($logFilePath);
            }

            $logFile = fopen($logFilePath, "a");
            $time = now()->addHours(8)->toDateTimeString();
            fwrite($logFile, $time . " - " . $message . "\n");
            fclose($logFile);
        } catch (\Exception $e) {
            Log::error("寫入日誌文件時發生異常: " . $e->getMessage());}
    }

    // 生成回傳的XML格式(回傳給fwusow的檔案,以便確認匯入正確)
    // 1.確定格式
    // 2.填入格式內容
    // 3.生成XML檔案
    // 4.回傳XML檔案至指定資料夾內
    /*
    <?xml version="1.0"?>
    <xml>
    <SAP_APRV_RLT>
    <RTaskID>274605</RTaskID>
    <m_FRGZU>Approved</m_FRGZU>
    <m_PROCESS_DATE>20230822</m_PROCESS_DATE>
    <m_PROCESS_TIME>21:49:55</m_PROCESS_TIME>
    <m_RETURN_CODE>OK</m_RETURN_CODE>
    <m_RETURN_MESSAGE></m_RETURN_MESSAGE>
    </SAP_APRV_RLT>
    </xml>
     */

    // 產生XML的資料格式
    public function writeXMLFile($RTaskID, $m_Return_Code, $m_Return_Message, $m_FRGZU = 'Approved')
    {
        // 命名規則: 入雞通知單_飼育平台接收回傳+"_"+RTaskID.xml
        // $xmlPath = public_path('XML Format/北科飼育平台/入雞通知單_274605.xml');
        // 创建一个新的 DOM 文档

        $dom = new DOMDocument('1.0', 'utf-8');
        // 创建根元素 <xml>
        $xml = $dom->createElement('xml');
        // 创建 <SAP_APRV_RLT> 元素
        $sapAprvRlt = $dom->createElement('SAP_APRV_RLT');

        // 创建子元素并设置其文本内容
        $rtaskId = $dom->createElement('RTaskID', $RTaskID);
        $mFrgzu = $dom->createElement('m_FRGZU', $m_FRGZU);
        $mProcessDate = $dom->createElement('m_PROCESS_DATE', date('Ymd'));
        $mProcessTime = $dom->createElement('m_PROCESS_TIME', date("H:i:s"));
        $mReturnCode = $dom->createElement('m_RETURN_CODE', $m_Return_Code);
        // $mReturnMessage = $dom->createElement('m_RETURN_MESSAGE', "$m_Return_Message");
        // 根據要求這裡不要填入自定義訊息
        $mReturnMessage = $dom->createElement('m_RETURN_MESSAGE', '');

        // 将子元素添加到 <SAP_APRV_RLT>
        $sapAprvRlt->appendChild($rtaskId);
        $sapAprvRlt->appendChild($mFrgzu);
        $sapAprvRlt->appendChild($mProcessDate);
        $sapAprvRlt->appendChild($mProcessTime);
        $sapAprvRlt->appendChild($mReturnCode);
        $sapAprvRlt->appendChild($mReturnMessage);

        // 将 <SAP_APRV_RLT> 添加到根元素 <xml>
        $xml->appendChild($sapAprvRlt);

        // 将根元素添加到 DOM 文档
        $dom->appendChild($xml);

        // 格式化输出 XML 数据
        $dom->formatOutput = true;

        // 保存 XML 文档到文件
        $dom->save('/mnt/bpm_test/ToBPM_ProcessRlt/入雞通知單_飼育平台接收回傳_' . $rtaskId->textContent . '.xml');
        // $dom->save('/mnt/bpm_test/ToFSFMS/ToBPM_ProcessRlt/入雞通知單_飼育平台接收回傳_' . $rtaskId->textContent . '.xml');
        echo 'XML data has saved to 入雞通知單_飼育平台接收回傳_' . $rtaskId->textContent . '.xml' . "\n";
    }

    // ---------離線-----------
    public function readXMLFile2($fileName = 'XML Format/北科飼育平台/入雞通知單_274605.xml')
    {
        $xmlPath = public_path('XML Format/北科飼育平台/入雞通知單_274605.xml');
        // $xmlPath = public_path($fileName);
        // $fileLocation = '172.16.1.9\XML\ToFSFMS';
        $xmlData = [];

        if (file_exists($xmlPath)) {
            $xml = simplexml_load_file($xmlPath);

            foreach ($xml->children() as $child) {
                $xmlData[] = $child;
            }
        }
        return $xmlData;
    }

    // 寫入SQL
    public function xml2DB()
    {
        /**
         * <SN2>G11208104</SN2> 飼養批次
         * <RearingMethod>代養</RearingMethod> 合約種類
         * <CustomerID>    飼主編號(客戶編號)
         * <CustomerName>    飼主名稱(客戶名稱)
         * <TotalIncomeCount>    共入雛(羽)(預計羽數)
         * <Ctype>    雞種
         * <IncomeDate> 入雛日期
         * <IncomeCount> 等校於tOTALINCOMECOUNT
         * <IncomeSource> 雛雞來源 (暫時沒用到)
         * <m_PROCESS_DATE> 沒用到
         * <m_PROCESS_TIME> 沒用到
         * <m_FRGZU>
         *
         */
        $xmlData = $this->readXMLFile2();
        // dd($xmlData);

        // 註解理由 客戶代號不在這裡填寫
        // ZCusKna1::create([
        //     'm_KUNAG' => $xmlData[0]->CustomerID,
        //     'm_NAME' => $xmlData[0]->CustomerName,
        //     'm_ADDSC' => $xmlData[0]->CustomerName,
        // ]);

        // 如果xmlDate的CustomerID有對應的Contract的m_KUNAG
        // 取得Contract的ID 寫入 ChickenImport的contract_id
        // 寫入其他資料

        $dateOnly = null; // 或者其他有效的日期字符串
        // dd($xmlData, $xmlData[0]->CustomerID, Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->exists());
        // 排除過期的合約
        if (Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->exists()) {
            $contract_id = Contract::where('m_KUNAG', $xmlData[0]->CustomerID)->first()->id;
            $incomeDate = (string) $xmlData[1]->IncomeDate;
            $dateOnly = substr($incomeDate, 0, 10);
        }

        //  如果成功寫入DB 一併執行創建新的XML的動作
        //  如果失敗跳出錯誤訊息
        try {
            ChickenImport::create([
                'id' => ($xmlData[0]->SN2),
                'contract_id' => $contract_id,
                'm_KUNAG' => ($xmlData[0]->CustomerID),
                'date' => $dateOnly,
                'species' => ($xmlData[0]->Ctype),
                'quantity' => ($xmlData[0]->TotalIncomeCount),
                'gift_quantity' => (floatval($xmlData[0]->TotalIncomeCount) * 0.02),
                // 'amount' => strval(floatval($xmlData->TotalIncomeCount) * 1.02),
                'creator' => ($xmlData[0]->ApplyAccount),
            ]);

            // 成功写入数据库后执行创建新 XML 文件的操作
            // $this->writeXMLFile2();

            // 在这里可以添加其他成功后的操作
        } catch (\Exception $e) {
            // 处理异常，例如打印错误消息或记录日志
            // 例如：
            // Log::error($e->getMessage());
            // 或
            // echo 'Error: ' . $e->getMessage();
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function generateXml()
    {
        // 命名規則: 入雞通知單_飼育平台接收回傳+"_"+RTaskID.xml

        // 讀取 172.16.1.10\XML\ToFSFMS\Complete內的所有檔案
        // 根據相關欄位填寫資料

        $rtaskId = "274605";
        $mFrgzu = "approve";
        $mProcessDate = "undefined";
        $mProcessTime = "undefined";
        $mReturnCode = "OK";
        $mReturnMessage = "";

        $dom = new DOMDocument('1.0', 'utf-8');
        // 创建根元素 <xml>
        $xml = $dom->createElement('xml');
        // 创建 <SAP_APRV_RLT> 元素
        $sapAprvRlt = $dom->createElement('SAP_APRV_RLT');

        // 创建子元素并设置其文本内容
        $rtaskIdElement = $dom->createElement('RTaskID', 274605);
        $mFrgzuElement = $dom->createElement('m_FRGZU', $mFrgzu);
        $mProcessDateElement = $dom->createElement('m_PROCESS_DATE', $mProcessDate);
        $mProcessTimeElement = $dom->createElement('m_PROCESS_TIME', $mProcessTime);
        $mReturnCodeElement = $dom->createElement('m_RETURN_CODE', $mReturnCode);
        $mReturnMessageElement = $dom->createElement('m_RETURN_MESSAGE', $mReturnMessage);

        // 将子元素添加到 <SAP_APRV_RLT>
        $sapAprvRlt->appendChild($rtaskIdElement);
        $sapAprvRlt->appendChild($mFrgzuElement);
        $sapAprvRlt->appendChild($mProcessDateElement);
        $sapAprvRlt->appendChild($mProcessTimeElement);
        $sapAprvRlt->appendChild($mReturnCodeElement);
        $sapAprvRlt->appendChild($mReturnMessageElement);

        // 将 <SAP_APRV_RLT> 添加到根元素 <xml>
        $xml->appendChild($sapAprvRlt);

        // 将根元素添加到 DOM 文档
        $dom->appendChild($xml);

        // 格式化输出 XML 数据
        $dom->formatOutput = true;

        // 保存 XML 文档到文件
        // $dom->save('入雞通知單_飼育平台接收回傳_'.$rtaskId.'.xml');
        $dom->save('/mnt/bpm_test/Complete/入雞通知單_飼育平台接收回傳_test.xml');

        echo '入雞通知單_飼育平台接收回傳_' . $rtaskId . '.xml generated!';
    }
}