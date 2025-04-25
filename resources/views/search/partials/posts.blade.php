@if($posts->isEmpty())
    <p>Nenhuma publicação encontrada.</p>
@else
    <ul class="space-y-3">
        @foreach($posts as $post)
            <li class="border-b pb-3">
                <p>{{ Str::limit($post->content, 200) }}</p>
            </li>
        @endforeach
    </ul>
@endif
