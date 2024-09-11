<div>
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">名稱</th>
                    <th scope="col">角色</th>
                    <th scope="col">操作權限</th>
                    {{-- <th scope="col">操作</th> --}}

                    {{-- <th scope="col">操作</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($this->data as $key => $user)
                    <tr>
                        @php
                            $auth_button_id = 'auth_show_' . $user['id'];
                            $auth_dialog_id = 'auth_infoModal_' . $user['id'];
                            $auth_close_id = 'auth_close_' . $user['id'];
                            $controll_dialog_id = 'controll_infoModal_' . $user['id'];
                            $controll_button_id = 'controll_show_' . $user['id'];
                            $controll_close_id = 'controll_close_' . $user['id'];
                        @endphp
                        <th scope="row">{{ $user['id'] }}</th>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $this->getTypeName($user['auth_type']) }}</td>

                        {{-- @php
                        dd($this->data[$key]['permissions'][0]);
                        @endphp --}}
                        <td>
                            <td>
                                @php
                                    // 如果是admin一律11111
                                    if ($this->data[$key]['auth_type'] == 'admin') {
                                        $this->data[$key]['permissions'] = "11111";
                                    }
                                    // $isCheckedCreate = $this->data[$key]['permissions'][0];
                                    // $isCheckedRead = $this->data[$key]['permissions'][1];
                                    // $isCheckedUpdate = $this->data[$key]['permissions'][2];
                                    // $isCheckedDelete = $this->data[$key]['permissions'][3];
                                    // $isCheckedPrint = $this->data[$key]['permissions'][4];
                                @endphp
                            
                            @foreach ($operatePermissions as $operate => $value)
                                <label>
                                    <input type="checkbox" name="ids[]" {{ $this->data[$key]['permissions'][$operate] ? 'checked' : '' }}>
                                    {{ $value }}
                                </label>
                            @endforeach
                            </td>
                            
                            
                        </td>
                        
                        
                        <!-- 編輯角色權限 -->
                        <td>
                            <button class="btn btn-primary" id={{ $auth_button_id }} >編輯權限</button>
                            <dialog id="{{ $auth_dialog_id }}">
                                <div style="display: flex;" >
                                <p>選擇角色：</p> <p>修改操作權限：</p>
                                </div>
                                <select name="permission" wire:change="updatePermission('{{ $key }}')" wire:model.lazy="selectedPermission">
                                    @foreach ($this->auth_type as $type => $value)
                                        <option value="{{ $type }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @foreach ($operatePermissions as $operate => $value)
                                    <label>
                                        <input type="checkbox" name="ids[]" {{ $this->data[$key]['permissions'][$operate] ? 'checked' : '' }} w>
                                        {{ $value }}
                                    </label>
                                @endforeach
                                <button class="btn btn-primary" id="{{ $auth_close_id }}">Close</button>
                            </dialog>
                        </td>

                        {{-- 操作權限 --}}
                        {{-- <td>
                        <button class="btn btn-primary" id={{ $controll_button_id }}>show</button>
                        <dialog id={{ $controll_dialog_id }}>
                            <p>選擇權限：</p>
                            <select name="permission" wire:change="updatePermission('{{ $user['id'] }}')"
                                wire:model.lazy="selectedPermission">
                                @foreach ($this->controll_type as $type => $value)
                                    <option value="{{ $type }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                                </option>
                            </select>
                            <button class="btn btn-primary" id={{ $controll_close_id }}>Close</button>
                        </dialog>
                    </td> --}}

                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <button class="btn-primary" type="button" wire:click="submit">保存</button>
    </div>
</div>


<script type="text/javascript">
    @foreach ($this->data as $key => $user)
        let auth_btn{{ $user['id'] }} = document.querySelector("#auth_show_{{ $user['id'] }}");
        let auth_infoModal{{ $user['id'] }} = document.querySelector("#auth_infoModal_{{ $user['id'] }}");
        let auth_close{{ $user['id'] }} = document.querySelector("#auth_close_{{ $user['id'] }}");
        // let controll_btn{{ $user['id'] }} = document.querySelector("#controll_show_{{ $user['id'] }}");
        // let controll_infoModal{{ $user['id'] }} = document.querySelector("#controll_infoModal_{{ $user['id'] }}");
        // let controll_close{{ $user['id'] }} = document.querySelector("#controll_close_{{ $user['id'] }}");

        auth_btn{{ $user['id'] }}.addEventListener("click", function() {
            auth_infoModal{{ $user['id'] }}.showModal();
        });

        auth_close{{ $user['id'] }}.addEventListener("click", function() {
            auth_infoModal{{ $user['id'] }}.close();
        });

        // controll_btn{{ $user['id'] }}.addEventListener("click", function() {
        //     controll_infoModal{{ $user['id'] }}.showModal();
        // });

        // controll_close{{ $user['id'] }}.addEventListener("click", function() {
        //     controll_infoModal{{ $user['id'] }}.close();
        // });
    @endforeach

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
</style>
