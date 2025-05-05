@extends('master.layout')
@section('title', 'Pesquisa')

@section('content')
<div class="search-results ">
    <h2 class="text-xl font-bold mb-4 hidden">Resultados para "{{ $query }}"</h2>

    <div class="tabs">
        <a href="{{ route('search.results.tab', ['tab' => 'all', 'query' => $query]) }}"
        class="tab-link {{ $tab === 'all' ? 'activeBtnSearch' : '' }}">Tudo</a>

        <a href="{{ route('search.results.tab', ['tab' => 'users', 'query' => $query]) }}"
        class="tab-link {{ $tab === 'users' ? 'activeBtnSearch' : '' }}">Pessoas</a>

        <a href="{{ route('search.results.tab', ['tab' => 'posts', 'query' => $query]) }}"
        class="tab-link {{ $tab === 'posts' ? 'activeBtnSearch' : '' }}">Publicações</a>
    </div>

    @if($tab === 'all' || $tab === 'users')
        <div class="tab-content" id="users_result_search_container">
            <h3 class="title_tab_search">Pessoas</h3>
            @include('search.partials.users', ['users' => $users])
        </div>
    @endif

    @if($tab === 'all' || $tab === 'posts')
        <div class="tab-content" id="posts">
            <h3 class="title_tab_search">Publicações</h3>
            @include('search.partials.posts', ['posts' => $posts])
        </div>
    @endif
</div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        links.forEach(link => {
            link.addEventListener('click', () => {
                links.forEach(l => l.classList.remove('activeBtnSearch'));
                contents.forEach(c => c.classList.add('hidden'));

                link.classList.add('activeBtnSearch');
                const tab = link.getAttribute('data-tab');
                document.getElementById(tab).classList.remove('hidden');
            });
        });
    });
</script>