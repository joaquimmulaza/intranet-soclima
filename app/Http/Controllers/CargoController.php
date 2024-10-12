<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Exports\CargosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CargoController extends Controller
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

    private $cargo;

    public function __construct(Cargo $cargo){
        $this->cargo = $cargo;
    }

    public function index()
    {
        $cargos = Cargo::orderBy('id', 'ASC')->paginate(5);
        return view('cargo.index', compact('cargos'));
    }


    public function create()
    {
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        try{
            $cargo = new Cargo();
            $cargo->titulo = $request->titulo;
            $cargo->atividades = $request->atividades;
            $cargo->save();

            notify()->success("Cargo criado com sucesso!","Success","bottomRight");
            return redirect()->route('cargo.index');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar criar o cargo!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function show(Cargo $cargo)
    {
        return view('cargo.show', ['cargo'=> $cargo]);
    }

    public function edit(Cargo $cargo)
    {
        return view('cargo.create', ['cargo'=> $cargo]);
    }

    public function update(Request $request, Cargo $cargo)
    {
        try{
            $cargo->titulo = $request->titulo;
            $cargo->atividades = $request->atividades;

            $cargo->save();

            notify()->success("Cargo editado com sucesso!","Success","bottomRight");
            return redirect()->route('cargo.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao editar excluir o cargo!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function destroy(Cargo $cargo)
    {
        try{
            $cargo->delete();
            notify()->success("Cargo excluido com sucesso!","Success","bottomRight");
            return redirect()->route('cargo.index');
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar excluir o cargo!","Error","bottomRight");
            return redirect()->back();
        }
    }

    public function export(){
        return Excel::download(new CargosExport, 'Lista_cargos.xlsx');
    }
}
