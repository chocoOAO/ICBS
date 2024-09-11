<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'account' => 'aaaa',
            'name' => 'aaaa',
            'password' => Hash::make('aaaa'),
            'password_unencrypted' => 'aaaa',
            'auth_type' => 'super_admin',
            'permissions' => '444444444'
        ]);

        \App\Models\User::factory()->create([
            'account' => 'cccc',
            'name' => 'cccc',
            'password' => Hash::make('cccc'),
            'password_unencrypted' => 'cccc',
            'auth_type' => 'admin',
            'permissions' => '444444444'
        ]);
        \App\Models\User::factory()->create([
            'account' => 'collaborator',
            'name' => 'collaborator',
            'password' => Hash::make('collaborator'),
            'password_unencrypted' => 'collaborator',
            'auth_type' => 'collaborator',
            'permissions' => '223111113'
        ]);

        \App\Models\User::factory()->create([
            'account' => 'worker',
            'name' => 'worker',
            'password' => Hash::make('worker'),
            'password_unencrypted' => 'worker',
            'auth_type' => 'worker',
            'permissions' => '224222224'
        ]);

        \App\Models\User::factory()->create([
            'account' => 'eeee',
            'name' => 'eeee',
            'password' => Hash::make('eeee'),
            'password_unencrypted' => 'eeee',
            'auth_type' => 'collaborator',
            'permissions' => '223111113'
        ]);

        $names = [
            "order_quantity",
            "address",
            "feed_area",
            "feed_number",
            "area",
            "building_name1",
            "feed_amount1",
            "building_name2",
            "feed_amount2",
            "buildings_name3",
            "feed_amount3",
            "per_batch_chick_amount",
            "feeding_price_date",
            "chicken_n1_feeding_price",
            "chicken_n2_feeding_price",
            "chicken_n3_feeding_price",
            "chicken_price",
            "each_chicken_car_price",
            "feeding_each_kg_plus_price",
            "breeding_rate",
            "feed_conversion_rate_1",
            "feed_conversion_rate_2",
            "chicken_weight_kg_1_1",
            "chicken_weight_kg_1_2",
            "chicken_weight_kg_2_1",
            "chicken_weight_kg_2_2",
            "chicken_weight_kg_3_1",
            "chicken_weight_kg_3_2",
            "chicken_weight_kg_4_1",
            "chicken_weight_price1",
            "chicken_weight_price2",
            "chicken_weight_price3",
            "chicken_weight_price4",
            "chicken_allowance_price1",
            "chicken_allowance_price2",
            "chicken_allowance_price3",
            "chicken_allowance_price4",
            "contract1_unamed_1",
            "dividend",
            "contract1_unamed_2",
            "contract1_unamed_2_1",
            "contract1_unamed_3",
            "contract1_unamed_4_1",
            "contract1_unamed_4_2",
            "debit_price_1_1",
            "debit_price_1_2",
            "debit_price_2_1_1",
            "debit_price_2_1_2",
            "debit_price_2_2",
            "debit_price_2_3",
            "ok_to_die",
            "m_NAME",
            "name_b",
            "begin_date",
            "end_date",
            "feed_work_rule_2",
            "bank_name",
            "bank_branch",
            "bank_account",
            "salary",
            "office_tel",
            "home_tel",
            "mobile_tel",
            "chicken_weight_kg_4_2",
            "chicken_weight_kg_5_1",
            "chicken_weight_kg_5_2",
            "chicken_weight_kg_6_1",
            "chicken_weight_kg_7_1",
            "chicken_weight_kg_7_2",
            "chicken_allowance_price5",
            "chicken_allowance_price6",
            "chicken_allowance_price7",
            "contract2_unamed_1",
            "contract2_unamed_2",
            "contract2_unamed_3_1",
            "contract2_unamed_3_2",
            "contract2_unamed_4",
            "contract2_unamed_5_1",
            "contract2_unamed_5_2",
            "contract2_unamed_5_3",
            "feed_work_rule_1_1_1",
            "feed_work_rule_1_1_2",
            "feed_work_rule_1_2_1",
            "feed_work_rule_1_2_2",
            "feed_work_rule_3_1",
            "feed_work_rule_3_2",
            "chick_out_rule_4",
            "live_chicken_weight_0",
            "live_chicken_weight_1",
            "feed_efficiency",
            "live_chicken_weight_reward1",
            "live_chicken_weight_2",
            "live_chicken_weight_3",
            "live_chicken_weight_reward2",
            "stinking_claw",
            "stinking_claw_type",
            "stinking_claw_reward",
            "stinking_chest",
            "stinking_chest_type",
            "stinking_chest_reward",
            "trading_market_table_0",
            "trading_market_table_1",
            "trading_market_table_2",
            "trading_market_table_3",
            "trading_market_table_4",
            "trading_market_table_5",
            "trading_market_table_6",
            "trading_market_table_7",
            "trading_market_table_8",
            "trading_market_table_9",
            "trading_market_table_10",
            "compensation_0",
            "compensation_1",
            "compensation_2",
            "discount_reward_0",
            "discount_reward_1",
            "discount_reward_2",
            "Feedback_0",
            "Electric_industry_weight_1",
            "Electric_industry_weight_2",
            "contract_big_chicken_wieght_1",
            "contract_big_chicken_wieght_2",
            "contract_big_chicken_price_1",
            "contract_big_chicken_wieght_3",
            "contract_big_chicken_wieght_4",
            "contract_big_chicken_price_2",
            "contract_big_chicken_wieght_5",
            "contract_big_chicken_wieght_6",
            "contract_big_chicken_price_3",
            "contract_little_chicken_wieght_0",
            "contract_little_chicken_price_0",
            "contract_SmellyClaw_%_0",
            "contract_SmellyClaw_%_1-1",
            "contract_SmellyClaw_%_1-2",
            "contract_SmellyClaw_deduction_1-1",
            "contract_SmellyClaw_absorb_1",
            "contract_SmellyClaw_deduction_1-2",
            "contract_SmellyClaw_%_2-1",
            "contract_SmellyClaw_%_2-2",
            "contract_SmellyClaw_deduction_2-1",
            "contract_SmellyClaw_absorb_2",
            "contract_SmellyClaw_deduction_2-2",
            "contract_SmellyClaw_%_3-1",
            "contract_SmellyClaw_%_3-2",
            "contract_SmellyClaw_deduction_3-1",
            "contract_SmellyClaw_absorb_3",
            "contract_SmellyClaw_deduction_3-2",
            "contract_SmellyClaw_%_4-1",
            "contract_SmellyClaw_%_4-2",
            "contract_SmellyClaw_deduction_4-1",
            "contract_SmellyClaw_absorb_4",
            "contract_SmellyClaw_deduction_4-2",
            "contract_SmellyClaw_%_5",
            "contract_SmellyClaw_deduction_5-1",
            "contract_SmellyClaw_absorb_5",
            "contract_SmellyClaw_deduction_5-2",
            "contract_Dermatitis_%_0",
            "contract_Dermatitis_%_1-1",
            "contract_Dermatitis_%_1-2",
            "contract_Dermatitis_deduction_1-1",
            "contract_Dermatitis_absorb_1",
            "contract_Dermatitis_deduction_1-2",
            "contract_Dermatitis_%_2-1",
            "contract_Dermatitis_%_2-2",
            "contract_Dermatitis_deduction_2-1",
            "contract_Dermatitis_absorb_2",
            "contract_Dermatitis_deduction_2-2",
            "contract_Dermatitis_%_3-1",
            "contract_Dermatitis_%_3-2",
            "contract_Dermatitis_deduction_3-1",
            "contract_Dermatitis_absorb_3",
            "contract_Dermatitis_deduction_3-2",
            "contract_Dermatitis_%_4-1",
            "contract_Dermatitis_%_4-2",
            "contract_Dermatitis_deduction_4-1",
            "contract_Dermatitis_absorb_4",
            "contract_Dermatitis_deduction_4-2",
            "contract_Dermatitis_%_5",
            "contract_Dermatitis_deduction_5-1",
            "contract_Dermatitis_absorb_5",
            "contract_Dermatitis_deduction_5-2",
            "contract_smelly_breasts_%_0",
            "contract_smelly_breasts_%_1-1",
            "contract_smelly_breasts_%_1-2",
            "contract_smelly_breasts_deduction_1",
            "contract_smelly_breasts_%_2-1",
            "contract_smelly_breasts_%_2-2",
            "contract_smelly_breasts_deduction_2",
            "contract_smelly_breasts_%_3-1",
            "contract_smelly_breasts_%_3-2",
            "contract_smelly_breasts_deduction_3",
            "contract_smelly_breasts_%_4-1",
            "contract_smelly_breasts_%_4-2",
            "contract_smelly_breasts_deduction_4",
            "contract_smelly_breasts_%_5",
            "contract_smelly_breasts_deduction_5",
            "contract_Tolerance-Of-DeadChicken_SummerMonth_Beginning",
            "contract_Tolerance-Of-DeadChicken_SummerMonth_End",
            "contract_Tolerance-Of-DeadChicken_Summer",
            "contract_Tolerance-Of-DeadChicken_Winter_Beginning",
            "contract_Tolerance-Of-DeadChicken_Winter_End",
            "contract_Tolerance-Of-DeadChicken_Winter",
            "extra_description_0",
            "extra_description_1",
            "extra_description_2",
            "extra_description_3",
            "extra_description_4",
            "extra_description_5",
            "extra_description_0_type",
            "extra_description_1_type",
            "extra_description_2_type",
            "extra_description_3_type",
            "extra_description_4_type",
            "extra_description_5_type",
            "extra_description_0_reward",
            "extra_description_1_reward",
            "extra_description_2_reward",
            "extra_description_3_reward",
            "extra_description_4_reward",
            "extra_description_5_reward"
        ];
        
        foreach ($names as $name) {
            \App\Models\DetailType::factory()->create([
                'name' => $name,
                'description' => null
            ]);
        }


        // $date = Carbon::create(2023, 12, 30);
        // $weight = 0;

        // for ($i = 0; $i < 32; $i++) {
        //     \App\Models\RawWeight::factory()->create([
        //         'batchNumber' => 'G11301107',
        //         'Date' => $date->toDateString(),
        //         'time' => '18:00:00',
        //         'sid' => 32,
        //         'sensorID' => 68,
        //         'weight' => $weight
        //     ]);

        //     $date->addDay();
        //     $weight += 100;
        // }

        // $date = Carbon::create(2023, 11, 30);
        // $weight = 0;
        // for ($i = 0; $i < 32; $i++) {
        //     \App\Models\RawWeight::factory()->create([
        //         'batchNumber' => 'G11301108',
        //         'Date' => $date->toDateString(),
        //         'time' => '18:00:00',
        //         'sid' => 32,
        //         'sensorID' => 68,
        //         'weight' => $weight
        //     ]);

        //     $date->addDay();
        //     $weight += 105;
        // }
    }
}
