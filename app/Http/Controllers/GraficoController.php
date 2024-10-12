<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Post;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \GuzzleHttp\json_decode;

class GraficoController extends Controller
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

    //Grafico Dashboard
    function getTodosMeses()
    {
        $month_array = array();
        $posts_dates = Post::orderBy('created_at', 'DESC')->pluck('created_at');

        $posts_dates = json_decode($posts_dates);

        if( ! empty( $posts_dates ) ){
            foreach($posts_dates as $unformatted_date){
                $date = new \DateTime($unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;

    }

    function getContagemDePostsPorMes(){
        $monthly_post_count = Post::whereMonth('created_at', 3)->get()->count();
        return $monthly_post_count;
    }



    function getMonthlyPostData() {

        /*ANOTAÇÕES: TOTAL DE USUARIOS POR CARGO -----------------------------*/

        $sqlCargos = "SELECT c.titulo, COUNT(u.cargo_id) AS total FROM users u INNER JOIN cargos c ON u.cargo_id = c.id GROUP BY c.titulo";

        $cargos_array = DB::select($sqlCargos);

        $cargo_array = array();
        $todos_array = array();

        if(!empty($cargos_array)){
            foreach($cargos_array as $array){
                array_push( $cargo_array, $array->titulo );
                array_push( $todos_array, $array->total );
            }
        }
        $max_cargos = max( $todos_array );

        /*response[2]*/
        $cargo_data_array = array(
            'cargos' => $cargo_array,
            'users' => $todos_array,
            'maximo' => $max_cargos,
        );


        /*ANOTAÇÕES: TOTAL DE USUARIOS POR UNIDADE -----------------------------*/

        $sqlUnidades = "SELECT c.titulo, COUNT(u.unidade_id) AS total FROM users u INNER JOIN unidades c ON u.unidade_id = c.id GROUP BY c.titulo";

        $unidades_array = DB::select($sqlUnidades);

        $unidade_array = array();
        $todos_array = array();

        if(!empty($unidades_array)){
            foreach($unidades_array as $array){
                array_push( $unidade_array, $array->titulo );
                array_push( $todos_array, $array->total );
            }
        }
        $max_unidades = max( $todos_array );

        /*response[3]*/
        $unidade_data_array = array(
            'unidades' => $unidade_array,
            'users' => $todos_array,
            'maximo' => $max_unidades,
        );

        /*ANOTAÇÕES: TOTAL DE NOTICIAS POR USUARIO -----------------------------*/

        $sql = "SELECT u.name, COUNT(p.user_id) AS totalPosts FROM posts p INNER JOIN users u ON u.id = p.user_id GROUP BY u.name ORDER BY totalPosts ASC";

        $users_posts_array = DB::select($sql);

        $users_array = array();
        $posts_array = array();

        if ( ! empty( $users_posts_array ) ) {
            foreach ( $users_posts_array as $result ){
                array_push( $users_array, $result->name );
                array_push( $posts_array, $result->totalPosts );
            }
        }
        $max_posts = max( $posts_array );

        /*response[1]*/
        $data_array = array(
            'usuario' => $users_array,
            'posts' => $posts_array,
            'total' => $max_posts,
        );

        /*ANOTAÇÕES: TOTAL DE LIKES POR DATA -----------------------------*/

        $sql = "SELECT DATE_FORMAT(l.created_at, '%m/%y') AS data, COUNT(l.like) AS total FROM likes l WHERE l.like = 1 GROUP BY DATA ASC";

        $sql_likes_array = DB::select($sql);

        $data_likes_array = array();
        $data_curt_array = array();

        if ( ! empty( $sql_likes_array ) ) {
            foreach ( $sql_likes_array as $result ){
                array_push( $data_likes_array, $result->data );
                array_push( $data_curt_array, $result->total );
            }

            $to_max = array_sum($data_curt_array);
        }

        /*response[4]*/
        $data_por_likes_array = array(
            'data' => $data_likes_array,
            'total' => $data_curt_array,
            'max' => $to_max,
        );










        /* -------------------------------------------*/
        /*TOTAL DE LIKES -----------------------------*/

        $sqlPosts = "SELECT DATE_FORMAT(p.created_at, '%m/%y') AS mes, COUNT(p.id) AS news FROM posts p GROUP BY mes ORDER BY YEAR(p.created_at) DESC";

        $contagem_array = DB::select($sqlPosts);

        $mes_array = array();
        $news_array = array();


        if(!empty($contagem_array)){
            foreach($contagem_array as $array){
                array_push( $mes_array, $array->mes);
                array_push( $news_array, $array->news);
            }

            $tot_max = array_sum($news_array);
        }


        $monthly_post_data_array = array(
            'months' => $mes_array,
            'post_count_data' => $news_array,
            'max' => $tot_max,
        );



        //RETORNO FINAL ------------------------------------------
        return [$monthly_post_data_array, $data_array, $cargo_data_array, $unidade_data_array, $data_por_likes_array];

    }



    //TESTES
    public function queryUsers(){
        $date = new DateTime();
        $tempo = $date->getTimestamp();

        $noticias = DB::table('posts')->orderBy('view', 'DESC')->get();
        $media = DB::table('posts')->avg('view');
        $min = DB::table('posts')->min('view');
        $max = DB::table('posts')->max('view');
        $totalPosts = DB::table('posts')->count();
        $allPosts = [
            'TODAS NOTICIAS ORDENADAS POR VIEW'=>$noticias,
            'MEDIA DE VALORES'=> $media,
            'MINIMO DE VALOR'=> $min,
            'MAXIMO DE VALOR'=> $max,
            'TOTAL DE POSTAGENS'=> $totalPosts
        ];

        $users = User::where('created_at', '>=', date('y-m-d').' 00:00:00')
            ->where('created_at', '<=', date('y-m-d'). ' 23:00:00')
            ->get();

        //$users = User::whereDate('created_at', '>=', now()->subDay(60))->get();

        //$users = User::where('created_at', '>=', today())->get();

        $users = User::whereYear('created_at', '>=', now()->year)
            ->whereMonth('created_at', now()->month)
            ->get();

        $cargo = DB::table('cargos')->where('id', '=', 2)->get();
        $cargos = Cargo::whereYear('created_at', '>=', now()->year)

            ->get();

        return $cargos;
    }
    public function dados(){

        $sql = "SELECT c.titulo,
                COUNT(u.cargo_id) AS total
                FROM users u
                INNER JOIN cargos c ON u.cargo_id = c.id
                GROUP BY c.titulo";

        $results = DB::select($sql);
        $cargos = count($results);
        //RETORNO DOS DADOS NO NAVEGADOR: http://localhost:8977/graficos
        return [$results, $cargos];
    }

    /*
     *

        $monthly_post_count_array = array();

        //TODOS MESES
        $month_array = $this->getTodosMeses();

        $month_name_array = array();
        if ( ! empty( $month_array ) ) {
            foreach ( $month_array as $month_no => $month_name ){
                $monthly_post_count = $this->getContagemDePostsPorMes( $month_no );
                array_push( $monthly_post_count_array, $monthly_post_count );
                array_push( $month_name_array, $month_name );
            }
        }

        $max_no = max( $monthly_post_count_array );

        //$max = round(( $max_no + 10/2 ) / 10 ) * 10;
     *
     * */
}
