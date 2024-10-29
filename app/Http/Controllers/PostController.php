<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->$post = $post;
    }

    public function index(){
        $posts = Post::all();

        // Calcula as visualizações de cada post
        foreach ($posts as $post) {
            $post->views_count = \DB::table('post_views')
                ->where('post_id', $post->id)
                ->count();
            
        }

        return view('public.home', compact('posts'));
    }

    public function create(){
        return view('post.create');
    }

    public function store(Request $request) {
        try {
            // Criando comunicado ou evento
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->slug = Str::slug($request->title, '-');
            $post->ativo = 1;

            // Verificando se há upload de imagem de capa
            if($request->hasFile('arquivo_imagem')) {
                $imagem = $request->file('arquivo_imagem');
                $imagemNome = time() . '.' . $imagem->getClientOriginalExtension();
                $imagemPath = "uploads/imagens/" . $imagemNome;
                $imagem->move(public_path('uploads/imagens'), $imagemNome);
                $post->arquivo_imagem = $imagemPath;
            }

            // Verificando se há upload de arquivo PDF
            if($request->hasFile('arquivo_pdf')) {
                $pdf = $request->file('arquivo_pdf');
                $pdfNome = time() . '.' . $pdf->getClientOriginalExtension();
                $pdfPath = "uploads/pdfs/" . $pdfNome;
                $pdf->move(public_path('uploads/pdfs'), $pdfNome);
                $post->arquivo_pdf = $pdfPath;
            }

            $user = Auth::user();
            $user->posts()->save($post);

            notify()->success("Comunicado ou evento criado com sucesso!", "Success", "bottomRight");
            return redirect()->route('home');
        } catch (\Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }

    public function edit(Post $post){
        return view('post.create', compact('post'));
    }

    public function listPosts(){
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function update(Request $request, Post $post) {
        try {
            // Atualizando evento ou comunicado
            $post->title = $request->title;
            $post->content = $request->content;
            $post->slug = Str::slug($request->title, '-');

            // Atualizando imagem de capa
            if ($request->hasFile('arquivo_imagem')) {
                if ($post->arquivo_imagem) {
                    File::delete(public_path($post->arquivo_imagem));
                }

                $imagem = $request->file('arquivo_imagem');
                $imagemNome = time() . '.' . $imagem->getClientOriginalExtension();
                $imagemPath = "uploads/imagens/" . $imagemNome;
                $imagem->move(public_path('uploads/imagens'), $imagemNome);
                $post->arquivo_imagem = $imagemPath;
            }

            // Atualizando arquivo PDF
            if ($request->hasFile('arquivo_pdf')) {
                if ($post->arquivo_pdf) {
                    File::delete(public_path($post->arquivo_pdf));
                }

                $pdf = $request->file('arquivo_pdf');
                $pdfNome = time() . '.' . $pdf->getClientOriginalExtension();
                $pdfPath = "uploads/pdfs/" . $pdfNome;
                $pdf->move(public_path('uploads/pdfs'), $pdfNome);
                $post->arquivo_pdf = $pdfPath;
            }

            $post->save();

            notify()->success("Comunicado ou evento atualizado com sucesso!", "Success", "bottomRight");
            return redirect()->route('post.show', $post);
        } catch (\Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }

        
    }

    public function show(Post $post)
    {
     

        $dataHoje = Carbon::now();

        // Busca posts válidos e exclui o post atual
        $posts = Post::where('id', '!=', $post->id)
            // ->where('validate_at', '>=', $dataHoje->toDateString())
            ->orderBy('id', 'DESC')
            ->paginate(3);

        // Verifica se o usuário está logado e se já visualizou o post
        $userId = Auth::id();
        if ($userId) {
            $viewExists = \DB::table('post_views')
                ->where('post_id', $post->id)
                ->where('user_id', $userId)
                ->exists();

            if (!$viewExists) {
                // Se o usuário ainda não visualizou, salva a visualização
                \DB::table('post_views')->insert([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        // Retorna a view
        // Obter a contagem de likes
        $likes_count = likes_post($post->id);

    // Retorna a view
    return view('public.show', ['post' => $post, 'posts' => $posts, 'likes_count' => $likes_count]);

    }


    public function destroy(Post $post){
        try {
            if ($post->arquivo_imagem) {
                File::delete(public_path($post->arquivo_imagem));
            }
            if ($post->arquivo_pdf) {
                File::delete(public_path($post->arquivo_pdf));
            }
            $post->delete();

            notify()->success("Comunicado ou evento excluído com sucesso!", "Success", "bottomRight");
            return redirect()->route('post.all');
        } catch (\Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }
}
