<?php

namespace App\Providers;

use App\Http\Livewire\ContractWizardComponent;
use App\Http\Livewire\Steps\BasicInformationStepComponent;
use App\Http\Livewire\Steps\ChooseContractTypeStepComponent;
use App\Http\Livewire\Steps\ShowSelectedContractTypeStepComponent;
use Illuminate\Support\ServiceProvider;

use App\Http\Livewire\ChickenImportComponent;
use App\Http\Livewire\ChickenVerifyComponent;
use App\Http\Livewire\GrowthRecordComponent;
use App\Http\Livewire\TraceabilityComponent;

use App\Http\Livewire\ChickenOutComponent;
use App\Http\Livewire\NavigationMenu;
use App\Http\Livewire\AdmissionComponent;
use App\Http\Livewire\Settlement;
use App\Http\Livewire\ChartComponent;

use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Blade::component('layouts.layout', 'layout');
        // Blade::component('components.button', 'button');
        // Blade::component('components.input', 'input');

        // 合約表
        Livewire::component('contract-wizard', ContractWizardComponent::class);
        Livewire::component('basic-information-step', BasicInformationStepComponent::class);
        Livewire::component('choose-contract-type-step', ChooseContractTypeStepComponent::class);
        Livewire::component('show-selected-contract-type-step', ShowSelectedContractTypeStepComponent::class);

        // 飼養入雛表
        Livewire::component('chicken-import', ChickenImportComponent::class);

        // 入雛驗收單
        Livewire::component('chicken-verify', ChickenVerifyComponent::class);

        // 生長紀錄表
        Livewire::component('growth-record', GrowthRecordComponent::class);

        // 抓雞派車單
        Livewire::component('chicken-out', ChickenOutComponent::class);

        // 產銷履歷
        Livewire::component('traceability', TraceabilityComponent::class);

        // 導覽列
        Livewire::component('navigation-menu', NavigationMenu::class);

        // 毛雞結款單
        Livewire::component('select-import', Import2Settlement::class);
        Livewire::component('settlement', Settlement::class);

        // 入場
        Livewire::component('addmission', AdmissionComponent::class);

        // 飼養數據圖
        Livewire::component('chart', ChartComponent::class);
    }
}
