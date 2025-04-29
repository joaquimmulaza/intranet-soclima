@extends('master.layout')
@section('title', 'Pesquisa')

@section('content')
<div class="search-results ">
    <h2 class="text-xl font-bold mb-4 hidden">Resultados para "{{ $query }}"</h2>

    <div class="tabs">
        <button class="tab-link activeBtnSearch" data-tab="all">Tudo</button>
        <button class="tab-link" data-tab="users_result_search_container">Pessoas</button>
        <button class="tab-link" data-tab="posts">Publicações</button>
    </div>

    <div class="tab-content" id="all">
        <div class="tabs_container pessoasContainelAllSearch">
            <h3 class="title_tab_search">Pessoas</h3>
            @include('search.partials.users', ['users' => $users])
        </div>

        <div class="tabs_container postsContainerAllSearch">
            <h3 class="title_tab_search">Publicações</h3>
            @include('search.partials.posts', ['posts' => $posts])
        </div>
    </div>

    <div class="tab-content hidden " id="users_result_search_container">
        <h3 class="title_tab_search">Pessoas</h3>
        @include('search.partials.users', ['users' => $users])
    </div>

    <div class="tab-content hidden" id="posts">
        <h3 class="title_tab_search">Publicações</h3>
        @include('search.partials.posts', ['posts' => $posts])
    </div>
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

