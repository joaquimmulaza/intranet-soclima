<?php

namespace App\Http\Controllers;

use App\Exports\UnidadesExport;
use App\Unidade;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UnidadeController extends Controller
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

    private $unidade;

    public function __construct(Unidade $unidade){
        $this->unidade = $unidade;
    }

    public function index()
    {
        $unidades = Unidade::orderBy('id', 'ASC')->paginate(5);
        return view('unidade.index', compact('unidades'));
    }

    public function create()
    {
        $users = User::all();
        return view('unidade.create', compact('users'));
    }

    public function store(Request $request)
    {
        try{
            $unidade = new Unidade();
            $unidade->titulo = $request->titulo;
            $unidade->descricao = $request->descricao;
            // $unidade->ramal = $request->ramal;
            $unidade->save();

            if($request->has('responsaveis')){
                $unidade->responsaveis()->sync($request->responsaveis);
            }

            notify()->success("Departamento criada com sucesso!","Success","bottomRight");
            return redirect()->route('unidade.index');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar criar a unidade!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function show(Unidade $unidade)
    {
        return view('unidade.show', ['unidade'=> $unidade]);
    }

    public function edit($id)
    {
        $unidade = Unidade::with('responsaveis')->findOrFail($id); // Busca a unidade pelo ID
        $users = User::all(); // Obtém todos os usuários

        return view('unidade.create', compact('unidade', 'users')); 
    }

    public function ramais()
    {
        $users = User::all();
        $units = Unidade::all();
        return view('public.ramais', compact('users', 'units'));
    }

    public function update(Request $request, Unidade $unidade)
    {
        try{
            $unidade->titulo = $request->titulo;
            $unidade->descricao = $request->descricao;
            // $unidade->ramal = $request->ramal;
            $unidade->save();

            if($request->has('responsaveis')){
                $unidade->responsaveis()->sync($request->responsaveis);
            }

            notify()->success("Departamento editada com sucesso!","Success","bottomRight");
            return redirect()->route('unidade.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar editar a unidade!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function destroy(Unidade $unidade)
    {
        try{
            $unidade->delete();
            notify()->success("Departamento excluida com sucesso!","Success","bottomRight");
            return redirect()->route('unidade.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar excluir o departamento!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function export(){
        return Excel::download(new UnidadesExport, 'Lista_unidades.xlsx');
    }
}
