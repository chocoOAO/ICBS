<form action="#" wire:submit.prevent="submit">
    <a href="{{ route('contract.view', ['contract' => $contract]) }}">&lt; 回到合約</a>

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .checkbox {
            background: #f7f7f7;
            height: 50px;
            padding: 5px 10px;
            border-radius: 15px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            border-bottom: 2px solid #d1d3d4;

        }

        .checkbox label {
            font-size: 20px;
            font-weight: 400;
            cursor: pointer;
        }

        legend {
            font-size: 24px;
        }
    </style>
    <div class="container">
        <fieldset>
            <legend>{{ $contract['m_NAME'] }} 合約底下的入雛表</legend>

            <div class="form-group">
                @foreach ($inputs as $key => $input)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="scales[]" value="{{ $inputs[$key]['id'] }}" checked>
                            {{ $inputs[$key]['id'] }} - {{ $inputs[$key]['date'] }} - {{ $inputs[$key]['quantity'] }} -
                            {{ $inputs[$key]['price'] }}
                        </label>
                    </div>
                @endforeach
                <div class="checkbox">
                    <label><input type="checkbox" id="select-all"> 全選 </label>
                </div>
            </div>
        </fieldset>

        <button class="btn btn-primary">確認送出</button>
    </div>

    <script>
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="scales[]"]');

        selectAllCheckbox.addEventListener('click', function() {
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAllCheckbox.checked;
            }
        });
    </script>

</form>
