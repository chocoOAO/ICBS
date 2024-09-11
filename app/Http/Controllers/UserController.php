<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function contractEdit(User $user)
    {
        // 確認當前使用者具有管理員權限
        if ($user->isAdmin()) {
            // 更新用戶資料
            // ...
            return redirect()->back()->with('success', '用戶資料已更新！');
        } else {
            // 沒有權限，顯示錯誤訊息
            abort(403, '你沒有權限進行該操作！');
        }
    }

    public function visit()
    {
        return view('guest');
    }

    public function search(Request $request)
    {
        $mKUNAG = $request->input('m_KUNAG');

        $users = User::where('m_KUNAG', $mKUNAG)->get();

        if ($users->isEmpty()) {
            return response()->json(['this m_KUNAG No Exist'], 404);
        }

        $responseData = [
            'm_KUNAG' => $mKUNAG,
            'users' => $this->transformUsers($users),
        ];

        return response()->json($responseData);

    }

    private function transformUsers($users)
    {
        $transformedUsers = [];

        foreach ($users as $user) {
            $transformedUsers[] = [
                'name' => $user->name,
                'email' => $user->email,
                'account' => $user->account,
                'password_unencrypted' => $user->password_unencrypted,
            ];
        }

        return $transformedUsers;
    }

}
