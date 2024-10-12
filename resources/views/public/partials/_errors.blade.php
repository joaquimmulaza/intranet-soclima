@if($errors->all())
    @foreach($errors->all() as $error)
        <div role="alert" class="text-center" style="color: red;">Dados informado incorretos! {{$error}}</div>
    @endforeach
@endif