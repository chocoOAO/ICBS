<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\ZCusKna1;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserPermissionManagement extends Component
{

    public $z_cus_kna1; //客戶主檔資料
    public $selectedRole;
    public $selectedPermission;
    public $data;
    public $m_KUNAG;
    public $test;
    public $original_data;

    public $auth_type = [
        // Super User 權限
        'super_admin' => '超級管理員',
        'admin' => '管理員',
        'worker' => '業務員',
        'collaborator' => '場管理員',
        'factory_worker' => '場作業員',
    ];

    public $controll_type = [
        '1' => '無法查看',
        '2' => '讀取', // 能查看就能列印
        '3' => '新增', //只能對新增的資料進行修改、刪除
        '4' => '管理', // 能對過往紀錄修改、刪除
    ];

    public $page = [
        0 => '合約',
        1 => '飼養入雛表',
        2 => '農戶飼養紀錄表',
        3 => '預測列',
        4 => '抓雞派車單',
        5 => '產銷履歷',
        6 => '毛雞結款單',
        7 => '飼養數據圖',
        8 => '權限管理',
    ];

    public $operatePermissions = ['新增', '讀取', '修改', '刪除', '列印'];

    public function mount(Request $request)
    {
        $trans_to_array = true;

        //搜尋功能
        if ($request->search){
            $this->data = $request->data;
            //將網址列的request清空
            $request->search = null;
            $trans_to_array = false;
        }

        //還原操作
        else if ($request->reset_request || $request->data == null) {
            $this->original_data = User::where('auth_type', '!=', "super_admin")->orderByRaw("FIELD(auth_type, 'admin', 'worker', 'collaborator', 'factory_worker')")->get();
            if (Auth::user()->auth_type == 'worker') {
                if (Auth::user()->m_KUNAG != null) {
                    $this->original_data = $this->original_data->where('auth_type', '!=', 'admin')->where('m_KUNAG', '=', Auth::user()->m_KUNAG);
                }
                else {
                    $this->original_data = $this->original_data->where('auth_type', '!=', 'admin');
                }
            }
            else if (Auth::user()->auth_type == 'collaborator' || Auth::user()->auth_type == 'factory_worker') {
                $this->original_data = $this->original_data->where('auth_type', '!=', 'admin')->where('auth_type', '!=', 'worker')->where('m_KUNAG', '=', Auth::user()->m_KUNAG);
            }
        }

        //lalavel自動刷新頁面保留以改動的資料用
        else if ($request->data != null) {
            $this->data = $request->data;
            $request->data = null;
            $trans_to_array = false;
            // dd($this->data);
        }

        //將資料轉成陣列才能進行編輯
        if ($trans_to_array) {
            $this->data = $this->original_data;
            $this->data = $this->data->toArray();
        }

        $this->z_cus_kna1 = ZCusKna1::all()->toArray();
    }

    public function submit()
    {
        foreach ($this->data as $value) {
            $user = User::find($value['id']);
            $user->auth_type = $value['auth_type'];
            $user->permissions = $value['permissions'];

            if (isset($value['m_KUNAG'])) {
                //允許業務員不用選擇客戶主檔看到所有的客戶
                if ($value['m_KUNAG'] == '無指定'){
                    $user->m_KUNAG = null;
                }
                else{
                    $user->m_KUNAG = $value['m_KUNAG'];
                }
            }

            $user->save();
        }
        return redirect()->route('user-permission-management');
    }

    public function updateRole($index)
    {
        $this->data[$index]['auth_type'] = $this->selectedRole;
        if ($this->data[$index]['auth_type'] == 'admin') {
            $this->data[$index]['permissions'] = '444244444';
        } elseif ($this->data[$index]['auth_type'] == 'worker') {
            $this->data[$index]['permissions'] = '333233334';
        } elseif ($this->data[$index]['auth_type'] == 'collaborator') {
            $this->data[$index]['permissions'] = '213111113';
        } elseif ($this->data[$index]['auth_type'] == 'factory_worker') {
            $this->data[$index]['permissions'] = '213111111';
        }
        return redirect()->route('user-permission-management', ['data' => $this->data]);
    }

    public function updatePermission($index, $page)
    {
        $this->data[$index]['permissions'][$page] = $this->selectedPermission;

        // dd($this->data[$index]['permissions'], auth()->user()->permissions);

        return redirect()->route('user-permission-management', ['data' => $this->data]);
    }

    public function getAllType()
    {
        return self::$auth_type;
    }

    public function getTypeName($type)
    {
        if (isset($this->auth_type[$type])) {
            return $this->auth_type[$type];
        } else {
            return '請選擇';
        }
    }

    public function getControllTypeName($type)
    {
        if (isset($this->controll_type[$type])) {
            return $this->controll_type[$type];
        } else {
            return '請選擇';
        }
    }

    public function render()
    {
        return view('livewire.user-permission-management_v2');
    }

    public function reset_data()
    {
        $this->data = $this->original_data;
        return redirect()->route('user-permission-management', ['data' => $this->data]);
    }

    public function delete_user($id)
    {
        User::where('id', '=', $this->data[$id]['id'])->delete();
        // $this->data->forget($id);
        return redirect()->route('user-permission-management');
    }

    public function getSmallerAuthType($type)
    {
        $smallerAuthTypes = [];
        $found = false;

        foreach ($this->auth_type as $types => $label) {

            if ($found) {
                //找到自己的位階後，把後面的位階都加入
                $smallerAuthTypes[] = $types;
            } else {
                //找到自己的位階
                $found = $types === $type;
            }

        }
        return $smallerAuthTypes;
    }

    public function getSmallerControllType($type)
    {
        $smallerControllTypes = [];
        $found = false;
        $type = $type == 0 ? 1 : $type;

        foreach ($this->controll_type as $types => $label) {
            if (!$found) {
                //找到自己的位階後，把後面的位階都加入
                $smallerControllTypes[] = $types;
                $found = $types == $type;
            } else {
                //找到自己後離開迴圈
                break;
            }
        }
        return $smallerControllTypes;
    }
}
