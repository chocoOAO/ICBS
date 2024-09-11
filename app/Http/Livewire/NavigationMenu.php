<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use Illuminate\Http\Request;
use Livewire\Component;

class NavigationMenu extends Component
{
    public $contracts;
    public $contract_id = -1;

    // for hover nav (預測列表)
    public $isDropdownVisible = false;

    public function render()
    {
        return view('livewire.navigation-menu');
    }

    public function mount(Request $request)
    {
        $DeadLineDate = date('Y-m-d', strtotime('-60 days')); // 今天日期往前計算 60 天的日期，作為顯示合約的截止日期。
        $this->contracts = Contract::where('end_date', '>=', $DeadLineDate)->get();
        if (auth()->user()->m_KUNAG != null){
            $this->contracts = $this->contracts->where('m_KUNAG', '=', auth()->user()->m_KUNAG);
        }
        if ($request->session()->has('selectContract')) {
            $this->contract_id = $request->session()->get('selectContract');
        } else {
            //合約數量大於0，則預設選擇第一筆合約
            if ($this->contracts->count() > 0) {
                // dd($this->contracts->count());
                $this->contract_id = $this->contracts->first()->id;
            }
        }
    }

    public function selectContract()
    {
        session(['selectContract' => $this->contract_id]);
    }


    // for hover nav (預測列表)
    public function showDropdown()
    {
        $this->isDropdownVisible = true;
    }

    public function hideDropdown()
    {
        $this->isDropdownVisible = false;
    }


}


