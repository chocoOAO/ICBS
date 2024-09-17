import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import LSTM, Dense
import matplotlib.pyplot as plt

standard_data = [43,61,79,99,122,148,176,208,242,280,321,366,414,465,519,576,637,701,768,837,910,985,1062,1142,1225,1309,1395,1483,1573,1664,1757,1851,1946,2041,2138,2235];
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

        # 查詢數據
        query = "SELECT Date, weight FROM raw_weights WHERE batchNumber = 'A11305105' and time='06:00:00';"
        cursor.execute(query)
        for result in cursor:
            data.append(result)

except mysql.connector.Error as err:
    print(f"錯誤: {err}")

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL 連接已關閉")

# 創建 DataFrame
df = pd.DataFrame(data, columns=['Date', 'Weight'])
# 替換0值：將0值替換為standard_data中對應位置的資料
df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
print("最前面五筆重量資料:")
print(df)

# 處理0值：替換為NaN，再用前一個有效值填充
'''df['Weight'] = df['Weight'].replace(0, np.nan)
df['Weight'].fillna(method='ffill', inplace=True)
'''
# 將數據縮放到 (0,1) 範圍
scaler = MinMaxScaler(feature_range=(0, 1))
data_scaled = scaler.fit_transform(df[['Weight']])
print(data_scaled)
# LSTM 模型需要 3D 輸入數據
X_train = []
y_train = []

# 使用過去5天預測未來1天
for i in range(5, len(data_scaled)):
    X_train.append(data_scaled[i-5:i, 0])  # 前5天
    y_train.append(data_scaled[i, 0])  # 第6天

X_train, y_train = np.array(X_train), np.array(y_train)

# 調整輸入數據格式為 LSTM 所需的 3D 格式
X_train = np.reshape(X_train, (X_train.shape[0], X_train.shape[1], 1))

# 構建 LSTM 模型
model = Sequential()
model.add(LSTM(units=100, return_sequences=True, input_shape=(X_train.shape[1], 1)))
model.add(LSTM(units=100))
model.add(Dense(1))

model.compile(optimizer='adam', loss='mean_squared_error')

# 訓練模型
model.fit(X_train, y_train, epochs=10, batch_size=1, verbose=2)
model.save("my_model.h5")

# 使用最後的5筆數據進行預測
initial_data = df['Weight'].values[-5:]
initial_data_scaled = scaler.transform(initial_data.reshape(-1, 1))

# 使用滑動窗口進行未來的預測
predicted_weights = []
predicted_dates = []
current_input = initial_data_scaled.reshape(1, -1, 1)  # 使用最後五筆數據作為初始輸入

# 滑動窗口預測未來的重量，直到達到2100或30天
for day in range(30):  # 預測30天
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
