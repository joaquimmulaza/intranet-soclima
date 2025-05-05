


    <ul class="component_user_post">
    @if($users->isEmpty())
    <p>Nenhuma pessoa encontrada.</p>
    @else
        @foreach($users as $user)
            <li class="" data-toggle="modal" data-target="#cardUserViewNav-{{ $user->id }}">
                <img class="imgUserOnSearchResults" src="/public/avatar_users/{{$user->avatar}}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                <div>
                    <strong>{{ $user->name }}</strong><br>
                    <span class="text-sm text-gray-500">{{ $user->cargo->titulo}}</span>
            </li>
            
<!-- Incluir o componente do modal para cada usuário -->
@include('components.user-modal-content', ['user' => $user])

        @endforeach
    </ul>
@endif