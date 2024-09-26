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
standard_data_df = pd.DataFrame({'Weight': standard_data})
# MySQL 連接參數
config = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '1478529',
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
                query = f"SELECT shed_name FROM field_names WHERE sid = '{sid}';"
                cursor.execute(query)
                shed_name = cursor.fetchall()
                building_number = shed_name[0][0].split('_')[-1]
                query = f"select feed_item,feed_quantity from feeding_logs where chicken_import_id = '{batch}' AND building_number = '{building_number}';"
                cursor.execute(query)
                feed_data_per_batch_number = []
                for result in cursor:
                    feed_data_per_batch_number.append(result)
                feed_data.append(feed_data_per_batch_number)
                

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