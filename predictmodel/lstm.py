import mysql.connector
import pandas as pd

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
        query = "SELECT Date, weight FROM raw_weights WHERE batchNumber = 'A11305105';"
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
print(df['Date'])
# df['Date'] = pd.to_datetime(df['Date'])
# df = df.sort_values('Date')
# df.set_index('Date', inplace=True)

