<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use App\User;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    public function handler(Request $request): Chartisan
    {
        $users = User::all();


        return Chartisan::build()
                ->labels(['First', 'Second', 'Third'])
                ->dataset('Sample', [1, 2, 3])
                ->dataset('Sample 2', [3, 2, 1]);
    }


    public function getSoma(Request $request){
        $month_array = array();
        $posts_dates = Post::orderBy('created_at', 'ASC')->pluck('created_at');
        $posts_dates = json_decode($posts_dates);

        foreach($posts_dates as $key => $date){
            $name_array[$key] = $date->name;
        }

        return $name_array;

    }
}