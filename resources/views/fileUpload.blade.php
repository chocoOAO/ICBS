{{-- 抄自 https://ithelp.ithome.com.tw/articles/10225776 --}}


@if (isset($message))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif
<form class="form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        {{-- <label for="">檔案上傳</label> --}}
        <input class="form-control-file" type="file" name="ImageFile" id="" accept="image/*" />
    </div>
    <button class="btn btn-primary" type="submit">送出</button>
</form>
