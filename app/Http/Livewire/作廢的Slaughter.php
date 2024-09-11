<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Slaughter extends Component
{
    public $data;
    public $breeding_data;
    public $unit_test;
    public $select_day = 0;
    public $select_weight = 0;
    public $select_import_day = 0;
    public $select_future_weight = 0;
    public $max_day = 365;
    public $survivor = 0;
    public $importQuantity = 0;

    protected $listeners = ['selectDay' => 'selectDay'];

    public function render()
    {
        return view('livewire.slaughter');
    }

    public function mount(Request $request)
    {
        // dd($request->select_day);
        if ($request->select_day != -1 && $request->select_day != null) {
            $this->select_day = $request->select_day;
        }

        if ($request->select_weight != null) {
            $this->select_weight = $request->select_weight;
        }

        if ($request->select_import_day != null) {
            $this->select_import_day = $request->select_import_day;
        }

        if ($request->select_future_weight != null) {
            $this->select_future_weight = $request->select_future_weight;
        }

        $this->breeding_data = DB::table('breeding_logs')
            ->join('chicken_imports', 'breeding_logs.chicken_import_id', '=', 'chicken_imports.id')
            ->join('contracts', 'chicken_imports.contract_id', '=', 'contracts.id')
            ->select(DB::Raw("CONCAT(contracts.m_NAME, '-', chicken_imports.id , '入屠Time') as title"), 'breeding_logs.chicken_import_id', 'breeding_logs.disuse')
            ->orderBy('breeding_logs.date', 'asc')
            ->get();

        //dd($this->breeding_data);

        $this->data = DB::table('contracts')
            ->join('chicken_imports', 'contracts.id', '=', 'chicken_imports.contract_id')
            ->select(DB::Raw("CONCAT(contracts.m_NAME, '-', chicken_imports.id) as title"), 'chicken_imports.id', 'chicken_imports.date as slaughter', 'total_weight', 'avg_weight', 'chicken_imports.date', 'chicken_imports.amount')
            ->orderBy('chicken_imports.date', 'asc')
            ->get();

        // dd($this->data);

        foreach ($this->data as $key => $value) {
            $this->data[$key]->slaughter = date('Y-m-d', strtotime("+25 day", strtotime($this->data[$key]->slaughter)));
            $this->importQuantity += 1;
        }

        $this->max_day = $this->data->max('slaughter');
        // dd($this->data);
    }

    public function selectDay()
    {
        //dd($this->data[0]['slaughter']);
        return redirect()->route('slaughter', ['select_day' => $this->select_day, 'select_weight' => $this->select_weight, 'select_import_day' => $this->select_import_day, 'select_future_weight' => $this->select_future_weight]);
    }

    public function selectWeight()
    {
        return redirect()->route('slaughter', ['select_day' => $this->select_day, 'select_weight' => $this->select_weight, 'select_import_day' => $this->select_import_day, 'select_future_weight' => $this->select_future_weight]);
    }

    public function selectImportDay()
    {
        return redirect()->route('slaughter', ['select_day' => $this->select_day, 'select_import_day' => $this->select_import_day, 'select_future_weight' => $this->select_future_weight]);
    }

    public function selectFutureWeight()
    {
        return redirect()->route('slaughter', ['select_day' => $this->select_day, 'select_weight' => $this->select_weight, 'select_import_day' => $this->select_import_day, 'select_future_weight' => $this->select_future_weight]);
    }

    public function count()
    {
        $this->unit_test = DB::table('contracts')
            ->join('chicken_imports', 'contracts.id', '=', 'chicken_imports.contract_id')
            ->select(DB::Raw("CONCAT(contracts.m_NAME, '-', chicken_imports.id) as title"), 'chicken_imports.id', 'chicken_imports.date as slaughter', 'total_weight', 'avg_weight', 'chicken_imports.date', 'chicken_imports.amount')
            ->orderBy('chicken_imports.date', 'asc')
            ->get();

        $unit_test_count = 0;

        foreach ($this->unit_test as $key => $value) {
            $unit_test_count += 1;
        }

        return $unit_test_count;
    }
}
