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

# 標準參考數據
standard_data = [43, 61, 79, 99, 122, 148, 176, 208, 242, 280, 321, 366, 414, 465, 519, 576, 637, 701, 768, 837,
                 910, 985, 1062, 1142, 1225, 1309, 1395, 1483, 1573, 1664, 1757, 1851, 1946, 2041, 2138, 2235]
standard_data_df = pd.DataFrame({'Weight': standard_data})

# MySQL 連接參數
config = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '110590050',
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
                        rw.time = '18:00:00'  -- 只選取每天早上的記錄
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
# 創建 DataFrame
subset_feed_data = feed_data[:]
for per_subset_feed_data in subset_feed_data:
    if not per_subset_feed_data:
        continue
    df = pd.DataFrame(per_subset_feed_data, columns=['Date','Weight','Feed_Type', 'Feed_Weight'])

    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Feed_Weight'] = df['Feed_Weight'].fillna(0)  # 將NaN值轉換為0
    df['Feed_Type'] = df['Feed_Type'].fillna('No_Feed')  # 將NaN值轉換為0
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
    current_length = len(df['Weight'])
    '''
    # 假設 df 是你的 DataFrame
    zero_feed_weight_count = (df['Feed_Weight'] != 0).sum()

    if zero_feed_weight_count == 0:
        # 取得 Feed_Weight 列的長度
        length = len(df['Feed_Weight'])
        
        # 用來替換的值
        replacement_value = 5566
        
        # 每三個替換一次
        for i in range(0, length, 3):
            df.loc[i, 'Feed_Weight'] = replacement_value  # 使用 .loc 替代 .iloc
            df.loc[i, 'Feed_Type'] = 'Ｎ肉雞３號(添)  P'  # 使用 .loc 替代 .iloc
    '''
    # 如果长度小于 33
    if current_length < 29:
        
    # 計算需要補充的數量
    
        needed_length = 33 - current_length
        
        # 從 standard_data_df 補充數據
        df_additional = standard_data_df.iloc[current_length:current_length+needed_length].reset_index(drop=True)
        last_date = df['Date'].iloc[-1]  # 獲取最後一個日期

        # 更新 Weight 和 Date
        df = pd.concat([df, df_additional], ignore_index=True)
        
        # 更新日期
        new_dates = [last_date + pd.Timedelta(days=i) for i in range(1, needed_length + 1)]
        
        # 使用 .loc 來賦值，避免警告
        df.loc[current_length:, 'Date'] = new_dates
         # 補充 Feed_Weight 為 0
        df.loc[current_length:, 'Feed_Weight'] = 0
        
        # 補充 Feed_Type 為 'No_Feed'
        df.loc[current_length:, 'Feed_Type'] = 'No_Feed'
        
        # 输出结果
    # 明確指定要進行編碼的類別
    categories = [['No_Feed', 'Mixed_Feed','Ｎ肉雞１號','Ｎ肉雞2號','Ｎ肉雞3號']]  # 所有可能的類別
    # 初始化編碼器，並設置 `handle_unknown='ignore'`
    encoder = OneHotEncoder(categories=categories, handle_unknown='ignore', sparse=False)

    # 進行編碼
    encoded_features = encoder.fit_transform(df[['Feed_Type']])

    # 將編碼後的特徵轉換為 DataFrame
    encoded_df = pd.DataFrame(encoded_features, columns=encoder.get_feature_names_out(['Feed_Type']))

    # 合併編碼後的特徵到原始數據集
    df_encoded = pd.concat([df.drop(columns=['Feed_Type']), encoded_df], axis=1)
    print(df_encoded.columns)
    scaler = MinMaxScaler(feature_range=(0, 1))
    data_scaled = scaler.fit_transform(df_encoded[['Weight', 'Feed_Weight'] + [col for col in df_encoded.columns if 'Feed_Type' in col]])

    # LSTM 模型需要 3D 輸入數據
    X_train = []
    y_train = []

    # 使用過去5天數據預測未來1天
    for i in range(5, len(data_scaled)):
        X_train.append(data_scaled[i-5:i, :])  # 將過去5天的所有特徵添加到 X_train
        y_train.append(data_scaled[i, 0])      # 目標是當前的 Weight

    X_train, y_train = np.array(X_train), np.array(y_train)

    # 調整輸入數據格式為 LSTM 所需的 3D 格式
    X_train = np.reshape(X_train, (X_train.shape[0], X_train.shape[1], X_train.shape[2]))
    n_step = X_train.shape[1]  # 這是時間步長
    n_feature = X_train.shape[2]  # 這是特徵數
    # 构建并优化 LSTM 模型
    model = Sequential()

    # 調整 LSTM 層單元數及 Dropout
    model.add(LSTM(units=50, activation='relu',return_sequences=False, input_shape=(n_step, n_feature)))
    model.add(Dense(units=1))

    model.compile(optimizer='adam', loss='mse', metrics=['mse', 'mape'])

    # 加载之前保存的模型权重
    try:
        model.load_weights("new_model.h5")
        print("成功加载模型权重。")
    except:
        print("未找到保存的权重文件，开始从头训练模型。")

    # 進行模型訓練
    early_stopping = EarlyStopping(monitor='val_loss', patience=10)

    model.fit(X_train, y_train, epochs=100, batch_size=20, validation_split=0.2, callbacks=[early_stopping])

    # 保存模型
    model.save("new_model.h5")