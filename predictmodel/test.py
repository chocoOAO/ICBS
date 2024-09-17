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
    df = pd.DataFrame(data_per_batch_number, columns=['Date', 'Weight'])
    # 替換0值：將0值替換為standard_data中對應位置的資料
    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
    print("最前面五筆重量資料:")
    print(df.head())

    # 将数据缩放到 (0,1) 范围
    scaler = MinMaxScaler(feature_range=(0, 1))
    data_scaled = scaler.fit_transform(df[['Weight']])
    # print(data_scaled)
    # LSTM 模型需要 3D 输入数据
    X_train = []
    y_train = []

    # 使用过去5天预测未来1天
    for i in range(5, len(data_scaled)):
        X_train.append(data_scaled[i-5:i, 0])  # 前5天
        y_train.append(data_scaled[i, 0])  # 第6天

    X_train, y_train = np.array(X_train), np.array(y_train)
    # 调整输入数据格式为 LSTM 所需的 3D 格式
    X_train = np.reshape(X_train, (X_train.shape[0], X_train.shape[1], 1))

    # 重新构建 LSTM 模型（与之前模型结构一致）
    model = Sequential()
    model.add(LSTM(units=50, return_sequences=True, input_shape=(X_train.shape[1], 1)))
    model.add(Dropout(0.2))
    # Adding a second LSTM layer and some Dropout regularisation
    model.add(LSTM(units = 50, return_sequences = True))
    model.add(Dropout(0.2))

    # Adding a third LSTM layer and some Dropout regularisation
    model.add(LSTM(units = 50, return_sequences = True))
    model.add(Dropout(0.2))

    # Adding a fourth LSTM layer and some Dropout regularisation
    model.add(LSTM(units = 50))
    model.add(Dropout(0.2))
    model.add(Dense(units = 1))
    model.compile(optimizer='adam', loss='mean_squared_error')

    # 加载之前保存的模型权重
    try:
        model.load_weights("my_model.h5")
        print("成功加载模型权重。")
    except:
        print("未找到保存的权重文件，开始从头训练模型。")

    # 继续训练模型
    model.fit(X_train, y_train, epochs = 100, batch_size = 32)
    
    # 保存更新后的模型
    model.save("my_model.h5")
    