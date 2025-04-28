<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query', '');
    
        if (trim($query) === '') {
            return response()->json([]);
        }
    
        // Buscar todos usuários e posts que correspondem à pesquisa
        $users = User::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'cargo_id', 'avatar')
            ->with('cargo:id,titulo')
            ->get();
    
        $posts = Post::where('content', 'like', "%{$query}%")
            ->select('id', 'content')
            ->get();
    
        // Priorizar usuários: adicionar primeiro até 7
        $results = [];
        foreach ($users as $user) {
            if (count($results) < 7) {
                $results[] = ['type' => 'user', 'data' => $user];
            }
        }
    
        // Adicionar posts até completar 7 no total
        foreach ($posts as $post) {
            if (count($results) < 7) {
                $results[] = ['type' => 'post', 'data' => $post];
            }
        }
    
        // Mostrar botão "Ver mais resultados" se houver mais que 7 no total
        $hasMore = ($users->count() + $posts->count()) > 7;
    
        return response()->json([
            'results' => $results,
            'hasMore' => $hasMore,
        ]);
    }
    

    public function results(Request $request)
    {
        $query = $request->get('query', '');

        $users = User::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'cargo_id', 'avatar')
            ->get();

        $posts = Post::where('content', 'like', "%{$query}%")
        ->with('user') // <- aqui carrega o relacionamento user
        ->select('id', 'content', 'title', 'arquivo_imagem', 'arquivo_pdf', 'user_id') // inclua o user_id
            ->get();

        return view('search.results', compact('query', 'users', 'posts'));
    }
}