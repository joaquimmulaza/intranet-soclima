<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Post;
use App\PostImage;
use App\Questionaire;
use App\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NoticiasExport;

class PostController extends Controller
{

    /*Annotation: --------------------------------------------------------------
    |1.
    |2.
    |3.
    |4.
    |5.
    |6.
    |7.
    |8.
    |9.
    |10.
    |--------------------------------------------------------------------------*/

    private $post;

    public function __construct(Post $post){
        $this->$post = $post;
    }

    public function index(){
        $posts = Post::all();

        //$posts = Post::where('validate_at', '>=', now())->get();
        return view('public.home', compact('posts'));
    }

    public function indexAllPages(Request $request){

        if(Auth::check() === true && Auth::user()->status == "ativo"){
            $posts = Post::all();
            $post = collect($posts)->last();

            $dataHoje = Carbon::now();

            $posts = Post::where('id', '!=', $post->id)
                ->where('validate_at', '>=', $dataHoje->toDateString())
                ->orderBy('id', 'DESC')
                ->get();

            $questionarios = Questionaire::where('status', '=', 'Finalizado')
                ->where('validate_at', '>=', $dataHoje->toDateString())
                ->orderBy('id', 'DESC')
                ->get();


            return view('public.pageAll', compact('posts', 'post', 'questionarios'));
        }
        return redirect()->route('admin.login');
    }


    public function listPosts(){
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function summernote(){
        return view('post.summer');
    }

    public function create(){
        $categorias = Categoria::all();
        return view('post.create', compact('categorias'));
    }

    public function store(Request $request){
        try{
            $noticia = new Post();
            $noticia->title = $request->title;
            $noticia->content = $request->conteudo;
            $noticia->subtitle = $request->subtitle;
            $noticia->resumo = $request->resumo;
            $noticia->slug = Str::slug($request->title, '-');
            $noticia->validate_at = $request->validate;
            $noticia->ativo = 1;



            /*if(!$request->file('arquivo') == null){
                $path = $request->file('arquivo')->store('capa_posts', 'public');
                dd($path);
                $noticia->capa = $path;
            }*/

            if(!$request->file('arquivo') == null){
                $avatar = $request->file('arquivo');
                //salva imagem no storage/capa_posts = _97064624624298.JPG
                $filename = "_" . time() . '.' . $avatar->getClientOriginalExtension();
                //salva o mesmo arquivo + "capa_posts/" PARA ter o caminho correto no banco = capa_posts/_97064624624298.JPG
                $savefile = "capa_posts/" . $filename;
                Image::make($avatar)->resize(781, 521)->save(public_path('storage/capa_posts/' . $filename));
                //if($noticia->capa !== 'capa_default.jpg'){
                    //File::delete(public_path('storage/capa_posts/' . $noticia->capa));
                //}
                $noticia->capa =  $savefile;
            }

            $user = User::find(Auth::user()->id);
            $user->posts()->save($noticia);

            $categorias = Categoria::find($request->cat);
            $noticia->categorias()->sync($categorias);

            notify()->success("Noticia criada com sucesso!","Success","bottomRight");
            return redirect()->route('home');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar criar uma notícia!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function show(Post $post){
        $dataHoje = Carbon::now();

        $posts = Post::where('id', '!=', $post->id)
            ->where('validate_at', '>=', $dataHoje->toDateString())
            ->orderBy('id', 'DESC')
            ->paginate(3);

        $post->view++;
        $post->save();
        return view('public.show', ['post'=>$post, 'posts'=>$posts]);
    }

    public function edit(Post $post){
        $categorias = Categoria::all();
        return view('post.create', compact('post', 'categorias'));
    }

    public function update(Request $request, Post $post){
        try{
            $post->title = $request->title;
            $post->content = $request->conteudo;
            $post->subtitle = $request->subtitle;
            $post->resumo = $request->resumo;
            $post->slug = Str::slug($request->title, '-');
            $post->ativo = 1;
            $post->validate_at = $request->validate;

            if(!$request->file('arquivo') == null){
                $avatar = $request->file('arquivo');
                $filename = "_" . time() . '.' . $avatar->getClientOriginalExtension();
                $savefile = "capa_posts/" . $filename;

                if($post->capa != 'capa_posts/capa_default.jpg'){
                    File::delete(public_path('storage/' . $post->capa));
                }
                Image::make($avatar)->resize(781, 521)->save(public_path('storage/capa_posts/' . $filename));
                $post->capa =  $savefile;
            }

            $user = User::find($post->user->id);
            $user->posts()->save($post);

            $categorias = Categoria::find($request->cat);
            $post->categorias()->sync($categorias);

            notify()->success("Notícia editada com sucesso!","Success","bottomRight");
            return redirect()->route('post.show', compact('post'));

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar editar uma notícia!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function destroy(Post $post){

        try{
            $post->load('comments', 'likes');
            if($post->capa != 'capa_posts/capa_default.jpg'){
                File::delete(public_path('storage/' . $post->capa));
            }
            $post->delete();

            notify()->success("Notícia excluida com sucesso!","Success","bottomRight");
            return redirect()->route('post.all');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar excluir uma notícia!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function download(Post $post){
        $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($post->capa);
        return response()->download($path);
    }

    public function export(){
        return \Maatwebsite\Excel\Facades\Excel::download(new NoticiasExport, 'Lista_noticias.xlsx');
    }
}
