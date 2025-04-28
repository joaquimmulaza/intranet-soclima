@if($users->isEmpty())
    <p>Nenhuma pessoa encontrada.</p>
@else
    <ul class="component_user_post">
        @foreach($users as $user)
            <li class="">
                <img src="/public/avatar_users/{{$user->avatar}}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                <div>
                    <strong>{{ $user->name }}</strong><br>
                    <span class="text-sm text-gray-500">{{ $user->cargo->titulo}}</span>
                </div>
            </li>
        @endforeach
    </ul>
@endif
