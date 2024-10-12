<?php

namespace App\Http\Controllers;

use App\Questionaire;
use App\User;
use App\Exports\QuestionariosExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class QuestionaireController extends Controller
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

    private  $quest;

    public function __construct(Questionaire $quest){
        $this->quest = $quest;
    }

    public function index(){
        $questionarios = Questionaire::all();
        $questionarios->load('questions.answers');
        return view('questionario.index', compact('questionarios'));
    }

    public function questionariosFinalizados(){
        $dataHoje = Carbon::now();
        $questionarios = Questionaire::where('status', '=', 'Finalizado')
            ->where('validate_at', '>=', $dataHoje->toDateString())
            ->get();
        $questionarios->load('questions.answers');
        return view('public.questionario', compact('questionarios'));
    }

    public function showEnquete(Questionaire $questionario){
        $questionario->view++;
        $questionario->save();
        return view('public.questionarioShow', compact('questionario'));
    }

    public function enqueteADM(Questionaire $questionario){

        $questionario->load('questions.answers.responses');
        return view('questionario.admin.enquetes', compact('questionario'));
    }

    public function create(){
        return view('questionario.create');
    }

    public function store(Request $request)
    {
        try{

            $questionario = new Questionaire();

            $questionario->title = $request->titulo;
            $questionario->content = $request->conteudo;
            $questionario->validate_at = $request->validate;
            $questionario->user_id = Auth::user()->id;
            $questionario->status = 'Aberto';
            //dd(Auth::user());


            if(!$request->file('arquivo') == null){
                //dd('TESTE');
                $avatar = $request->file('arquivo');
                //salva imagem no storage/capa_posts = _97064624624298.JPG
                $filename = "_" . time() . '.' . $avatar->getClientOriginalExtension();
                //salva o mesmo arquivo + "capa_posts/" PARA ter o caminho correto no banco = capa_posts/_97064624624298.JPG
                $savefile = "capa_quest/" . $filename;

                Image::make($avatar)->resize(781, 521)->save(public_path('storage/capa_quest/' . $filename));
                //if($noticia->capa !== 'capa_default.jpg'){
                //File::delete(public_path('storage/capa_posts/' . $noticia->capa));
                //}
                $questionario->capa =  $savefile;
            }
            //dd($questionario->capa);
            $questionario->save();

            notify()->success("Questionário criado com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.index');

        }catch (\Exception $e){
            if(env('APP_DEBUG')){

                notify()->error("Ocorreu um erro ao tentar criar um questionário!","Error","bottomRight");
                return redirect()->back();
            }
        }
    }

    public function show(Questionaire $questionario){
        $questionario->load('questions.answers.responses');
        return view('questionario.show', compact('questionario'));
    }

    public function edit(Questionaire $questionario){
        $questionario->load('questions.answers');
        return view('questionario.create', compact('questionario'));
    }

    public function update(Request $request, Questionaire $questionario){
        try{
            $questionario->title = $request->titulo;
            $questionario->content = $request->conteudo;
            $questionario->validate_at = $request->validate;

            if(!$request->file('arquivo') == null){
                $avatar = $request->file('arquivo');
                $filename = "_" . time() . '.' . $avatar->getClientOriginalExtension();
                $savefile = "capa_quest/" . $filename;

                if($questionario->capa != 'capa_quest/capa_default.jpg'){
                    File::delete(public_path('storage/' . $questionario->capa));
                }
                Image::make($avatar)->resize(781, 521)->save(public_path('storage/capa_quest/' . $filename));
                $questionario->capa =  $savefile;
            }

            $questionario->save();

            notify()->success("Questionário editado com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.index');

        }catch(\Exception $e){
            if(env('APP_DEBUG')){

                notify()->error("Ocorreu um erro ao tentar editar um questionário!","Error","bottomRight");
                return redirect()->back();
            }
        }
    }

    public function destroy(Questionaire $questionario){
        try{
            $questionario->load('questions.answers');

            if($questionario->capa != 'capa_quest/capa_default.jpg'){
                File::delete(public_path('storage/' . $questionario->capa));
            }

            $questionario->delete();

            notify()->success("Questionário criado com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.index');
        }catch(\Exception $e){
            if(env('APP_DEBUG')){
                notify()->error("Ocorreu um erro ao tentar excluir um questionário!","Error","bottomRight");
                return redirect()->back();
            }
        }
    }

    public function download(Questionaire $questionario){
        $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($questionario->capa);
        return response()->download($path);
    }

    public function export(){
        return Excel::download(new QuestionariosExport, 'Lista_questionarios.xlsx');
    }

    public function finaliza(Questionaire $questionario){
        $questionario->status = "Finalizado";
        $questionario->save();
        return redirect()->route('questionario.index');
    }
}
