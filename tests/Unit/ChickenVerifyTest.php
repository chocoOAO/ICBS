<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ChickenImport;
use App\Models\ChickenVerify;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;

class ChickenVerifyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testChickenVerifyCreate()
    {
        $contract_data = [
            "m_NAME" => "chicken_verify_test",
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
        $this->contract = new Contract();
        $this->contract->fill($contract_data);
        $this->contract->save();
        $import_data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "quantity" => "16000",
            "gift_quantity" => "1000",
            "amount" => "100000",
            "price" => "1.5",
            "package_quantity" => "6",
            "package" => "5",
            "avg_weight" => "1.5",
            "total_weight" => "1.5",
            "address" => "台中市",
        ];
        $chicken_import = new ChickenImport();
        $chicken_import->fill($import_data);
        $chicken_import->contract_id = $this->contract->id;
        $chicken_import->save();
        $verify_data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "quantity" => "16000",
            "gift" => "1000",
            "disuse" => "0",
            "death_quantity" => "1000",
            "amount" => "100000",
            "price" => "1.5",
            "package_quantity" => "6.25",
            "package" => "5.25",
            "avg_weight" => "1.5",
            "total_weight" => "1.5",
            "fee" => "0",
        ];
        $chicken_verify = new ChickenVerify();
        $chicken_verify->fill($verify_data);
        $chicken_verify->contract_id = $this->contract->id;
        $chicken_verify->save();
        $this->assertTrue($verify_data["date"] == $chicken_verify->date);
    }

    public function testChickenVerifyEdit()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'chicken_verify_test');
        ChickenVerify::firstWhere('contract_id', '=', $contract->id)->update(['fee' => '100']);
        $this->assertTrue(ChickenVerify::firstWhere('contract_id', '=', $contract->id)->fee == '100');
    }

    public function testChickenVerifyDelete()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'chicken_verify_test');
        ChickenVerify::Where('contract_id', '=', $contract->id)->delete();
        $this->assertTrue(ChickenVerify::firstWhere('contract_id', '=', $contract->id) == null);
        ChickenImport::Where('contract_id', '=', $contract->id)->delete();
        Contract::where('id', '=', $contract->id)->delete();
    }
}
