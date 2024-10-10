import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from keras.models import Sequential, load_model
from keras.layers import LSTM, Dense, Dropout
import matplotlib.pyplot as plt
from tensorflow.keras.optimizers import Adam
from sklearn.preprocessing import OneHotEncoder
from tensorflow.keras.callbacks import EarlyStopping
import random
from sklearn.metrics import mean_squared_error, mean_absolute_error

actual_weights_1 = np.array([1758,1786,1907,1957,2116])  # 替換為真實數據
predicted_weights_1 = np.array([1743, 1859, 1942, 1958, 2065])  # 替換為模型一的預測結果


# 示例：假設實際重量和預測重量
actual_weights_2 = np.array([1758,1786,1907,1957,2116])  # 替換為真實數據
predicted_weights_2 = np.array([1785, 1875, 1966, 2056, 2148])  # 替換為模型二的預測結果

# -----------------------------------
# 計算MAE和RMSE
# -----------------------------------

# 模型一評估
mae_1 = mean_absolute_error(actual_weights_1, predicted_weights_1)
rmse_1 = np.sqrt(mean_squared_error(actual_weights_1, predicted_weights_1))

# 模型二評估
mae_2 = mean_absolute_error(actual_weights_2, predicted_weights_2)
rmse_2 = np.sqrt(mean_squared_error(actual_weights_2, predicted_weights_2))

# -----------------------------------
# 輸出評估結果
# -----------------------------------
print("模型一的評估指標：")
print(f"MAE: {mae_1:.2f}")
print(f"RMSE: {rmse_1:.2f}")

print("\n模型二的評估指標：")
print(f"MAE: {mae_2:.2f}")
print(f"RMSE: {rmse_2:.2f}")

# -----------------------------------
# 繪製預測結果比較
# -----------------------------------
plt.figure(figsize=(12, 6))
plt.plot(actual_weights_1, label='actual_quantity', color='blue', marker='o')
plt.plot(predicted_weights_1, label='LSTM', color='red', linestyle='--', marker='x')
plt.plot(predicted_weights_2, label='linear-regression', color='green', linestyle='--', marker='s')
plt.xlabel('number')
plt.ylabel('weight')
plt.title('Compare')
plt.legend()
plt.grid(True)
plt.tight_layout()
plt.show()