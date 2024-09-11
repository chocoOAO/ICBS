<?php

// 限定A農場同仁只能看A農場相關業務

namespace App\Policies;

use App\Models\User;
use App\Models\Contract;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Date: 2023/8/2
     * 原訂: 是否為同農場的人，才可對 contract 做edit
     * 暫時: 是否為合約創建者，故不同admin也會被限制(暫用 name 欄位做判斷
     * 之後要改成農場欄位或其他，再討論)
     */
    public function update(User $currentUser, Contract $Contract)
    { 
        return $currentUser->name === $Contract->creator
            ? Response::allow()
            : Response::deny('你必須是合約創建者才能編輯合約。');
    }
}