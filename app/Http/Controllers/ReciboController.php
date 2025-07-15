<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReciboController extends Controller
{
    public function index()
    {
        return view('recibos.index'); // Certifique-se que essa view existe
    }
}
