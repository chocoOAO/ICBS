<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file">
    <button type="submit">导入</button>
</form>
