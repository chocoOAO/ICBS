import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential
from keras.layers import LSTM, Dense, Dropout
import matplotlib.pyplot as plt
from tensorflow.keras.optimizers import Adam
import re
from sklearn.preprocessing import OneHotEncoder
from tensorflow.keras.callbacks import EarlyStopping
import random
from tensorflow.keras.models import load_model
from sklearn.metrics import mean_absolute_error, mean_squared_error  # 引入誤差計算

# 標準參考數據
standard_data = [43, 61, 79, 99, 122, 148, 176, 208, 242, 280, 321, 366, 414, 465, 519, 576, 637, 701, 768, 837,
                 910, 985, 1062, 1142, 1225, 1309, 1395, 1483, 1573, 1664, 1757, 1851, 1946, 2041, 2138, 2235]
standard_data_df = pd.DataFrame({'Weight': standard_data})

# MySQL 連接參數
config = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '@Abaaa95166',
    'database': 'fms'
}

# 與 MySQL 連接
feed_data = []
try:
    connection = mysql.connector.connect(**config)
    if connection.is_connected():
        print("成功連接到數據庫")
        cursor = connection.cursor()

        # Step 1: 獲取所有的 batchNumber
        batch_number_list_query = "SELECT DISTINCT chicken_import_id FROM feeding_logs;"
        cursor.execute(batch_number_list_query)
        batch_numbers = cursor.fetchall()
        batch_number_list = [batch[0] for batch in batch_numbers]
        print(f"找到 {len(batch_number_list)} 個批次")

        # Step 2: 遍歷所有 batchNumber，並查詢其餵食數據
        for batch in batch_number_list:
            # 根據 batchNumber 找到相對應的 sid
            query = f"SELECT sid FROM sensorlist WHERE batchNumber = '{batch}';"
            cursor.execute(query)
            sid_numbers = cursor.fetchall()
            sid_list = [sid[0] for sid in sid_numbers]

            for sid in sid_list:
                # 根據 sid 查找 shed_name，並從中提取出 building_number
                query = f"SELECT shed_name FROM field_names WHERE sid = '{sid}';"
                cursor.execute(query)
                shed_name = cursor.fetchall()
                building_number = shed_name[0][0].split('_')[-1]

                # 查詢每個 batchNumber 每天的重量和餵食數據，並將同一天的餵食數據進行聚合
                query = f"""
                    SELECT 
                        rw.Date, 
                        rw.weight, 
                        GROUP_CONCAT(fl.feed_item SEPARATOR ',') AS feed_items,  -- 合併餵食類型
                        SUM(fl.feed_quantity) AS total_feed_quantity  -- 聚合餵食量
                    FROM 
                        raw_weights rw
                    LEFT JOIN 
                        feeding_logs fl 
                    ON 
                        rw.batchNumber = fl.chicken_import_id 
                    AND 
                        rw.Date = fl.date 
                    AND 
                        fl.building_number = '{building_number}'
                    WHERE 
                        rw.batchNumber = '{batch}' 
                    AND 
                        rw.time = '06:00:00'  -- 只選取每天早上的記錄
                    AND 
                        rw.sid = '{sid}'
                    GROUP BY 
                        rw.Date, rw.weight  -- 添加 rw.weight 到 GROUP BY 中
                    ORDER BY 
                        rw.Date;
                """

                cursor.execute(query)
                feed_data_per_batch_number = []
                for result in cursor:
                    feed_data_per_batch_number.append(result)
                feed_data.append(feed_data_per_batch_number)

        # 查詢所有不同的飼料種類
        query = f"SELECT DISTINCT feed_item FROM feeding_logs;"
        cursor.execute(query)
        feed_item_lists = cursor.fetchall()
        feed_item_list = [feed_item[0] for feed_item in feed_item_lists]

except mysql.connector.Error as err:
    print(f"錯誤: {err}")

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL 連接已關閉")

count = 0
# 隨機化數據
random.shuffle(feed_data)
subset_data = [entry for entry in feed_data[:20]]  # 取出每個 batch 的前 21 筆數據
for data_per_batch_number in subset_data:
    origin_df = pd.DataFrame(feed_data[count], columns=['Date', 'Weight', 'Feed_Type', 'Feed_Weight'])
    df = pd.DataFrame(data_per_batch_number, columns=['Date', 'Weight', 'Feed_Type', 'Feed_Weight'])

    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Feed_Weight'] = df['Feed_Weight'].fillna(0)  # 將NaN值轉換為0
    df['Feed_Type'].replace([None, np.nan], 'No_Feed', inplace=True)  # 將NaN值轉換為'No_Feed'

    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
    df['Feed_Type'] = df.apply(lambda x: 'Mixed_Feed' if ',' in str(x['Feed_Type']) else x['Feed_Type'], axis=1)
    df['Feed_Type'] = df.apply(
        lambda x: 'Ｎ肉雞１號' if 'Ｎ肉雞１號' in str(x['Feed_Type']) else x['Feed_Type'],
        axis=1
    )
    df['Feed_Type'] = df.apply(
        lambda x: 'Ｎ肉雞2號' if 'Ｎ肉雞２號' in str(x['Feed_Type']) else x['Feed_Type'],
        axis=1
    )
    df['Feed_Type'] = df.apply(
        lambda x: 'Ｎ肉雞3號' if 'Ｎ肉雞３號' in str(x['Feed_Type']) else x['Feed_Type'],
        axis=1
    )

    # 明確指定要進行編碼的類別
    categories = [['No_Feed', 'Mixed_Feed', 'Ｎ肉雞１號', 'Ｎ肉雞2號', 'Ｎ肉雞3號']]  # 所有可能的類別
    # 初始化編碼器，並設置 `handle_unknown='ignore'`
    encoder = OneHotEncoder(categories=categories, handle_unknown='ignore', sparse=False)
    
    # 進行編碼
    encoded_features = encoder.fit_transform(df[['Feed_Type']])

    # 將編碼後的特徵轉換為 DataFrame
    encoded_df = pd.DataFrame(encoded_features, columns=encoder.get_feature_names_out(['Feed_Type']))

    # 合併編碼後的特徵到原始數據集
    df_encoded = pd.concat([df.drop(columns=['Feed_Type']), encoded_df], axis=1)

    # 初始化 scaler
    scaler = MinMaxScaler()

    # 確保只選擇數值列進行縮放
    numeric_columns = ['Weight', 'Feed_Weight'] + [col for col in df_encoded.columns if 'Feed_Type' in col]
    data_scaled = scaler.fit_transform(df_encoded[numeric_columns])

    features = ['Weight', 'Feed_Weight'] + [col for col in df_encoded.columns if 'Feed_Type' in col]

    # 載入模型
    model = load_model("new_model.h5")

    # 使用最後 5 筆數據的所有特徵
    initial_data = df_encoded[features].values[16:21]  # 確保提取所有特徵
    initial_data_scaled = scaler.transform(initial_data)  # 直接轉換，而不是重塑
    current_input = initial_data_scaled.reshape(1, 5, len(numeric_columns))  # 使用最後五筆數據作為初始輸入
    predicted_weights = [df_encoded['Weight'].iloc[20]]
    predicted_dates = [df_encoded['Date'].iloc[20]]
    predicted_date = 35 - 21
    count_day = 0

    # 滑動窗口預測未來的重量，直到達到2100或30天
    for day in range(predicted_date):  # 預測30天
        predicted_weight_scaled = model.predict(current_input)
        predicted_weight_scaled_reshaped = np.zeros((1, len(numeric_columns)))  # 確保形狀正確
        predicted_weight_scaled_reshaped[0, 0] = predicted_weight_scaled  # 將預測的重量存入第一列

        # 設定未來餵食量隨機變化
        future_feed_weight = np.random.choice(range(30, 200))  # 隨機餵食量
        predicted_weight_scaled_reshaped[0, 1] = future_feed_weight  # 將未來餵食量放入第二列

        # 將餵食類型設為隨機選擇
        feed_type_idx = np.random.randint(0, len(categories[0]))  # 隨機選擇類別索引
        feed_type_one_hot = np.zeros(len(categories[0]))  # 創建一個全為零的數組
        feed_type_one_hot[feed_type_idx] = 1  # 設定對應索引為1

        # 將餵食類型合併到預測結果中
        predicted_weight_scaled_reshaped[0, 2:] = feed_type_one_hot

        predicted_weights.append(scaler.inverse_transform(predicted_weight_scaled_reshaped)[0, 0])  # 將預測值反向縮放
        predicted_dates.append(pd.to_datetime(df_encoded['Date'].iloc[20]) + pd.Timedelta(days=day + 1))  # 更新日期

        # 更新 current_input 進行下一次預測
        current_input = np.append(current_input[:, 1:, :], predicted_weight_scaled.reshape(1, 1, -1), axis=1)

    # 計算 MAE 和 RMSE
    actual_weights = origin_df['Weight'].iloc[-len(predicted_weights):].values  # 取出最後幾個實際重量
    print(actual_weights)
    print(predicted_weights)

    mae = mean_absolute_error(actual_weights, predicted_weights)
    mse = mean_squared_error(actual_weights, predicted_weights)
    rmse = np.sqrt(mse)

    print(f"MAE: {mae:.2f}")
    print(f"RMSE: {rmse:.2f}")

    # 繪製實際與預測的圖形
    plt.figure(figsize=(14, 6))
    plt.plot(predicted_dates, predicted_weights, label='Predicted Weights', color='blue')
    plt.plot(origin_df['Date'], origin_df['Weight'], label='Actual Weights', color='red')
    plt.title('Predicted Weights vs Actual Weights')
    plt.xlabel('Date')
    plt.ylabel('Weight')
    plt.legend()
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.show()

    count += 1
