import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import LSTM, Dense
import matplotlib.pyplot as plt
from tensorflow.keras.models import load_model
from tensorflow.keras.optimizers import Adam
from keras.layers import Dropout


standard_data = [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235]
# MySQL 連接參數
config = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '@Abaaa95166',
    'database': 'fms'
}

# 與 MySQL 連接
data = []
try:
    connection = mysql.connector.connect(**config)
    if connection.is_connected():
        print("成功連接到數據庫")
        cursor = connection.cursor()

        # Step 1: 獲取所有的 batchNumber
        batch_number_list_query = "SELECT DISTINCT batchNumber FROM raw_weights WHERE time='06:00:00';"
        cursor.execute(batch_number_list_query)
        batch_numbers = cursor.fetchall()  # 獲取所有 batchNumber 結果
        batch_number_list = [batch[0] for batch in batch_numbers]
        for batch in batch_number_list:            
            # 查詢當前 batchNumber 的數據
            query = f"SELECT sid FROM sensorlist WHERE batchNumber = '{batch}';"
            # query = f"SELECT Date, weight FROM raw_weights WHERE batchNumber = '{batch}' AND time='06:00:00';"
            cursor.execute(query)
            sid_numbers = cursor.fetchall()  # 獲取所有 batchNumber 結果
            sid_list = [sid[0] for sid in sid_numbers]
            for sid in sid_list:
                query = f"SELECT Date, weight FROM raw_weights WHERE batchNumber = '{batch}' AND time ='06:00:00' AND sid = '{sid}';"
                cursor.execute(query)
                data_per_batch_number = []
                for result in cursor:
                    data_per_batch_number.append(result)
                data.append(data_per_batch_number)
            # 获取查询结果
            
except mysql.connector.Error as err:
    print(f"錯誤: {err}")

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL 連接已關閉")
# 創建 DataFrame

subset_data = data
for data_per_batch_number in subset_data:
    print(data_per_batch_number)
    df = pd.DataFrame(data_per_batch_number, columns=['Date', 'Weight'])
    # 替換0值：將0值替換為standard_data中對應位置的資料
    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
    print("最前面五筆重量資料:")
    print(df)
    print("--------------------------------------------")