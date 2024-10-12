<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    public function show(Config $config)
    {
        $config = Config::where('id', '=', 1)->get();
        return view('admin.painel.config', compact('config'));
    }

    public function edit(Config $config)
    {
        dd('edit');
    }

    public function update(Request $request, Config $config)
    {
        dd('update');
    }
}
