<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ChickenImport;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use App\Http\Livewire\Slaughter;

class SlaughterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSlaughter()
    {
        $contract_data = [
            "m_NAME" => "slaughter_test",
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
        $slaughter = new Slaughter();
        $this->assertTrue(ChickenImport::all()->count() == $slaughter->count());
        $chicken_import->delete();
        $this->contract->delete();
    }
}
