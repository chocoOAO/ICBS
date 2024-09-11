<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPermissionManagementController extends Controller
{
    //分配底下的權限
    public function permissionManagement(Request $request)
    {
        if (auth()->user()->isAdmin() || auth()->user()->permissions[8] > 1) {
            return view('user-permission-management.list', [
                'data' => $request,
                'reset_request' => $request->has('reset_request'),
            ]);
        } else {
            abort(403, '你沒有權限進行該操作！');
        }
    }

    //在這個頁面註冊使用者
    public function add_user(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->account = $request->account;
        $user->password_unencrypted = $request->password;
        if (Auth::user()->auth_type == 'collaborator') {
            $user->auth_type = 'factory_worker';
            $user->permissions = '113111111';
        }
        else{
            $user->auth_type = 'collaborator';
            $user->permissions = '223111111';
        }
        $user->password = bcrypt($request->password);

        if (isset(Auth()->user()->m_KUNAG)) {
            $user->m_KUNAG = Auth()->user()->m_KUNAG;
        }

        $user->save();
        return redirect()->route('user-permission-management');
    }

    public function search_user(Request $request)
    {
        // dd($request->all());

        if (empty($request->account) && empty($request->email) && empty($request->auth_type) && empty($request->m_KUNAG)) {
            return redirect()->route('user-permission-management');
        }

        $usersQuery = DB::table('users');
        if (!empty($request->account)) {
            $usersQuery->where('account', 'like', '%' . $request->account . '%');
        }

        if (!empty($request->email)) {
            $usersQuery->Where('email', 'like', '%' . $request->email . '%');
        }

        if (!empty($request->auth_type)) {
            $usersQuery->Where('auth_type', 'like', $request->auth_type);
        }

        if (!empty($request->m_KUNAG)) {
            $usersQuery->Where('m_KUNAG', 'like', '%' . $request->m_KUNAG . '%');
        }

        $usersQuery->where('auth_type', '!=', "super_admin")->orderByRaw("FIELD(auth_type, 'admin', 'worker', 'collaborator', 'factory_worker')");

        if (Auth::user()->auth_type == 'worker') {
            if (Auth::user()->m_KUNAG != null) {
                $usersQuery->where('auth_type', '!=', 'admin')->where('m_KUNAG', '=', Auth::user()->m_KUNAG);
            } else {
                $usersQuery->where('auth_type', '!=', 'admin');
            }
        } else if (Auth::user()->auth_type == 'collaborator' || Auth::user()->auth_type == 'factory_worker') {
            $usersQuery->where('auth_type', '=', 'collaborator')->where('auth_type', '!=', 'worker')->where('m_KUNAG', '=', Auth::user()->m_KUNAG);
        }

        $users = $usersQuery->get()->toArray();

        return redirect()->route('user-permission-management', [
            'search' => true,
            'data' => $users,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
