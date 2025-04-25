@if($users->isEmpty())
    <p>Nenhuma pessoa encontrada.</p>
@else
    <ul class="space-y-2">
        @foreach($users as $user)
            <li class="flex items-center space-x-3 border-b pb-2">
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                <div>
                    <strong>{{ $user->name }}</strong><br>
                    <span class="text-sm text-gray-500">{{ $user->cargo_id }}</span>
                </div>
            </li>
        @endforeach
    </ul>
@endif
