<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use App\Models\ChickenVerify;


class ChickenVerifyComponent extends Component
{

    public Collection $inputs;
    public Contract $contract;
    public $photo;
    public $batch_number = -1;
    public $isShow = false;
    public $data = [];

    public function fake()
    {
        $this->data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "customer_name" => "王小明",
            "quantity" => "16000",
            "gift" => "1000",
            "disuse" => "1000",
            // "death_quantity" => "1000",
            "amount" => "100000",
            "price" => "1.5",
            "package_quantity" => "6.25",
            "package" => "5.25",
            "avg_weight" => "1.5",
            "total_weight" => "1.5",
            "fee" => "0",
            "memo1" => "測試",
        ];

        // 理論上應該一直往下加 不應該POP
        if ($this->inputs->last() == []) {
            $this->inputs->pop();
        }

        //檢查最後一個是否為空陣列

        $this->inputs->push($this->data);
    }

    // public function showCanvasImg()
    // {
    //     if ($this->isShow) {
    //         $this->isShow = false;
    //         return;
    //     }
    //     $this->isShow = true;
    // }

    public function render()
    {
        return view('livewire.chicken-verify');
    }

    public function mount(Contract $contract)
    {
        $this->contract = $contract;
        $this->inputs = collect($contract->ChickenVerifies);
        if ($this->inputs->count() == 0) {
            $this->addInput();
        } else {
            $this->batch_number = $this->inputs->max('batch_number') + 1;
        }
    }

    public function submit()
    {
        if (!Gate::allows('opeartor-verify', $this->contract)) {
            Gate::authorize('opeartor-verify', $this->contract);
        }
        foreach ($this->inputs as $input) {

            $input['contract_id'] = $this->contract->id;

            if (isset($input['id'])) {
                $input['last_editor'] = auth()->user()->name;
                ChickenVerify::find($input['id'])->update($input);
            } else {

                if (!is_array($input)) continue;

                $bypass = false;
                foreach ($input as $value) {
                    if ($value == "") {
                        $bypass = true;
                        break;
                    }
                }
                if ($bypass) continue;
                $input['creator'] = auth()->user()->name;
                ChickenVerify::Create($input);
            }
        }
        //return redirect()->route('chicken-verify.create', $this->contract->id);
        return redirect()->route('chicken-import.create', $this->contract->id);
    }

    public function addInput()
    {
        // if (!Gate::allows('opeartor-verify', $this->contract)) {
        //     Gate::authorize('opeartor-verify', $this->contract);
        //     $this->inputs->pop();
        // }
        $this->inputs->push([]);
    }

    public function delete($index)
    {
        // dd($index, $this->inputs[$index]['id']);
        if (!isset($this->inputs[$index]['id'])) {
            $this->inputs->forget($index);
            return;
        }

        ChickenVerify::findOrFail($this->inputs[$index]['id'])->delete();
        $this->inputs->forget($index);
        return redirect()->route('chicken-verify.create', $this->contract->id);
    }
}
