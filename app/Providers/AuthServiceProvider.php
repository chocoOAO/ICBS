<?php

namespace App\Providers;

use App\Models\Contract;
use App\Models\User;
use App\Policies\ContractPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        App\Models\Contract::class => ContractPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用 before 複寫Gate檢查
        // $gate->before(function ($user, $ability) {
        //     if ($user->auth_type === 'admin') {
        //         return true;
        //     }
        // }

        $this->registerPolicies();

        // Todo：考慮組合成ContractPolicy
        /**
         *  Date: 2023/8/2
         *  update-contract 功能目前改用 ContractPolicy 來做授權
         * */
        // // 只有管理員可以對入雛表做新增修改刪除，其他身分僅能查看
        // Gate::define('opeartor-import', function (User $user, Contract $contract) {
        //     return $user->auth_type === 'admin'
        //         ? Response::allow()
        //         : Response::deny('你必須是管理員才能操作入雛表。');
        // });

        // // 只有管理員可以對驗收單做新增修改刪除，其他身分僅能查看
        // Gate::define('opeartor-verify', function (User $user, Contract $contract) {
        //     return $user->auth_type === 'admin'
        //         ? Response::allow()
        //         : Response::deny('你必須是管理員才能操作驗收單。');
        // });

        /**
         *  Date: 2023/9/7
         *  權限分配的更詳細
         * */

        Gate::define('view-contract', function (User $user) {
            return $user->getPermissions(0) > 1
            ? Response::allow()
            : Response::deny('你沒有權限查看合約。');
        });

        Gate::define('create-contract', function (User $user) {
            return $user->getPermissions(0) > 2
            ? Response::allow()
            : Response::deny('你沒有權限新增合約。');
        });

        //目前先用名稱去對應之後要改成客戶主檔
        Gate::define('edit-contract', function (User $user, Contract $contract) {
            // dd($z_cus_kna1, $user->getPermissions(0), $user->auth_type, $user->name, $contract->name_b);
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }

            // 要將user的name對應到客戶主檔的KUNAG
            // $z_cus_kna1 = ZCusKna1::where('m_KUNAG', $contract->m_KUNAG)->first();
            // else if ($user->getPermission(0) == 4 && $z_cus_kna1->m_KUNAG == $contract->m_KUNAG)
            // else if ($user->getPermissions(0) == 4 && $user->name == $contract->name_b) {
            else if ($user->getPermissions(0) == 4) {

                return Response::allow();
            } else {
                return Response::deny('你沒有權限編輯合約。');
            }

        });

        Gate::define('copy-contract', function (User $user, Contract $contract) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }

            // 要將user的name對應到客戶主檔的KUNAG
            // $z_cus_kna1 = ZCusKna1::where('m_KUNAG', $contract->m_KUNAG)->first();
            // else if ($user->getPermission(0) == 4 && $z_cus_kna1->m_KUNAG == $contract->m_KUNAG)
            // else if ($user->getPermissions(0) > 2 && $user->name == $contract->name_b) {
            else if ($user->getPermissions(0) > 2) {

                return Response::allow();
            } else {
                return Response::deny('你沒有權限編輯合約。');
            }

        });

        Gate::define('delete-contract', function (User $user, Contract $contract) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }

            // 要將user的name對應到客戶主檔的KUNAG
            // $z_cus_kna1 = ZCusKna1::where('m_KUNAG', $contract->m_KUNAG)->first();
            // else if ($user->getPermission(0) == 4 && $z_cus_kna1->m_KUNAG == $contract->m_KUNAG)
            // else if ($user->getPermissions(0) == 4 && $user->name == $contract->name_b) {
            else if ($user->getPermissions(0) == 4) {

                return Response::allow();
            } else {
                return Response::deny('你沒有權限刪除合約。');
            }

        });

        Gate::define('view-import', function (User $user, Contract $contract) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }
            // 要將user的name對應到客戶主檔的KUNAG
            // $z_cus_kna1 = ZCusKna1::where('m_KUNAG', $contract->m_KUNAG)->first();
            // else if ($user->getPermission(0) == 4 && $z_cus_kna1->m_KUNAG == $contract->m_KUNAG)
            // else if ($user->getPermissions(1) > 1 && $user->name == $contract->name_b) {
            else if ($user->getPermissions(1) > 1) {
                return Response::allow();
            } else {
                return Response::deny('你沒有權限查閱入雛表。');
            }

        });

        Gate::define('create-import', function (User $user, Contract $contract) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }
            else if ($user->getPermissions(1) > 1) {
                return Response::allow();
            } else {
                return Response::deny('你沒有管理查閱入雛表。');
            }

        });

        Gate::define('delete-import', function (User $user, Contract $contract) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }
            else if ($user->getPermissions(1) == 4) {
                return Response::allow();
            } else {
                return Response::deny('你沒有管理查閱入雛表。');
            }

        });

        Gate::define('view-growth', function (User $user) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }
            else if ($user->getPermissions(2) > 1) {
                return Response::allow();
            } else {
                return Response::deny('你沒有權限查看生長紀錄表。');
            }
        });

        Gate::define('edit-growth', function (User $user) {
            if ($user->auth_type === 'admin') {
                return Response::allow();
            }
            else if ($user->getPermissions(2) > 1) {
                return Response::allow();
            } else {
                return Response::deny('你沒有權限編輯生長紀錄表。');
            }
        });
    }
}
