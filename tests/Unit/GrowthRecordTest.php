<?php

namespace Tests\Unit;

use App\Models\ChickenImport;
use App\Models\Contract;
use Tests\TestCase;
use App\Models\FeedingLog;
use App\Models\BreedingLog;

class GrowthRecordTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGrowthRecordCreate()
    {
        $contract_data = [
            "m_NAME" => "growth_record_test",
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
        $this->assertTrue($import_data["date"] == $chicken_import->date);
        $feeding_data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "feed_num" => "1",
            "feed_quantity" => "20",
            "feed_pharm" => "牛油"
        ];
        $breeding_data = [
            "date" => (new \DateTime())->format('Y-m-d'),
            "age" => "1",
            "disuse" => "10000",
            "vaccine" => "H1N1",
            "pharmaceutical" => "類固醇",
            "antibiotic" => "肥皂"
        ];
        $feeding_log = new FeedingLog();
        $feeding_log->fill($feeding_data);
        $feeding_log->contract_id = $this->contract->id;
        $feeding_log->chicken_import_id = $chicken_import->id;
        $feeding_log->save();
        $breeding_log = new BreedingLog();
        $breeding_log->fill($breeding_data);
        $breeding_log->contract_id = $this->contract->id;
        $breeding_log->chicken_import_id = $chicken_import->id;
        $breeding_log->save();
        $this->assertTrue($feeding_data["date"] == $feeding_log->date);
        $this->assertTrue($breeding_data["date"] == $breeding_log->date);
    }

    public function testGrowthRecordEdit()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'growth_record_test');
        $chicken_import = ChickenImport::firstWhere('contract_id', '=', $contract->id);
        $feeding_log = FeedingLog::firstWhere('chicken_import_id', '=', $chicken_import->id);
        $breeding_log = BreedingLog::firstWhere('chicken_import_id', '=', $chicken_import->id);
        $feeding_log->update(['feed_pharm' => 'growth_record_test_edit']);
        $breeding_log->update(['pharmaceutical' => 'growth_record_test_edit']);
        $this->assertTrue($feeding_log->feed_pharm == 'growth_record_test_edit');
        $this->assertTrue($breeding_log->pharmaceutical == 'growth_record_test_edit');
    }

    public function testGrowthRecordDelete()
    {
        $contract = Contract::firstWhere('m_NAME', '=', 'growth_record_test');
        $chicken_import = ChickenImport::firstWhere('contract_id', '=', $contract->id);
        $feeding_log = FeedingLog::firstWhere('chicken_import_id', '=', $chicken_import->id);
        $breeding_log = BreedingLog::firstWhere('chicken_import_id', '=', $chicken_import->id);
        FeedingLog::where('id', '=', $feeding_log->id)->delete();
        BreedingLog::where('id', '=', $breeding_log->id)->delete();
        ChickenImport::where('id', '=', $chicken_import->id)->delete();
        Contract::where('id', '=', $contract->id)->delete();
        $this->assertTrue(FeedingLog::where('id', '=', $feeding_log->id)->count() == 0);
        $this->assertTrue(BreedingLog::where('id', '=', $breeding_log->id)->count() == 0);
    }
}
