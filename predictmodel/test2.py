import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import LSTM, Dense, Dropout
import matplotlib.pyplot as plt
from tensorflow.keras.optimizers import Adam

# 標準參考數據
standard_data = [43, 61, 79, 99, 122, 148, 176, 208, 242, 280, 321, 366, 414, 465, 519, 576, 637, 701, 768, 837,
                 910, 985, 1062, 1142, 1225, 1309, 1395, 1483, 1573, 1664, 1757, 1851, 1946, 2041, 2138, 2235]

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
        batch_numbers = cursor.fetchall()
        batch_number_list = [batch[0] for batch in batch_numbers]

        for batch in batch_number_list:
            query = f"SELECT sid FROM sensorlist WHERE batchNumber = '{batch}';"
            cursor.execute(query)
            sid_numbers = cursor.fetchall()
            sid_list = [sid[0] for sid in sid_numbers]
            for sid in sid_list:
                query = f"SELECT Date, weight FROM raw_weights WHERE batchNumber = '{batch}' AND time ='06:00:00' AND sid = '{sid}';"
                cursor.execute(query)
                data_per_batch_number = []
                for result in cursor:
                    data_per_batch_number.append(result)
                data.append(data_per_batch_number)

except mysql.connector.Error as err:
    print(f"錯誤: {err}")

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL 連接已關閉")

# 創建 DataFrame
print(len(data))
subset_data = data[:20]
for data_per_batch_number in subset_data:
    df = pd.DataFrame(data_per_batch_number, columns=['Date', 'Weight'])
    
    # 替換0值並使用standard_data填補
    df['Weight'] = df['Weight'].replace(0, np.nan)
    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))
    
    print("最前面五筆重量資料:")
    print(df.head())

    # 將數據縮放到 (0, 2) 範圍
    scaler = MinMaxScaler(feature_range=(0, 2))
    data_scaled = scaler.fit_transform(df[['Weight']])
    
    # LSTM 模型需要 3D 輸入數據
    X_train = []
    y_train = []

    # 使用過去5天數據預測未來1天
    for i in range(5, len(data_scaled)):
        X_train.append(data_scaled[i-5:i, 0])
        y_train.append(data_scaled[i, 0])

    X_train, y_train = np.array(X_train), np.array(y_train)
    
    # 調整輸入數據格式為 LSTM 所需的 3D 格式
    X_train = np.reshape(X_train, (X_train.shape[0], X_train.shape[1], 1))

    # 构建并优化 LSTM 模型
    model = Sequential()

    # 調整 LSTM 層單元數及 Dropout
    model.add(LSTM(units=50, return_sequences=True, input_shape=(X_train.shape[1], 1)))
    model.add(Dropout(0.6))
    model.add(LSTM(units=50, return_sequences=True))
    model.add(Dropout(0.6))
    model.add(LSTM(units=50, return_sequences=True))
    model.add(Dropout(0.6))
    model.add(LSTM(units=50))
    model.add(Dropout(0.6))
    model.add(Dense(units=1))

    # 調整 Adam 優化器的學習率
    optimizer = Adam(learning_rate=0.0005)
    model.compile(optimizer=optimizer, loss='mean_absolute_error')

    # 加载之前保存的模型权重
    try:
        model.load_weights("new_model_4.h5")
        print("成功加载模型权重。")
    except:
        print("未找到保存的权重文件，开始从头训练模型。")

    # 進行模型訓練
    model.fit(X_train, y_train, epochs=150, batch_size=32)

    # 保存模型
    model.save("new_model_4.h5")

    # 使用模型進行預測
    predicted_weight = model.predict(X_train)
    predicted_weight = scaler.inverse_transform(predicted_weight)  # 反標準化

    # 可視化預測結果與實際數據
    plt.plot(df['Weight'].values, color='blue', label='Actual Weight')
    plt.plot(range(5, len(predicted_weight) + 5), predicted_weight, color='red', label='Predicted Weight')
    plt.title('Weight Prediction vs Actual')
    plt.xlabel('Days')
    plt.ylabel('Weight')
    plt.legend()
    # plt.show()