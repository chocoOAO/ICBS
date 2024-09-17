import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import LSTM, Dense
import matplotlib.pyplot as plt
from tensorflow.keras.models import load_model
from tensorflow.keras.optimizers import Adam

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
                results = cursor.fetchall()  # 或者用 cursor.fetchmany(21) 限制讀取的數量
                data_per_batch_number = []
                for result in results:
                    data_per_batch_number.append(result)
                    if len(data_per_batch_number) > 21:
                        break
                data.append(data_per_batch_number)
        print(data[0])
            # 获取查询结果
            
except mysql.connector.Error as err:
    print(f"錯誤: {err}")

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL 連接已關閉")


# 創建 DataFrame
subset_data = data[:3]
for data_per_batch_number in subset_data:
    df = pd.DataFrame(data_per_batch_number, columns=['Date', 'Weight'])
    # 替換0值：將0值替換為standard_data中對應位置的資料
    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
    # 將數據縮放到 (0,1) 範圍
    scaler = MinMaxScaler(feature_range=(0, 1))
    data_scaled = scaler.fit_transform(df[['Weight']])
    # 載入模型
    model = load_model("my_model.h5")


    # 使用最後的5筆數據進行預測
    initial_data = df['Weight'].values[-5:]
    initial_data_scaled = scaler.transform(initial_data.reshape(-1, 1))
    print(initial_data)
    # 使用滑動窗口進行未來的預測
    predicted_weights = [df['Weight'].iloc[-1]]
    predicted_dates = [df['Date'].iloc[-1]]
    current_input = initial_data_scaled.reshape(1, -1, 1)  # 使用最後五筆數據作為初始輸入
    predicted_date= 35-len(df['Date'])
    # 滑動窗口預測未來的重量，直到達到2100或30天
    for day in range(predicted_date):  # 預測30天
        predicted_weight_scaled = model.predict(current_input)
        predicted_weight = scaler.inverse_transform(predicted_weight_scaled)[0, 0]
        predicted_weights.append(predicted_weight)

        # 計算日期，從第6天開始
        next_date = pd.to_datetime(df['Date'].iloc[-1]) + pd.Timedelta(days=day + 1)
        predicted_dates.append(next_date.date())

        # 打印預測結果
        print(f"預測日期：{next_date.date()}, 預測重量：{predicted_weight:.2f}")

        if predicted_weight > 2100:
            print("預測重量超過 2100，停止預測。")
            break

        # 更新輸入數據，使用最新的預測值加入進滑動窗口
        predicted_weight_scaled_reshaped = np.reshape(predicted_weight_scaled, (1, 1, 1))  # 重塑為三維數據
        next_input = np.append(current_input[:, 1:, :], predicted_weight_scaled_reshaped, axis=1)
        current_input = next_input

    # 繪製實際數據和預測結果
    plt.figure(figsize=(12, 6))
    plt.plot(df['Date'], df['Weight'], label='實際重量', color='blue')
    plt.plot(predicted_dates, predicted_weights, label='預測重量', color='red', linestyle='--')
    plt.xlabel('日期')
    plt.ylabel('重量')
    plt.title('重量預測')
    plt.legend()
    plt.grid(True)
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.show()