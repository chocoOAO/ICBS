import numpy as np
import pandas as pd
import matplotlib.pyplot as plt  # 導入 matplotlib 用於繪圖
import sys

def get_ye(x, y):
    m, _ = np.polyfit(x, y, 1)
    return m

def get_ift(ye, ift_tzxe, yzt_ift_tzxe, squat_, frm):
    if frm == 1001:
        for idx, row in ift_tzxe.iterrows():
            squat, end = [float(x) for x in row['slope'].split('-')]
            if squat <= ye < end:
                return row['index']
    else:
        yzt_ift_row = yzt_ift_tzxe[(yzt_ift_tzxe['Start Day'] == squat_) & (yzt_ift_tzxe['Frnum'] == frm)]
        if not yzt_ift_row.empty:
            return yzt_ift_row['Best Index'].values[0]
    return 1

def get_farm_name(frm, farm_tzxe):
    return farm_tzxe[farm_tzxe['Frnum'] == frm]['farm'].values[0]

def read_ift_tzxe(frm, input_):
    filename = f"index_{frm}.csv"
    ift_tzxe = pd.read_csv(filename)
    return ift_tzxe[ift_tzxe['input_'] == input_]

# 讀取數據
ift_tzxe = pd.read_csv('ind.csv')
yzt_ift_tzxe = pd.read_csv('combined_results.csv')
farm_tzxe = pd.read_csv('farm.csv')

input_list = sys.argv[1:]
squat_ = int(input_list[0]) - 4
wts = [float(x) for x in input_list[1:6]]
frm = int(input_list[6])

squat_farm = get_farm_name(frm, farm_tzxe)

# 計算斜率
x = np.array(range(squat_, squat_ + 5))
y = np.array(wts)
ye = get_ye(x, y)

it = wts[-1]
ift = get_ift(ye, ift_tzxe, yzt_ift_tzxe, squat_, frm)

# 預測重量並記錄下來
wt_s_rs = []
predicted_days = []

for i in range(21, 36):
    x = i - squat_
    x = x - 4
    pd_wt = it + ye * (x ** ift)
    wt_s_rs.append(round(pd_wt, 2))
    predicted_days.append(i)  # 記錄預測的天數

# 輸出預測的重量
output_str = ' '.join(format(w, ".2f") for w in wt_s_rs)
print(output_str)

# 繪製圖表
plt.figure(figsize=(10, 6))
plt.plot(predicted_days, wt_s_rs, marker='o', linestyle='-', color='b')
plt.title('預測小雞重量')
plt.xlabel('天數')
plt.ylabel('預測重量 (公斤)')
plt.xticks(predicted_days)  # 設置x軸刻度
plt.grid(True)

# 在每個點上顯示預測的重量
for day, weight in zip(predicted_days, wt_s_rs):
    plt.text(day, weight, str(weight), fontsize=9, ha='center', va='bottom')

plt.show()
