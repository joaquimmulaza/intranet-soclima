<?php

namespace App\Http\Controllers;

use App\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
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

    private $endereco;

    public function __construct(Endereco $endereco){
        $this->endereco = $endereco;
    }

    public function index()
    {
        $enderecos = $this->endereco->paginate(5);
        return view('endereco.index', compact('enderecos'));
    }


    public function show(Endereco $endereco)
    {
        $user = $endereco->user()->first();
        return view('endereco.show', ['endereco' => $endereco], ['user'=> $user]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Endereco $endereco)
    {
        //
    }

    public function update(Request $request, Endereco $endereco)
    {
        //
    }

    public function destroy(Endereco $endereco)
    {
        //
    }
}
