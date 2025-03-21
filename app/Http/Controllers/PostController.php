<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->$post = $post;
    }

    public function index()
    {
        $posts = Post::all();
    
        // Calcula a contagem inicial de visualizações para cada post
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
                $pdfPaths = [];
                foreach ($request->file('arquivo_pdf') as $pdf) {
                    $pdfNome = time() . '_' . $pdf->getClientOriginalName();
                    $pdfPath = "uploads/pdfs/" . $pdfNome;
                    $pdf->move(public_path('uploads/pdfs'), $pdfNome);
                    $pdfPaths[] = $pdfPath;
                }
                $post->arquivo_pdf = json_encode($pdfPaths); // Armazena os caminhos dos PDFs como JSON
            }

            $user = Auth::user();
            $user->posts()->save($post);

           // Retornar uma resposta JSON de sucesso
        return response()->json([
            'success' => true,
            'message' => 'Comunicado ou evento criado com sucesso!',
            'post' => $post // Inclui os dados do post criado
        ], 200);

        } catch (\Exception $e) {
            // Retornar uma resposta JSON de erro
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Post $post)
    {
        return response()->json([
            'success' => true,
            'post' => $post
        ]);
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

        // Removendo PDFs selecionados pelo usuário
        if ($request->has('removed_pdfs')) {
            $removedPdfs = json_decode($request->input('removed_pdfs'), true) ?? [];
            
            // Carregar PDFs existentes
            $existingPdfs = json_decode($post->arquivo_pdf, true) ?? [];
            Log::debug('PDFs existentes antes da remoção: ', $existingPdfs);
            Log::debug('PDFs removidos enviados: ', $removedPdfs);

            // Filtrar PDFs restantes e excluir arquivos físicos
            $existingPdfs = array_filter($existingPdfs, function ($path) use ($removedPdfs) {
                $fileName = basename($path);
                if (in_array($fileName, $removedPdfs)) {
                    if (File::exists(public_path($path))) {
                        File::delete(public_path($path)); // Apagar o arquivo do diretório
                        Log::debug("Arquivo deletado: " . $path);
                    }
                    return false; // Remove do array de PDFs existentes
                }
                return true; // Mantém os arquivos restantes
            });

            $existingPdfs = array_values($existingPdfs); // Reindexa o array de PDFs
            Log::debug('PDFs após a remoção: ', $existingPdfs);
            $post->arquivo_pdf = json_encode($existingPdfs);
        }

        // Adicionar novos PDFs
        if ($request->hasFile('arquivo_pdf')) {
            $existingPdfs = json_decode($post->arquivo_pdf, true) ?? [];
            Log::debug('PDFs antes de adicionar novos: ', $existingPdfs);

            foreach ($request->file('arquivo_pdf') as $pdf) {
                $pdfNome = uniqid() . '_' . $pdf->getClientOriginalName();
                $pdfPath = "uploads/pdfs/" . $pdfNome;

                // Verificar se o arquivo já existe na lista
                if (!in_array($pdfPath, $existingPdfs)) {
                    Log::debug("Novo PDF adicionado: " . $pdfPath);
                    try {
                        $pdf->move(public_path('uploads/pdfs'), $pdfNome);
                        $existingPdfs[] = $pdfPath;
                    } catch (\Exception $e) {
                        Log::error('Erro ao mover o arquivo PDF: ' . $e->getMessage());
                        return response()->json([
                            'success' => false,
                            'message' => 'Erro ao mover o arquivo PDF. ' . $e->getMessage()
                        ], 500);
                    }
                } else {
                    Log::debug("PDF já existente, não adicionado: " . $pdfPath);
                }
            }

            // Atualiza o campo 'arquivo_pdf' com a lista final de arquivos
            Log::debug('PDFs após adicionar novos: ', $existingPdfs);
            $post->arquivo_pdf = json_encode(array_values($existingPdfs));
        }
        
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Comunicado ou evento atualizado com sucesso!',
            'post' => $post
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
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
        $post->views_count = $this->registerPostView($post->id);
        // Retorna a view
        // Obter a contagem de likes
        $likes_count = likes_post($post->id);

    // Retorna a view
    return view('public.show', ['post' => $post, 'posts' => $posts, 'likes_count' => $likes_count]);

    }

    public function deletePdf(Request $request, $postId)
{
    // Buscar o post
    $post = Post::findOrFail($postId);

    // Decodificar os PDFs armazenados no campo do banco de dados
    $pdfs = json_decode($post->pdfs, true); // Certifique-se que o campo 'pdfs' é JSON

    // Caminho do PDF que será removido
    $pdfToRemove = $request->input('pdf');

    // Remover apenas o PDF específico
    if (($key = array_search($pdfToRemove, $pdfs)) !== false) {
        unset($pdfs[$key]);

        // Remover o arquivo do armazenamento (opcional)
        Storage::delete($pdfToRemove);
    }

    // Reindexar o array para evitar problemas ao reconverter para JSON
    $pdfs = array_values($pdfs);

    // Atualizar o post com a nova lista de PDFs
    $post->pdfs = json_encode($pdfs);
    $post->save();

    return response()->json(['message' => 'PDF removido com sucesso!']);
}

public function registerView(Post $post, Request $request)
{
    try {
        $views_count = $this->registerPostView($post->id);
        return response()->json([
            'success' => true,
            'views_count' => $views_count
        ]);
    } catch (\Exception $e) {
        Log::error('Erro ao registrar visualização: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erro ao registrar visualização.'
        ], 500);
    }
}

private function registerPostView($postId)
{
    $userId = Auth::id();
    if ($userId) {
        $viewExists = \DB::table('post_views')
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->exists();

        if (!$viewExists) {
            \DB::table('post_views')->insert([
                'post_id' => $postId,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::debug("Visualização registrada para post $postId por usuário $userId");
        }
    }

    return \DB::table('post_views')
        ->where('post_id', $postId)
        ->count();
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

            notify()->success("Publicação apagada", "Success", "bottomRight");
            return redirect()->route('post.home');
        } catch (\Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }

    public function getViewsCount(Post $post)
    {
        $views_count = \DB::table('post_views')
            ->where('post_id', $post->id)
            ->count();

        return response()->json([
            'views_count' => $views_count
        ]);
    }

    public function getViewers(Post $post)
{
    $viewers = \DB::table('post_views')
        ->join('users', 'post_views.user_id', '=', 'users.id')
        ->where('post_views.post_id', $post->id)
        ->pluck('users.name')
        ->toArray();

    return response()->json([
        'success' => true,
        'viewers' => $viewers
    ]);
}

}