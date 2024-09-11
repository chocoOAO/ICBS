<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ChickenImport;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use App\Models\ChickenOut;

class ChickenOutTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testChickenOutCreate()
    {
        $contract_data = [
            "m_NAME" => "chicken_out_test",
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
        $out_data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "owner" => "愛因斯坦",
            "chicken_number" => "2",
            "time" => "23:34",
            "phone_number" => "113",
            "weight_bridge" => "海盜船X3",
            "supplier" => "微軟",
            "origin" => "百慕達三角洲",
        ];
        $chicken_out = new ChickenOut();
        $chicken_out->fill($out_data);
        $chicken_out->contract_id = $this->contract->id;
        $chicken_out->chicken_import_id = $chicken_import->id;
        $chicken_out->save();
        $this->assertTrue($out_data["date"] == $chicken_out->date);
    }

    public function testChickenOutEdit()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'chicken_out_test');
        ChickenOut::firstWhere('contract_id', '=', $contract->id)->update(['origin' => 'chicken_out_test_edit']);
        $this->assertTrue(ChickenOut::firstWhere('contract_id', '=', $contract->id)->origin == 'chicken_out_test_edit');
    }

    public function testChickenOutDelete()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'chicken_out_test');
        ChickenOut::firstWhere('contract_id', '=', $contract->id)->delete();
        $this->assertTrue(ChickenOut::firstWhere('contract_id', '=', $contract->id) == null);
        ChickenImport::firstWhere('contract_id', '=', $contract->id)->delete();
        $this->assertTrue(ChickenImport::firstWhere('contract_id', '=', $contract->id) == null);
        Contract::firstWhere('m_NAME', '=', 'chicken_out_test')->delete();
    }
}
