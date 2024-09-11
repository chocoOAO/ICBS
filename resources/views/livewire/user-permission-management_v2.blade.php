<div class="container">
    <button class="btn btn-primary" id="open_filter">搜尋</button>
    <dialog id="filter_context">
        <form method="POST" action="{{ route('user-permission-management.search_user') }}">
            @csrf
            <div>
                <x-jet-label for="account" value="{{ __('Account') }}" />
                <x-jet-input id="account" class="block mt-1 w-full" type="text" name="account" :value="old('account')"
                    placeholder="{{ __('選填') }}" autofocus autocomplete="account" />
            </div>

            <!-- <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')"
                    placeholder="{{ __('選填') }}" />
            </div> -->

            <div class="mt-4">
                <x-jet-label for="auth_type" value="{{ __('角色') }}" />
                {{-- <x-jet-input id="auth_type" class="block mt-1 w-full" type="text" name="auth_type"
                            :value="old('auth_type')" placeholder="{{ __('選填') }}"  /> --}}
                <select class="form-control" name="auth_type" style="width: 260px;">
                    <option selected="selected" value="" hidden>選填</option>
                    @foreach ($this->auth_type as $type => $value)
                        @if ($type == 'super_admin')
                            @continue
                        @endif
                        <option value="{{ $type }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="m_KUNAG" value="{{ __('客戶主檔') }}" />
                <x-jet-input id="m_KUNAG" class="block mt-1 w-full" type="text" name="m_KUNAG" :value="old('m_KUNAG')"
                    placeholder="{{ __('選填') }}" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Search') }}
                </x-jet-button>
                <x-jet-button class="ml-4" id="close_filter">
                    {{ __('Close') }}
                </x-jet-button>
            </div>
        </form>
    </dialog>
    <div class=" @if (Auth::user()->permissions[8] < 4) cant_edit_permission @endif">
        <table>
            <thead>
                <tr>
                    <th scope="col">帳號</th>
                    <th scope="col">客戶主檔</th>
                    <th scope="col">角色</th>
                    <th scope="col">操作權限</th>
                </tr>
            </thead>

            <p style="text-align: right;">
                <span style="background-color: red; color: white; padding: 4px; border-radius: 4px;">可以管理所有檔案</span>
                <span style="background-color: blue; color: white; padding: 4px; border-radius: 4px;">可以新增資料</span>
                <span style="background-color: green; color: white; padding: 4px; border-radius: 4px;">可以查看</span>
                <span style="background-color: gray; color: white; padding: 4px; border-radius: 4px;">無法查看</span>
            </p>
            <tbody>
                @if (isset($this->data))
                    @foreach ($this->data as $key => $user)
                        <tr class=" @if (Auth::user()->id == $user['id']) cant_edit_self @endif">
                            @php
                                $account_button_id = 'account_show_' . $user['id'];
                                $account_dialog_id = 'account_infoModal_' . $user['id'];
                                $account_close_id = 'account_close_' . $user['id'];
                                $auth_button_id = 'auth_show_' . $user['id'];
                                $auth_dialog_id = 'auth_infoModal_' . $user['id'];
                                $auth_close_id = 'auth_close_' . $user['id'];
                                $buttonColor = ''; // 自訂顏色
                                if ($this->getTypeName($user['auth_type']) === '管理員') {
                                    $buttonColor = 'red';
                                } elseif ($this->getTypeName($user['auth_type']) === '業務員') {
                                    $buttonColor = 'purple';
                                } else {
                                    $buttonColor = 'orange';
                                }
                            @endphp
                            <!-- 帳號詳細資料 -->
                            <td>
                                {{-- {{ $user['name'] }} --}}
                                <button class="btn btn-primary"
                                    id="{{ $account_button_id }}">{{ $user['account'] }}</button>
                                <dialog id="{{ $account_dialog_id }}">
                                    <div style="display: flex;">
                                        <p>帳戶詳細資料</p>
                                    </div>
                                    <div>
                                        <p>帳號：{{ $user['account'] }}</p>
                                        <p>姓名：{{ $user['name'] }}</p>
                                        

                                        @if (Auth::user()->auth_type == 'super_admin' ||
                                                Auth::user()->id == $user['id'] ||
                                                in_array($user['auth_type'], $this->getSmallerAuthType(Auth::user()->auth_type)))
                                            <p>密碼: {{ $user['password_unencrypted'] }}</p>
                                        @endif
                                        <button class="btn btn-primary" id="{{ $account_close_id }}">Close</button>
                                </dialog>
                            </td>


                            <!-- 客戶主檔 -->
                            <td>
                                <select class ="@if (Auth::user()->auth_type == 'collaborator' || Auth::user()->auth_type == 'factory_worker') small_than_cant_edit_other @endif" wire:model.lazy="data.{{ $key }}.m_KUNAG" style="width: 260px;">    
                                <option selected="selected" @if (in_array($user['auth_type'], ['collaborator', 'factory_worker'])) hidden @endif>無指定</option>
                                    @foreach ($this->z_cus_kna1 as $type => $value)
                                        <option value="{{$value['m_KUNAG']}}">
                                            {{ $value['m_KUNAG'] . ' ' . $value['m_NAME'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>


                            <!-- 編輯角色權限 -->
                            <td>
                                <button class="btn btn-primary"
                                    style=" white-space: nowrap; text-align: center; background-color: {{ $buttonColor }}; border: 1px solid white;"
                                    id={{ $auth_button_id }}>{{ $this->getTypeName($user['auth_type']) }}</button>
                                <dialog id="{{ $auth_dialog_id }}">
                                    <div style="display: flex;">
                                        <p>選擇角色：</p>
                                    </div>
                                    <select name="Role" wire:change="updateRole('{{ $key }}')"
                                        wire:model.lazy="selectedRole">
                                        <option selected="selected" hidden>請選擇</option>
                                        @foreach ($this->getSmallerAuthType(Auth::user()->auth_type) as $type => $value)
                                            @if ($type == 'super_admin')
                                                @continue
                                            @endif
                                            <option value="{{ $value }}">
                                                {{ $this->getTypeName($value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" id="{{ $auth_close_id }}">Close</button>
                                </dialog>
                            </td>

                            <!-- 操作權限 -->
                            <td>
                                @foreach ($this->page as $index => $value)
                                    @php
                                        $controll_dialog_id = 'controll_infoModal_' . $user['id'] . '_' . $index;
                                        $controll_button_id = 'controll_show_' . $user['id'] . '_' . $index;
                                        $controll_close_id = 'controll_close_' . $user['id'] . '_' . $index;
                                        $buttonColor = ''; // 自訂顏色
                                        if ($data[$key]['permissions'][$index] < 2) {
                                            $buttonColor = 'gray'; // 無法看到頁面
                                        } elseif ($data[$key]['permissions'][$index] == 2) {
                                            $buttonColor = 'green'; // 可以看到頁面
                                        } elseif ($data[$key]['permissions'][$index] == 3) {
                                            $buttonColor = 'blue'; // 可以新增資料
                                        } else {
                                            $buttonColor = 'red'; // 可以編輯過往紀錄
                                        }
                                    @endphp
                                    <button class="btn btn-primary @if (Auth::user()->permissions[$index] < $data[$key]['permissions'][$index]) small_than_cant_edit_other @endif"
                                        style="text-align: center; background-color: {{ $buttonColor }}; border: 1px solid white;"
                                        id={{ $controll_button_id }}>{{ $value }}</button>
                                    <dialog id={{ $controll_dialog_id }}>
                                        <p>選擇權限：</p>
                                        <select name="permission"
                                            wire:change="updatePermission('{{ $key }}', {{ $index }})"
                                            wire:model.lazy="selectedPermission">
                                            <option selected="selected" hidden>請選擇</option>
                                            @foreach ($this->getSmallerControllType(Auth::user()->permissions[$index]) as $type)
                                                <option value="{{ $type }}">
                                                    {{ $this->getControllTypeName($type) }}
                                                </option>
                                            @endforeach
                                            </option>
                                        </select>
                                        <button class="btn btn-primary" id={{ $controll_close_id }}>Close</button>
                                    </dialog>
                                @endforeach
                            </td>
                            <td style="text-align: center">
                                <button class="btn-primary"
                                    style="background-color: rgb(0, 0, 0); color: white; white-space: nowrap;"
                                    type="button" onclick="confirm('你確定真的要刪除嗎?') || event.stopImmediatePropagation()"
                                    wire:click="delete_user({{ $key }})">刪除</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <button class="btn-primary @if (Auth::user()->permissions[8] < 3) cant_add_user @endif" type="button"
            id="open_add_user_dialog">新增使用者</button>
        <dialog id="add_user_dialog">
            <form method="POST" action="{{ route('user-permission-management.add_user') }}">
                @csrf

                <div>
                    <x-jet-label for="account" value="{{ __('Account') }}" />
                    <x-jet-input id="account" class="block mt-1 w-full" type="text" name="account"
                        :value="old('account')" required autofocus autocomplete="account" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <!-- <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required />
                </div> -->

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>

                <!-- 提交按鈕 -->
                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Register') }}
                    </x-jet-button>
                    <x-jet-button class="ml-4" id="close_add_user_dialog">
                        {{ __('Close') }}
                    </x-jet-button>
                </div>
            </form>
        </dialog>
        <div>
            <button class="btn-primary" type="button" wire:click="reset_data">還原</button>
            <button class="btn-primary" type="button" style="margin-left: 10px;" wire:click="submit">保存</button>
        </div>
    </div>

</div>


<script type="text/javascript">
    @if (isset($this->data))
        @foreach ($this->data as $key => $user)
            let account_btn{{ $user['id'] }} = document.querySelector("#account_show_{{ $user['id'] }}");
            let account_infoModal{{ $user['id'] }} = document.querySelector(
                "#account_infoModal_{{ $user['id'] }}");
            let account_close{{ $user['id'] }} = document.querySelector("#account_close_{{ $user['id'] }}");

            let auth_btn{{ $user['id'] }} = document.querySelector("#auth_show_{{ $user['id'] }}");
            let auth_infoModal{{ $user['id'] }} = document.querySelector("#auth_infoModal_{{ $user['id'] }}");
            let auth_close{{ $user['id'] }} = document.querySelector("#auth_close_{{ $user['id'] }}");

            account_btn{{ $user['id'] }}.addEventListener("click", function() {
                account_infoModal{{ $user['id'] }}.showModal();
            });

            account_close{{ $user['id'] }}.addEventListener("click", function() {
                account_infoModal{{ $user['id'] }}.close();
            });

            @foreach ($this->page as $index => $value)
                let controll_btn{{ $user['id'] }}_{{ $index }} = document.querySelector(
                    "#controll_show_{{ $user['id'] }}_{{ $index }}");
                let controll_infoModal{{ $user['id'] }}_{{ $index }} = document.querySelector(
                    "#controll_infoModal_{{ $user['id'] }}_{{ $index }}");
                let controll_close{{ $user['id'] }}_{{ $index }} = document.querySelector(
                    "#controll_close_{{ $user['id'] }}_{{ $index }}");


                auth_btn{{ $user['id'] }}.addEventListener("click", function() {
                    auth_infoModal{{ $user['id'] }}.showModal();
                });

                auth_close{{ $user['id'] }}.addEventListener("click", function() {
                    auth_infoModal{{ $user['id'] }}.close();
                });

                controll_btn{{ $user['id'] }}_{{ $index }}.addEventListener("click", function() {
                    controll_infoModal{{ $user['id'] }}_{{ $index }}.showModal();
                });

                controll_close{{ $user['id'] }}_{{ $index }}.addEventListener("click", function() {
                    controll_infoModal{{ $user['id'] }}_{{ $index }}.close();
                });
            @endforeach
        @endforeach
    @endif

    let open_filter = document.querySelector("#open_filter");
    let filter_context = document.querySelector("#filter_context");
    let close_filter = document.querySelector("#close_filter");

    let open_add_user_dialog = document.querySelector("#open_add_user_dialog");
    let add_user_dialog = document.querySelector("#add_user_dialog");
    let close_add_user_dialog = document.querySelector("#close_add_user_dialog");

    open_filter.addEventListener("click", function() {
        filter_context.showModal();
    });

    close_filter.addEventListener("click", function() {
        filter_context.close();
    });

    open_add_user_dialog.addEventListener("click", function() {
        add_user_dialog.showModal();
    });

    close_add_user_dialog.addEventListener("click", function() {
        add_user_dialog.close();
    });

    window.addEventListener('keydown', function(event) {
        if (event.key === 'F5') {
            // 在重新整理時，將頁面重新導向到相同的 URL 但加上查詢參數
            let url = new URL(window.location.href);
            url.searchParams.set('reset_request', '1');
            window.location.href = url.toString();
        }
    });
</script>

{{-- css --}}
<style>
    .dialog {
        border: none;
        box-shadow: 0 2px 6px #ccc;
        border-radius: 10px;
    }

    tr {
        border: 1px solid black;
        /* 为每个<tr>元素添加边框 */
    }

    th,
    td {
        border: 1px solid black;
        /* 为表头单元格和数据单元格添加边框 */
        padding: 8px;
        /* 可选：添加内边距以增加单元格内容的间距 */
        text-align: center;
        /* 可选：居中文本内容 */
    }

    .container {
        overflow: auto;
    }

    /* 根據權限判定能不能新增使用者 */
    .cant_add_user {
        pointer-events: none;
        color: #676565;
    }

    /* 根據權限判定能不能編輯使用者 */
    .cant_edit_permission {
        pointer-events: none;
        color: #000;
    }

    /* 不能編輯自己 */
    .cant_edit_self {
        pointer-events: none;
        color: #000;
    }

    /* 權限比較小不能動別人權限 */
    .small_than_cant_edit_other {
        pointer-events: none;
    }
</style>
