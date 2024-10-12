<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Categoria;
use App\Post;
use App\Questionaire;
use App\Unidade;
use App\User;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
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

    public function PDFUsuarios(){
        $users = User::where('status', '=', 'ativo')->get();

        $pdf = PDF::loadView('pdf.pdf_users', compact('users'));
        return $pdf->setPaper('a4')->stream('Lista_de_usuários.pdf');
    }

    public function PDFPedidos(){
        $users = User::where('status', '=', 'inativo')->get();

        $pdf = PDF::loadView('pdf.pdf_pedidos', compact('users'));
        return $pdf->setPaper('a4')->stream('Lista_de_pedidos.pdf');
    }

    public function PDFCategorias(){
        $cats = Categoria::all();

        $pdf = PDF::loadView('pdf.pdf_categorias', compact('cats'));
        return $pdf->setPaper('a4')->stream('Lista_de_categorias.pdf');
    }

    public function PDFCargos(){
        $cargos = Cargo::all();

        $pdf = PDF::loadView('pdf.pdf_cargos', compact('cargos'));
        return $pdf->setPaper('a4')->stream('Lista_de_cargos.pdf');
    }

    public function PDFUnidades(){
        $unidades = Unidade::all();

        $pdf = PDF::loadView('pdf.pdf_unidades', compact('unidades'));
        return $pdf->setPaper('a4')->stream('Lista_de_unidades.pdf');
    }

    public function PDFNoticias(){
        $posts = Post::all();

        $pdf = PDF::loadView('pdf.pdf_noticias', compact('posts'));
        return $pdf->setPaper('a4')->stream('Lista_de_noticias.pdf');
    }

    public function PDFQuestionarios(){
        $questionarios = Questionaire::all();

        $pdf = PDF::loadView('pdf.pdf_questionarios', compact('questionarios'));
        return $pdf->setPaper('a4')->stream('Lista_de_questionarios.pdf');
    }
}
