<?php

namespace App\Http\Controllers;

use App\Questionaire;
use App\Survey;
use App\SurveyResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SurveyController extends Controller
{

    /*Annotation: --------------------------------------------------------------
    |1.store: FINALIZA QUESTIONARIO REALIZADO PELO USUÁRIO
    |2.show: ABRE QUESTIONARIO
    |3.
    |4.
    |5.
    |6.
    |7.
    |8.
    |9.
    |10.
    |--------------------------------------------------------------------------*/

    public function store(Request $request, Questionaire $questionario)
    {
        try{
            /*$request->responses
                = array:[2]
                  => array:2 [0]
                        "answer_id" => "9"
                        "quest_id" => "9"
                  ]
                  => array:2 [1]
                        "quest_id" => "11"
                        "answer_id" => "18"
                  ]

         * $request->responses[0]
                        "answer_id" => "9"
                        "quest_id" => "9"
         *
         * $request->responses[0]['answer_id']
         * $request->responses[0]['quest_id']
         *
         * */
            //dd(request());

            $data = request()->validate([
                'responses.*.answer_id' => 'required',
                'responses.*.question_id' => 'required',
            ]);

            //dd($data['responses'][0]);

            $survey = new Survey();

            $survey->nome = Auth::user()->name;
            $survey->email = Auth::user()->email;
            //$survey->questionaire_id = $questionario->id;

            //$survey->save();
            //
            $survey = $questionario->surveys()->save($survey);
            //dd($survey);
            //$resposta = new SurveyResponse();

            //$resposta->question_id = $request->responses[0]['quest_id'];
            //dd($resposta->question_id);
            $survey->responses()->createMany($data['responses']);
            //$survey->responses()->attach($data);
            $questionario->respondidas++;
            $questionario->save();

            notify()->success("obrigado por participar!","Success","bottomRight");
            return redirect()->route('home');
        }catch(\Exception $e){
            if(env('APP_DEBUG')){
                notify()->error("Ocorreu um erro na pesquisa!!","Error","bottomRight");
                return redirect()->back();
            }
        }

    }

    public function show(Questionaire $questionario)
    {
        if(Auth::user() != null) {
            $pesquisa = Survey::where('questionaire_id', $questionario->id)->get();

            $filtro = $pesquisa->whereIn('email', Auth::user()->email);

            if ($filtro->count() == 0) {
                //LAZY LOAD
                $questionario->load('questions.answers');
                return view('pesquisa.show', compact('questionario'));
            }

            notify()->warning("Desculpe, pesquisa ja respondida!", "Warning", "bottomRight");
            return view('questionario.show', compact('questionario'));
        }else{
            return redirect()->route('home');
        }

    }

}
