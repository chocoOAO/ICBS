import numpy as np
import pandas as pd
import rmsd
import sys
import json

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


# ift_tzxe = pd.read_csv('./ind.csv')
# yzt_ift_tzxe = pd.read_csv('./combined_results.csv')
# farm_tzxe = pd.read_csv('./farm.csv')

ift_tzxe = pd.read_csv('./public/py/ind.csv')
ift_tzxe = ift_tzxe.replace('>120', '120-999') # 改寫斜率，from >120 to 120-999
yzt_ift_tzxe = pd.read_csv('./public/py/combined_results.csv')
farm_tzxe = pd.read_csv('./public/py/farm.csv')

input_list = sys.argv[1:]
# input_list = ["21", "637" ,"701","768","837","910","1"]
# print("Hello World2")

squat_ = int(input_list[0]) - 4

wts = [float(x) for x in input_list[1:6]]
frm = int(input_list[6])

squat_farm = get_farm_name(frm, farm_tzxe)


x = np.array(range(squat_, squat_ + 5))
y = np.array(wts)
ye = get_ye(x, y)


it = wts[-1]

ift = get_ift(ye, ift_tzxe, yzt_ift_tzxe, squat_, frm)


wt_s_rs = []
# for i in range(2,len(sys.argv)-1):
#     wt_s_rs.append(float(sys.argv[i]))

for i in range(31, 36):
    x = i - squat_
    x = x - 4
    pd_wt = it + ye * (x ** ift)
    wt_s_rs.append(round(pd_wt, 2))


output_str = ' '.join(format(w, ".2f") for w in wt_s_rs)

print(output_str)
# # date_str = []
# # date = int(sys.argv[1])-6
# # for i in range(1,11):
# #     date_str.append(date+i)

# # data = {
# #     'date': date_str,
# #     'weight': wt_s_rs
# # }

# # json_str = json.dumps(data)
# # sys.stdout.write(json_str)

# # def send():
# #     a = "12,13,14,15,16"
# #     print(a)
# # if __name__ == '__main__':
# #     send()
