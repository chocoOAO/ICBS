<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContractTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testContractCreate()
    {
        $data = [
            "m_NAME" => "contract_test",
            "name_b" => "dadadsada",
            "type" => "1",
            "begin_date" => "2023-1-04",
            "end_date" => "2023-1-24",
            "bank_name" => "華南商業銀行",
            "bank_branch" => "21",
            "bank_account" => "321",
            "salary" => "321",
            "office_tel" => "321",
            "home_tel" => "312",
            "mobile_tel" => "23",
        ];
        $contract = new Contract();
        $contract->fill($data);
        $contract->save();
        $this->assertTrue($data["m_NAME"] == $contract->m_NAME);
        $this->assertTrue($data["name_b"] == $contract->name_b);
        $this->assertTrue($data["type"] == $contract->type);
        $this->assertTrue($data["begin_date"] == $contract->begin_date);
        $this->assertTrue($data["end_date"] == $contract->end_date);
        $this->assertTrue($data["bank_name"] == $contract->bank_name);
        $this->assertTrue($data["bank_branch"] == $contract->bank_branch);
        $this->assertTrue($data["bank_account"] == $contract->bank_account);
        $this->assertTrue($data["salary"] == $contract->salary);
        $this->assertTrue($data["office_tel"] == $contract->office_tel);
        $this->assertTrue($data["home_tel"] == $contract->home_tel);
        $this->assertTrue($data["mobile_tel"] == $contract->mobile_tel);
    }

    public function testContractEdit()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'contract_test');
        $contract->m_NAME = "contract_test_edit";
        $contract->type = "2";
        $contract->save();
        $this->assertTrue($contract->m_NAME == "contract_test_edit");
        $this->assertTrue($contract->type == "2");
    }

    public function testContractCopy()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'contract_test_edit');
        $contract_amount = Contract::all()->count();
        $new_contract = $contract->replicate();
        $new_contract->m_NAME = "contract_test_copy";
        $new_contract->save();
        $this->assertTrue($contract_amount + 1 == Contract::all()->count());
        $new_contract->delete();
    }

    public function testContractDelete()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'contract_test_edit');
        $contract_amount = Contract::all()->count();
        Contract::where('id', '=', $contract->id)->delete();
        $this->assertTrue($contract_amount - 1 == Contract::all()->count());
    }
}
