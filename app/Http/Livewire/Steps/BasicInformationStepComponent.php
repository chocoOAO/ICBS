<?php

namespace App\Http\Livewire\Steps;

use Illuminate\Http\Request;
use App\Http\Controllers\ExternalAPIController;
use App\Models\Contract;
use App\Models\ContractDetail;
use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BasicInformationStepComponent extends StepComponent
{
    public $data = [];
    private $z_cus_kna1 = []; //  由於之前z_cus_kna1設定為區域變數(沒有$this)，推測為只在后端使用，不需要在前端访问，因此加上private變為私有属性，避免了可能會引發的錯誤。

    public $type = 0;
    public $view = false;

    // 這個用來保存第一個畫面中看起來屬於細節得資料
    // 我覺得畫面還要再重構 不然有不相關的東西要額外保存
    public $extraData = [];

    public $contract_id = "";
    public $copy = false;

    public $RemindMessage = null; # 預設值

    public function stepInfo(): array
    {
        return [
            'label' => '合約資訊',
        ];
    }

    // 產生假資料至畫面上
    public function fake()
    {
        $fake_data = [
            "m_NAME" => "福壽實業股份有限公司",
            "name_b" => "測試者2號", // 經測試後，"name_b"這是一定要有的變數(雖然底下程式碼也有做預防措施)，否則會引發錯誤: SQLSTATE[HY000]: General error: 1364 Field 'name_b' doesn't have a default value。
            "type" => 1,
            "begin_date" => "2023-05-08",
            "end_date" => "2024-05-08",
            "bank_name" => "華南商業銀行",
            "bank_branch" => "008",
            "bank_account" => "21544460252",
            "salary" => "13000",
            "office_tel" => "0227712171",
            "home_tel" => "0227712171",
            "mobile_tel" => "0912345678",
        ];
        // 已經預定義了 $this->data，現在需要批量更新這些欄位的預設值。
        foreach ($fake_data as $key => $value) {
            if (array_key_exists($key, $this->data)) { // 只更新已經存在的鍵，確保數組的結構和初始定義一致。
                $this->data[$key] = $value;
            }
        }

        $fake_extraData = [
            "order_quantity" => "100000",
            "address" => "106台北市大安區忠孝東路三段1號",
            "feed_area" => "台北市大安區忠孝東路三段",
            "feed_number" => "106",
            "area" => "34.2坪",
            "building_name1" => "10",
            "feed_amount1" => "150000",
            "building_name2" => "8",
            "feed_amount2" => "9",
            "buildings_name3" => "10",
            "feed_amount3" => "11",
            "per_batch_chick_amount" => "20000",
            "feeding_price_date" => "2023-05-08",
            "chicken_n1_feeding_price" => "13.5",
            "chicken_n2_feeding_price" => "12.1",
            "chicken_n3_feeding_price" => "11.9",
            "chicken_price" => "22",
            "each_chicken_car_price" => "3",
            "feeding_each_kg_plus_price" => "21.1",
            "breeding_rate" => "1.3",
            "feed_conversion_rate_1" => "0.6",
            "feed_conversion_rate_2" => "0.5",
            "chicken_weight_kg_1_1" => "1.75",
            "chicken_weight_kg_1_2" => "1.89",
            "chicken_weight_kg_2_1" => "1.90",
            "chicken_weight_kg_2_2" => "1.99",
            "chicken_weight_kg_3_1" => "2.0",
            "chicken_weight_kg_3_2" => "2.10",
            "chicken_weight_kg_4_1" => "2.11",
            "chicken_weight_price1" => "27.3",
            "chicken_weight_price2" => "28",
            "chicken_weight_price3" => "28.5",
            "chicken_weight_price4" => "29.2",
            "chicken_allowance_price1" => "0",
            "chicken_allowance_price2" => "0.3",
            "chicken_allowance_price3" => "0.5",
            "chicken_allowance_price4" => "1.1",
            "contract1_unamed_1" => "29",
            "dividend" => "1/9",
            "contract1_unamed_2" => "1.75",
            "contract1_unamed_2_1" => "2.1",
            "contract1_unamed_3" => "100",
            "contract1_unamed_4_1" => "1.75",
            "contract1_unamed_4_2" => "2.11",
            "debit_price_1_1" => "1.75",
            "debit_price_1_2" => "2.1",
            "debit_price_2_1_1" => "2.30",
            "debit_price_2_1_2" => "2.10",
            "debit_price_2_2" => "2.251",
            "debit_price_2_3" => "議價",
            "ok_to_die" => "1.75",
            "m_NAME" => "測試者1號",
            "name_b" => "測試者2號",
            "begin_date" => "2023-05-08",
            "end_date" => "2024-05-08",
            "feed_work_rule_2" => "12",
            "bank_name" => "華南商業銀行",
            "bank_branch" => "008",
            "bank_account" => "21544460252",
            "salary" => "13000",
            "office_tel" => "0227712171",
            "home_tel" => "0227712171",
            "mobile_tel" => "0912345678",
            "chicken_weight_kg_4_2" => "2.19",
            "chicken_weight_kg_5_1" => "2.2",
            "chicken_weight_kg_5_2" => "2.29",
            "chicken_weight_kg_6_1" => "2.3",
            "chicken_weight_kg_7_1" => "1314",
            "chicken_weight_kg_7_2" => "520",
            "chicken_allowance_price5" => "1.9",
            "chicken_allowance_price6" => "3",
            "chicken_allowance_price7" => "7456",
            "contract2_unamed_1" => "20",
            "contract2_unamed_2" => "1.1",
            "contract2_unamed_3_1" => "20",
            "contract2_unamed_3_2" => "1.5",
            "contract2_unamed_4" => "1.5",
            "contract2_unamed_5_1" => "1.75",
            "contract2_unamed_5_2" => "1.9",
            "contract2_unamed_5_3" => "1.99",
            "feed_work_rule_1_1_1" => "1000",
            "feed_work_rule_1_1_2" => "10.2",
            "feed_work_rule_1_2_1" => "1000",
            "feed_work_rule_1_2_2" => "9.2",
            "feed_work_rule_3_1" => "1.75",
            "feed_work_rule_3_2" => "2.11",
            "chick_out_rule_4" => "1.75",
            //-----------------------------------下半部的
            "live_chicken_weight_0" => "99",
            "live_chicken_weight_1" => "99",
            "feed_efficiency" => "99",
            "live_chicken_weight_reward1" => "99",
            "live_chicken_weight_2" => "99",
            "live_chicken_weight_3" => "99",
            "live_chicken_weight_reward2" => "99",
            "stinking_claw" => "99",
            "stinking_claw_type" => "reward",
            "stinking_claw_reward" => "99",
            "stinking_chest" => "99",
            "stinking_chest_type" => "reward",
            "stinking_chest_reward" => "99",
            "trading_market_table_0" => "99",
            "trading_market_table_1" => "99",
            "trading_market_table_2" => "99",
            "trading_market_table_3" => "99",
            "trading_market_table_4" => "99",
            "trading_market_table_5" => "99",
            "trading_market_table_6" => "99",
            "trading_market_table_7" => "99",
            "trading_market_table_8" => "99",
            "trading_market_table_9" => "99",
            "trading_market_table_10" => "99",
            "compensation_0" => "99",
            "compensation_1" => "99",
            "compensation_2" => "99",
            "discount_reward_0" => "99",
            "discount_reward_1" => "99",
            "discount_reward_2" => "99",
            "Feedback_0" => "99",
        ];

        for ($i = 0; $i < 6; $i++) {
            $fake_extraData["extra_description_{$i}"] = "99";
            $fake_extraData["extra_description_{$i}_type"] = "reward";
            $fake_extraData["extra_description_{$i}_reward"] = "99";
        }

        // 当 contractType 等于 3 时，执行以下操作
        if ($this->state()->forStep('choose-contract-type-step')['type'] == 3) {
            $this->data["name_b"]= DB::table('z_cus_kna1s')->first()->m_NAME; # 新增乙方名稱，這是專為 contractType == 3 所設計的假資料。

            $fake_extraData += [
            //-----------------------------------其他飼養計畫部分
            "Electric_industry_weight_1" => "99",
            "Electric_industry_weight_2" => "99",
            "contract_big_chicken_weight_1" => "99",
            "contract_big_chicken_weight_2" => "99",
            "contract_big_chicken_price_1" => "99",
            "contract_big_chicken_weight_3" => "99",
            "contract_big_chicken_weight_4" => "99",
            "contract_big_chicken_price_2" => "99",
            "contract_big_chicken_weight_5" => "99",
            "contract_big_chicken_weight_6" => "99",
            "contract_big_chicken_price_3" => "99",
            "contract_little_chicken_weight_0" => "99",
            "contract_little_chicken_price_0" => "99",
            "contract_SmellyClaw_%_0" => "99",
            "contract_SmellyClaw_%_1-1" => "99",
            "contract_SmellyClaw_%_1-2" => "99",
            "contract_SmellyClaw_deduction_1-1" => "99",
            "contract_SmellyClaw_absorb_1" => "99",
            "contract_SmellyClaw_deduction_1-2" => "99",
            "contract_SmellyClaw_%_2-1" => "99",
            "contract_SmellyClaw_%_2-2" => "99",
            "contract_SmellyClaw_deduction_2-1" => "99",
            "contract_SmellyClaw_absorb_2" => "99",
            "contract_SmellyClaw_deduction_2-2" => "99",
            "contract_SmellyClaw_%_3-1" => "99",
            "contract_SmellyClaw_%_3-2" => "99",
            "contract_SmellyClaw_deduction_3-1" => "99",
            "contract_SmellyClaw_absorb_3" => "99",
            "contract_SmellyClaw_deduction_3-2" => "99",
            "contract_SmellyClaw_%_4-1" => "99",
            "contract_SmellyClaw_%_4-2" => "99",
            "contract_SmellyClaw_deduction_4-1" => "99",
            "contract_SmellyClaw_absorb_4" => "99",
            "contract_SmellyClaw_deduction_4-2" => "99",
            "contract_SmellyClaw_%_5" => "99",
            "contract_SmellyClaw_deduction_5-1" => "99",
            "contract_SmellyClaw_absorb_5" => "99",
            "contract_SmellyClaw_deduction_5-2" => "99",
            "contract_Dermatitis_%_0" => "99",
            "contract_Dermatitis_%_1-1" => "99",
            "contract_Dermatitis_%_1-2" => "99",
            "contract_Dermatitis_deduction_1-1" => "99",
            "contract_Dermatitis_absorb_1" => "99",
            "contract_Dermatitis_deduction_1-2" => "99",
            "contract_Dermatitis_%_2-1" => "99",
            "contract_Dermatitis_%_2-2" => "99",
            "contract_Dermatitis_deduction_2-1" => "99",
            "contract_Dermatitis_absorb_2" => "99",
            "contract_Dermatitis_deduction_2-2" => "99",
            "contract_Dermatitis_%_3-1" => "99",
            "contract_Dermatitis_%_3-2" => "99",
            "contract_Dermatitis_deduction_3-1" => "99",
            "contract_Dermatitis_absorb_3" => "99",
            "contract_Dermatitis_deduction_3-2" => "99",
            "contract_Dermatitis_%_4-1" => "99",
            "contract_Dermatitis_%_4-2" => "99",
            "contract_Dermatitis_deduction_4-1" => "99",
            "contract_Dermatitis_absorb_4" => "99",
            "contract_Dermatitis_deduction_4-2" => "99",
            "contract_Dermatitis_%_5" => "99",
            "contract_Dermatitis_deduction_5-1" => "99",
            "contract_Dermatitis_absorb_5" => "99",
            "contract_Dermatitis_deduction_5-2" => "99",
            "contract_smelly_breasts_%_0" => "99",
            "contract_smelly_breasts_%_1-1" => "99",
            "contract_smelly_breasts_%_1-2" => "99",
            "contract_smelly_breasts_deduction_1" => "99",
            "contract_smelly_breasts_%_2-1" => "99",
            "contract_smelly_breasts_%_2-2" => "99",
            "contract_smelly_breasts_deduction_2" => "99",
            "contract_smelly_breasts_%_3-1" => "99",
            "contract_smelly_breasts_%_3-2" => "99",
            "contract_smelly_breasts_deduction_3" => "99",
            "contract_smelly_breasts_%_4-1" => "99",
            "contract_smelly_breasts_%_4-2" => "99",
            "contract_smelly_breasts_deduction_4" => "99",
            "contract_smelly_breasts_%_5" => "99",
            "contract_smelly_breasts_deduction_5" => "99",
            "contract_Tolerance-Of-DeadChicken_SummerMonth_Beginning" => "99",
            "contract_Tolerance-Of-DeadChicken_SummerMonth_End" => "99",
            "contract_Tolerance-Of-DeadChicken_Summer" => "99",
            "contract_Tolerance-Of-DeadChicken_Winter_Beginning" => "99",
            "contract_Tolerance-Of-DeadChicken_Winter_End" => "99",
            "contract_Tolerance-Of-DeadChicken_Winter" => "99",
            ];
        }

        // 已經預定義了 $this->extraData，現在需要批量更新這些欄位的預設值。
        foreach ($fake_extraData as $key => $value) {
            if (array_key_exists($key, $this->extraData)) { // 只更新已經存在的鍵，確保數組的結構和初始定義一致。
                $this->extraData[$key] = $value;
            }
        }
    }

    public function mount(Request $request) // initialState 建立合約初始化
    {
        // 先建好列表清單，後續修改時才會有資料。
        // 為避免$this->data的value為null時，會引發SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'value' cannot be null錯誤，因此設為空值""。
        $this->data = [
            "m_NAME" => "", // 屬性：required
            "name_b" => "", // 屬性：required
            "m_KUNAG" => "", // 屬性：required
            "type" => "", // 屬性：required
            "begin_date" => "", // 屬性：required
            "end_date" => "", // 屬性：required
            "bank_name" => "", // 屬性：required
            "bank_branch" => "", // 屬性：required
            "bank_account" => "", // 屬性：required
            "salary" => "", // 屬性：required
            "office_tel" => "",
            "home_tel" => "",
            "mobile_tel" => "",
        ];
        
        // 先建好列表清單，後續修改時才會有資料。
        $this->extraData = [
            "order_quantity" => null, // 屬性：required
            "address" => null, // 屬性：required
            "feed_area" => "",
            "feed_number" => "",
            "area" => null, // 屬性：required
            "building_name1" => null, // 屬性：required
            "feed_amount1" => null, // 屬性：required
            "per_batch_chick_amount" => null, // 屬性：required
            // ---------------------------
            "trading_market_table_0" => "",
            "trading_market_table_1" => "",
            "trading_market_table_2" => "",
            "trading_market_table_3" => "",
            "trading_market_table_4" => "",
            "trading_market_table_5" => "",
            // ---------------------------
            "compensation_0" => "",
            "compensation_1" => "",
            "compensation_2" => "",
            // ---------------------------
            "discount_reward_0" => "",
            "discount_reward_1" => "",
            // ---------------------------
            "ok_to_die" => null,  // 屬性：required
            "breeding_rate" => null, // 屬性：required
            "feed_conversion_rate_1" => null, // 屬性：required
            "feed_conversion_rate_2" => null, // 屬性：required
            // ---------------------------
            // "feeding_each_kg_plus_price" => "", // $contractType == 1 <!-- 停用的合約 -->

        ];

        // ↓ $contractType == 2 代養計價 ↓
        if ($this->state()->forStep('choose-contract-type-step')['type'] == 2){
            $this->extraData += [
                "trading_market_table_6" => "",
                // ---------------------------
                "chicken_weight_kg_1_1" => "",
                "chicken_weight_kg_2_1" => "",
                "chicken_weight_kg_2_2" => "",
                "chicken_weight_kg_3_1" => "",
                "chicken_weight_kg_3_2" => "",
                "chicken_weight_kg_4_1" => "",
                "chicken_weight_kg_4_2" => "",
                "chicken_weight_kg_5_1" => "",
                "chicken_weight_kg_5_2" => "",
                "chicken_weight_kg_6_1" => "",
                "chicken_weight_kg_7_1" => "",
                "chicken_weight_kg_7_2" => "",
                // ---------------------------
                "chicken_allowance_price1" => "",
                "chicken_allowance_price2" => "",
                "chicken_allowance_price3" => "",
                "chicken_allowance_price4" => "",
                "chicken_allowance_price5" => "",
                "chicken_allowance_price6" => "",
                "chicken_allowance_price7" => "",
                // ---------------------------
                "contract2_unamed_1" => "",
                "contract2_unamed_2" => "",
                "contract2_unamed_3_1" => "",
                "contract2_unamed_3_2" => "",
                "contract2_unamed_4" => "",
                "contract2_unamed_5_1" => "",
                "contract2_unamed_5_2" => "",
                "contract2_unamed_5_3" => "",
                // ---------------------------
                "live_chicken_weight_0" => "",
                "live_chicken_weight_1" => "",
                // ---------------------------
                "feed_efficiency" => "",
                // ---------------------------
                "live_chicken_weight_reward1" => "",
                "live_chicken_weight_2" => "",
                "live_chicken_weight_3" => "",                    
                "live_chicken_weight_reward2" => "",
                // ---------------------------
                "stinking_claw" => "",
                "stinking_claw_type" => "",
                "stinking_claw_reward" => "",
                "stinking_chest" => "",
                "stinking_chest_type" => "",
                "stinking_chest_reward" => "",
            ];

            for ($i = 0; $i < 6; $i++) {
                $this->extraData["extra_description_{$i}"] = "";
                $this->extraData["extra_description_{$i}_type"] = "non-choose";
                $this->extraData["extra_description_{$i}_reward"] = "";
            }
        
        // ↓ $contractType == 3 其他事項(契養) ↓
        } elseif ($this->state()->forStep('choose-contract-type-step')['type'] == 3){
            $this->extraData += [
                "feeding_price_date" => null, // 屬性：required
                "chicken_n1_feeding_price" => "",
                "chicken_n2_feeding_price" => "",
                "chicken_n3_feeding_price" => "",
                "chicken_price" => "",
                "each_chicken_car_price" => null, // 屬性：required
                "trading_market_table_7" => "",
                "trading_market_table_8" => "",
                "trading_market_table_9" => "",
                "trading_market_table_10" => "",
                "discount_reward_2" => "",
                "Feedback_0" => "",
                "Electric_industry_weight_1" => "",
                "Electric_industry_weight_2" => "",
                "contract_big_chicken_weight_1" => "",
                "contract_big_chicken_weight_2" => "",
                "contract_big_chicken_weight_3" => "",
                "contract_big_chicken_weight_4" => "",
                "contract_big_chicken_weight_5" => "",
                "contract_big_chicken_weight_6" => "",
                "contract_big_chicken_price_1" => "",
                "contract_big_chicken_price_2" => "",
                "contract_big_chicken_price_3" => "",
                "contract_little_chicken_weight_0" => "",
                "contract_little_chicken_price_0" => "",
                "contract_SmellyClaw_%_0" => "",
                "contract_SmellyClaw_%_1-1" => "",
                "contract_SmellyClaw_%_1-2" => "",
                "contract_SmellyClaw_%_2-1" => "",
                "contract_SmellyClaw_%_2-2" => "",
                "contract_SmellyClaw_%_3-1" => "",
                "contract_SmellyClaw_%_3-2" => "",
                "contract_SmellyClaw_%_4-1" => "",
                "contract_SmellyClaw_%_4-2" => "",
                "contract_SmellyClaw_%_5" => "",
                "contract_SmellyClaw_deduction_1-1" => "",
                "contract_SmellyClaw_deduction_1-2" => "",
                "contract_SmellyClaw_deduction_2-1" => "",
                "contract_SmellyClaw_deduction_2-2" => "",
                "contract_SmellyClaw_deduction_3-1" => "",
                "contract_SmellyClaw_deduction_3-2" => "",
                "contract_SmellyClaw_deduction_4-1" => "",
                "contract_SmellyClaw_deduction_4-2" => "",
                "contract_SmellyClaw_deduction_5-1" => "",
                "contract_SmellyClaw_deduction_5-2" => "",
                "contract_SmellyClaw_absorb_1" => "",
                "contract_SmellyClaw_absorb_2" => "",
                "contract_SmellyClaw_absorb_3" => "",
                "contract_SmellyClaw_absorb_4" => "",
                "contract_SmellyClaw_absorb_5" => "",
                "contract_Dermatitis_%_0" => "",
                "contract_Dermatitis_%_1-1" => "",
                "contract_Dermatitis_%_1-2" => "",
                "contract_Dermatitis_%_2-1" => "",
                "contract_Dermatitis_%_2-2" => "",
                "contract_Dermatitis_%_3-1" => "",
                "contract_Dermatitis_%_3-2" => "",
                "contract_Dermatitis_%_4-1" => "",
                "contract_Dermatitis_%_4-2" => "",
                "contract_Dermatitis_%_5" => "",
                "contract_Dermatitis_deduction_1-1" => "",
                "contract_Dermatitis_deduction_1-2" => "",
                "contract_Dermatitis_deduction_2-1" => "",
                "contract_Dermatitis_deduction_2-2" => "",
                "contract_Dermatitis_deduction_3-1" => "",
                "contract_Dermatitis_deduction_3-2" => "",
                "contract_Dermatitis_deduction_4-1" => "",
                "contract_Dermatitis_deduction_4-2" => "",
                "contract_Dermatitis_deduction_5-1" => "",
                "contract_Dermatitis_deduction_5-2" => "",
                "contract_Dermatitis_absorb_1" => "",
                "contract_Dermatitis_absorb_2" => "",
                "contract_Dermatitis_absorb_3" => "",
                "contract_Dermatitis_absorb_4" => "",
                "contract_Dermatitis_absorb_5" => "",
                "contract_smelly_breasts_%_0" => "",
                "contract_smelly_breasts_%_1-1" => "",
                "contract_smelly_breasts_%_1-2" => "",
                "contract_smelly_breasts_%_2-1" => "",
                "contract_smelly_breasts_%_2-2" => "",
                "contract_smelly_breasts_%_3-1" => "",
                "contract_smelly_breasts_%_3-2" => "",
                "contract_smelly_breasts_%_4-1" => "",
                "contract_smelly_breasts_%_4-2" => "",
                "contract_smelly_breasts_%_5" => "",
                "contract_smelly_breasts_deduction_1" => "",
                "contract_smelly_breasts_deduction_2" => "",
                "contract_smelly_breasts_deduction_3" => "",
                "contract_smelly_breasts_deduction_4" => "",
                "contract_smelly_breasts_deduction_5" => "",
                "contract_Tolerance-Of-DeadChicken_SummerMonth_Beginning" => "",
                "contract_Tolerance-Of-DeadChicken_SummerMonth_End" => "",
                "contract_Tolerance-Of-DeadChicken_Summer" => "",
                "contract_Tolerance-Of-DeadChicken_Winter_Beginning" => "",
                "contract_Tolerance-Of-DeadChicken_Winter_End" => "",
                "contract_Tolerance-Of-DeadChicken_Winter" => "",
                "feed_work_rule_1_1_1" => "",
                "feed_work_rule_1_1_2" => "",
                "feed_work_rule_1_2_1" => "",
                "feed_work_rule_1_2_2" => "",
                "feed_work_rule_3_1" => "",
                "feed_work_rule_3_2" => "",
                "chick_out_rule_4" => "",
            ];
        }        
    }

    public function Call_getUserPassword()
    {
        $basicInformation = $this->state()->forStep('basic-information-step')['data'];
        $externalApiController = new ExternalAPIController();
        if ( !isset($basicInformation['m_KUNAG']) or empty($basicInformation['m_KUNAG']) ) { dd('沒有選擇乙方對象。請按一下畫面繼續編輯。'); }
        $userPassword = $externalApiController->getUserPassword($basicInformation['m_KUNAG']);
    }

    public function render()
    {
        $contractType = $this->state()->forStep('choose-contract-type-step')['type'];
        return view('contract.main')->with('contractType', $contractType)
            ->with('isView', false);
    }

    /**
     * 負責表單送出後保存置資料庫
     */
    public function submit()
    {
        if ($this->data['end_date'] < $this->data['begin_date']){
            throw new \Exception(sprintf("合約的有效期限要求「結束日期」必須在「開始日期」之後。您目前輸入的結束日期為%s、開始日期則為%s，這是不符合要求的。請重新設定以保證結束日期晚於開始日期。", $this->data['end_date'], $this->data['begin_date']));
        }

        $isView = $this->state()->forStep('basic-information-step')['view'] == true;
        $copy = $this->state()->forStep('basic-information-step')['copy'] == true;

        if (!$isView) {
            $this->handleCreateContract();
        } else if ($copy) {
            $this->handleCreateContract();
        } else {
            $this->handleEditContract();
        }

        return redirect('contracts');
    }

    public function handleCreateContract()
    {
        $basicInformation = $this->state()->forStep('basic-information-step')['data'];
        // 新增合約時，creator為建立者
        $basicInformation['creator'] = auth()->user()->name;

        // 判斷合約類型
        $contractTypeFromChoose = 0;
        if (isset($this->state()->forStep('choose-contract-type-step')['type'])) {
            $contractTypeFromChoose = $this->state()->forStep('choose-contract-type-step')['type'];
        }
        $contractType = $contractTypeFromChoose;

        if ($contractType == 3){
            // 若 $contractType == 3 也就是 其他事項(契養) 時，會讓使用者輸入乙方資料，為了避免從z_cus_kna1資料庫中找資料或寫入contracts資料庫時發生錯誤，特別區分開來，移動到Verify_m_KUNAG這個function中去做判斷及檢測。
            $this->z_cus_kna1 = $this->Verify_m_KUNAG();
            if (isset($this->z_cus_kna1['m_KUNAG'])){
                $basicInformation['m_KUNAG'] =  $this->z_cus_kna1['m_KUNAG']; // 若判斷是為正，則代表能從z_cus_kna1s找到資料，將m_KUNAG換成代號寫入contracts資料庫。
            } else{
                $basicInformation['m_KUNAG'] = $this->data['name_b']; // 否則代表無法從z_cus_kna1s找到資料，將m_KUNAG換成乙方名稱寫入contracts資料庫。
            }
        } else{
            // $contractType == 1保價計價(停用) 或 $contractType == 2代養計價時
            if ( !isset($basicInformation['m_KUNAG']) or empty($basicInformation['m_KUNAG']) ) { dd('沒有選擇乙方對象。請按一下畫面繼續編輯。'); }
            $this->z_cus_kna1 = DB::table('z_cus_kna1s')->where('m_KUNAG', '=', $basicInformation['m_KUNAG'])->get()->toArray(); 
            $this->z_cus_kna1 = $this->z_cus_kna1[0]; //很特別
            $basicInformation['name_b'] = $this->z_cus_kna1->m_NAME; // "name_b"是一定要有的變數。
        }

        $basicInformationExtraData = $this->state()->forStep('basic-information-step')['extraData'];
        $Verification = $this->VerifyData_numeric($basicInformationExtraData);
        if ($Verification != '所有數據都有效。'){dd($Verification);}

        // 建立合約本體
        $contractDetails = $this->data;
        $basicInformation['type'] = $contractType;
        
        try{
            $contract = Contract::Create($basicInformation); // 建立合約本體
        } catch (QueryException $e) {
            // 检查 SQLSTATE 错误代码
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1406) {                
                throw new \Exception('乙方名稱過長，請簡化輸入！'); // 发生数据过长的错误
            }
            dd('error', '数据库错误！', $e->getMessage()); // 处理其他类型的数据库错误
        }

        // 處理基本畫面中看起來像是詳細資訊的資料
        foreach ($basicInformationExtraData as $detailKey => $value) {
            ContractDetail::createContractDetailByKey($contract, $detailKey, $value);
        }

        // 處理之後畫面中的詳細資訊
        foreach ($contractDetails as $detailKey => $value) {
            ContractDetail::createContractDetailByKey($contract, $detailKey, $value);
        }
    }

    public function handleEditContract()
    {
        $basicInformation = $this->state()->forStep('basic-information-step')['data'];

        $basicInformationExtraData = $this->state()->forStep('basic-information-step')['extraData'];

        $contractTypeFromBasicInformation = 0;
        if (isset($this->state()->forStep('basic-information-step')['type'])) {
            $contractTypeFromBasicInformation = $this->state()->forStep('basic-information-step')['type'];
        }

        $contractTypeFromChoose = 0;
        if (isset($this->state()->forStep('choose-contract-type-step')['type'])) {
            $contractTypeFromChoose = $this->state()->forStep('choose-contract-type-step')['type'];
        }

        $contractType = $contractTypeFromBasicInformation;
        if ($contractTypeFromBasicInformation == 0) {
            $contractType = $contractTypeFromChoose;
        }
        $contractDetails = $this->data;

        // 建立合約本體
        $basicInformation['type'] = $contractType;
        $contract = Contract::where('id', '=', $this->state()->forStep('basic-information-step')['contract_id']);
        array_splice($basicInformation, count($basicInformation) - 2, 2);
        $contract->update($basicInformation);

        // 處理基本畫面中看起來像是詳細資訊的資料
        foreach ($basicInformationExtraData as $detailKey => $value) {
            ContractDetail::editContractDetailByKey($contract->first(), $detailKey, $value);
        }

        // 處理之後畫面中的詳細資訊
        foreach ($contractDetails as $detailKey => $value) {
            ContractDetail::editContractDetailByKey($contract->first(), $detailKey, $value);
        }
    }

    public function VerifyData_numeric($basicInformationExtraData) //這段主要是檢查extraData資料是否符合數字格式
    {
        foreach ($basicInformationExtraData as $key => $value) {
        // 检查$key是否包含'chicken_weight'這個字眼 且 $value是否为数字
            if (strpos($key, 'chicken_weight_kg') !== false && !is_numeric($value) && trim($value) !== '') {
                return '飼養報酬對照表的毛雞規格(KG)欄位' . $key . '發生錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'chicken_allowance_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '飼養報酬對照表的飼養報酬(元/羽)欄位' . $key . '發生錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'trading_market_table') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第四點毛雞每斤計價方式' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'discount_reward') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第七點雛雞折扣回饋' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'Feedback') !== false && !is_numeric($value) && trim($value) !== ''){
                return '雙方約定事項的第八點' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_big_chicken_weight') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超大雞部份的公斤數(kg)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_big_chicken_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超大雞部份的價格(元/台斤)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_little_chicken_weight') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超小雞部份的公斤數(kg)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_little_chicken_price') !== false && !is_numeric($value) && trim($value) !== ''){
                return '超小雞部份的價格(元/台斤)' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_SmellyClaw') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]3.1臭爪部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_Dermatitis') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]3.2皮膚炎部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
            elseif (strpos($key, 'contract_smelly_breasts') !== false && !is_numeric($value) && trim($value) !== ''){
                return '[表格]臭胸部份' . $key . '輸入錯誤: ' . $value . ' 不是有效的數字。';
            }
        }
        return '所有數據都有效。'; // 如果所有的值都是数字
    }

    public function Verify_m_KUNAG() // 專為 contractType == 3 設計，用來檢查使用者輸入的乙方名稱是否存在於z_cus_kna1s資料庫中。
    {
        if (isset($this->data['name_b']) && !empty($this->data['name_b'])) {
            $this->z_cus_kna1 = [ "m_KUNAG" => null, "m_NAME" => $this->data['name_b'], "m_ADDSC" => null, "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s'), ];
            
            // 假設使用者是在乙方輸入名稱，而不是代號，則應該倚靠名字(m_NAME或name_b)來找資料；若能找到資料，則將m_KUNAG換成代號，否則就維持名稱。
            if (!DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->exists()) { // 根據從z_cus_kna1s查找的結果來對應處理。
                $this->RemindMessage = '未能從資料庫中找到对应的乙方对象，請留意對象是否輸入正確。'; // 设置错误消息提醒使用者
            } else{ // 能從z_cus_kna1s資料庫中找到資料。
                $this->z_cus_kna1['m_KUNAG'] = DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->first('m_KUNAG')->m_KUNAG; //能從z_cus_kna1s找到資料
                $this->z_cus_kna1['m_ADDSC'] = DB::table('z_cus_kna1s')->where('m_NAME', $this->data['name_b'])->first('m_ADDSC')->m_ADDSC; 
                $this->data['m_KUNAG'] = $this->z_cus_kna1['m_KUNAG'];  // 若判斷是為正，則代表能從z_cus_kna1s找到資料，將m_KUNAG換成代號。
                $this->RemindMessage = null; // 將$this->RemindMessage改為預設值null。
            }
        } else {
            $this->RemindMessage = '未輸入乙方对象。'; // 设置错误消息提醒使用者
        }
        return $this->z_cus_kna1; // 回傳給handleCreateContract去做使用，新增資料。
    }
    
}

