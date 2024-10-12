<?php

namespace App\Http\Controllers;

use App\Question;
use App\Questionaire;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /*Annotation: --------------------------------------------------------------
    |1.create: ENVIA FORMULARIO PARA CRIAR QUESTÃO
    |2.store: SALVA QUESTÃO CRIADA
    |3.destroy: DELETA QUESTÃO
    |4.
    |5.
    |6.
    |7.
    |8.
    |9.
    |10.
    |--------------------------------------------------------------------------*/

    public function create(Questionaire $questionario)
    {
        return view('questao.create', compact('questionario'));
    }

    public function store(Request $request, Questionaire $questionario)
    {
        try{
            $data = request()->validate([
                'question.question' => 'required',
                'answers.*.answer' => 'required',
            ]);

            $question = $questionario->questions()->create($data['question']);
            $question->answers()->createMany($data['answers']);

            notify()->success("Questão criada com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.show', compact('questionario'));
        }catch(\Exception $e){
            if(env('APP_DEBUG')){
                notify()->error("Ocorreu um erro ao tentar criar uma questão!","Error","bottomRight");
                return redirect()->back();
            }
        }



    }

    public function destroy(Questionaire $questionario, Question $question)
    {
        try{
            $question->answers()->delete();
            $question->delete();

            notify()->success("Excluida com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.show', compact('questionario'));
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                notify()->error("Ocorreu um erro ao excluir!","Error","bottomRight");
                return redirect()->back();
            }
        }
    }

    public function edit(Questionaire $questionario, Question $question){

        $question->load('answers');
        return view('questao.create', compact('questionario', 'question'));
    }

    public function update(Request $request, Questionaire $questionario, Question $question)
    {
        try{

            $data = request()->validate([
                'question.question' => 'required',
                'answers.*.answer' => 'required',
            ]);

            /* ACESSO PELA REQUEST
            $request->question['question']
            $request['answers'][0]['answer']
            */

            foreach($request->answers as $i => $answ){
                $question['answers'][$i]['answer'] = $answ['answer'];
            }

            $question['question'] = $request->question['question'];
            $question->answers()->delete();
            $question->answers()->createMany($data['answers']);
            $question->load('answers');
            $question->save();

            $questionario->save();

            notify()->success("Questão atualizada com sucesso!","Success","bottomRight");
            return redirect()->route('questionario.show', compact('questionario'));

        }catch(\Exception $e){
            if(env('APP_DEBUG')){
                notify()->error("Ocorreu um erro ao tentar criar uma questão!","Error","bottomRight");
                return redirect()->back();
            }
        }



    }
}
