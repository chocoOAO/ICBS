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
from collections import Counter

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
        #batch_number_list_query = "SELECT DISTINCT batchNumber FROM raw_weights"
        batch_number_list_query = "SELECT DISTINCT chicken_import_id FROM feeding_logs;"
        cursor.execute(batch_number_list_query)
        batch_numbers = cursor.fetchall()
        batch_number_list = [batch[0] for batch in batch_numbers]
        for batch in batch_number_list:
            query = f"SELECT sid FROM sensorlist WHERE batchNumber = '{batch}';"
            cursor.execute(query)
            sid_numbers = cursor.fetchall()
            sid_list = [sid[0] for sid in sid_numbers]
            for sid in sid_list:
                query = f"SELECT shed_name FROM field_names WHERE sid = '{sid}';"
                cursor.execute(query)
                shed_name = cursor.fetchall()
                building_number = shed_name[0][0].split('_')[-1]
                query = f"""
                        SELECT 
                            rw.Date, 
                            rw.weight, 
                            fl.feed_item, 
                            fl.feed_quantity 
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
                            rw.time = '06:00:00' 
                        AND 
                            rw.sid = '{sid}'
                        ORDER BY 
                            rw.Date;
                        """

                cursor.execute(query)
                feed_data_per_batch_number = []
                for result in cursor:
                    feed_data_per_batch_number.append(result)
                feed_data.append(feed_data_per_batch_number)
        query = f"select distinct feed_item from feeding_logs;"
        cursor.execute(query)
        feed_item_lists= cursor.fetchall()
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
print(subset_feed_data)

# 統計 Feed_Type 的數量
feed_type_counter = Counter()

# 對所有批次的數據統計Feed_Type
for per_subset_feed_data in subset_feed_data:
    if not per_subset_feed_data:
        continue
    df = pd.DataFrame(per_subset_feed_data, columns=['Date','Weight','Feed_Type', 'Feed_Weight'])
    feed_type_counter.update(df['Feed_Type'])

# 定義少數類別的閾值 (例如: 少於 50)
minority_threshold = 50
minority_feed_types = [ft for ft, count in feed_type_counter.items() if count < minority_threshold]

print('minority_feed_types:',minority_feed_types)
# 增強函數 - 加入噪聲
def add_noise(df, noise_level=0.1):
    noisy_data = df.copy()
    noisy_data['Weight'] += noise_level * np.random.randn(len(df))
    noisy_data['Feed_Weight'] += noise_level * np.random.randn(len(df))
    return noisy_data

# 初始化增強後的數據集列表
augmented_feed_data = []

# 對於每一批數據進行處理
for per_subset_feed_data in subset_feed_data:
    if not per_subset_feed_data:
        continue
    df = pd.DataFrame(per_subset_feed_data, columns=['Date','Weight','Feed_Type', 'Feed_Weight'])

    df['Weight'] = df['Weight'].replace(0, np.nan)  # 將0值轉換為NaN
    df['Feed_Weight'] = df['Feed_Weight'].fillna(0)  # 將NaN值轉換為0
    df['Feed_Type'] = df['Feed_Type'].fillna('No_Feed')  # 將NaN值轉換為0
    df['Weight'] = df['Weight'].combine_first(pd.Series(standard_data))  # 用standard_data對應位置的值填充NaN
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
    if current_length < 33:
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
    
    # 初始化當前批次的增強後數據
    current_augmented_data = df.copy()

    # 找到少數類別的資料
    minority_data = df[df['Feed_Type'].isin(minority_feed_types)]

    if not minority_data.empty:
        current_augmented_data = current_augmented_data[~current_augmented_data['Feed_Type'].isin(minority_feed_types)]
    
        # 2. 對少數類別資料進行噪聲增強
        augmented_minority_data = add_noise(minority_data)
        
        # 3. 將增強後的資料添加到當前批次的數據中
        current_augmented_data = pd.concat([current_augmented_data, augmented_minority_data], ignore_index=True)
    
    # 將增強後的批次數據存回列表
    augmented_feed_data.append(current_augmented_data)
# 將 augmented_feed_data 轉換為元組的格式
augmented_list = []
for afd in augmented_feed_data:
    augmented_per_list=[]
    for row in afd:
         print(row)
