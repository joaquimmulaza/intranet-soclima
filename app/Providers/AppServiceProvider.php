<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Classes\Chartjs\Chart; // Importa a classe Chartjs// Importa a classe Chart

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
        // Cria uma instância do gráfico Chartjs
        $chart = new Chart('sampleChart');

        // Configura o gráfico
        $chart->labels(['Label 1', 'Label 2', 'Label 3']);
        $chart->dataset('Sample Dataset', 'line', [1, 2, 3]);

        // Se precisar registrar o gráfico, pode ser feito aqui
        // Note que você deve ter a classe Charts disponível para isso
        // Charts::register([$chart]);

        Route::resourceVerbs([
            'create' => 'novo',
            'edit' => 'editar'
        ]);

        // Custom blade directive for role check
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->role->slug == $role;
        });
    }
}
