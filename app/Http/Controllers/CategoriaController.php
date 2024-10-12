<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Exports\CategoriasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoriaController extends Controller
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

    private $categoria;

    public function __construct(Categoria $categoria){
        $this->categoria = $categoria;
    }

    public function index()
    {
        $categorias = Categoria::orderBy('id', 'ASC')->paginate(10);
        return view('categoria.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        try{
            $categoria = new Categoria();
            $categoria->titulo = $request->titulo;
            $categoria->descricao = $request->descricao;
            $categoria->save();

            notify()->success("Categoria criada com sucesso!","Success","bottomRight");
            return redirect()->route('categoria.index');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar criar a categoria!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('categoria.create');
    }

    public function update(Request $request, Categoria $categoria)
    {
        try{
            $categoria->titulo = $request->titulo;
            $categoria->descricao = $request->descricao;
            $categoria->save();

            notify()->success("Categoria editada com sucesso!","Success","bottomRight");
            return redirect()->route('categoria.index');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar editar a categoria!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function show(Categoria $categoria)
    {
        return view('categoria.show', ['categoria'=> $categoria]);
    }

    public function destroy(Categoria $categoria)
    {
        try{
            $categoria->delete();
            notify()->success("Categoria excluida com sucesso!","Success","bottomRight");
            return redirect()->route('categoria.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar excluir a categoria!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function edit(Categoria $categoria)
    {
        return view('categoria.create', ['categoria'=> $categoria]);
    }

    public function export(){
        return Excel::download(new CategoriasExport, 'Lista_categorias.xlsx');
    }
}
