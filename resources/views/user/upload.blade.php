<!-- resources/views/user/upload.blade.php -->
<form action="{{ route('user.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file"  required>
    <button type="submit">Importar</button>
</form>
