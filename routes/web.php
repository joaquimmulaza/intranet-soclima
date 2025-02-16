<?php

use Illuminate\Support\Facades\Route;
use \App\Mail\correioMail;
use \Illuminate\Support\Facades\Mail;
use \App\Mail\notificationMail;
use \App\Http\Controllers\TelefoneController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\AdminDocumentRequestController;
use App\Http\Controllers\AusenciaController;

/*
|--------------------------------------------------------------------------
| TESTES UNIDADE - Auth::routes();
|--------------------------------------------------------------------------*/
Route::get('/', 'AuthController@index')->name('home');




//HOME E DASHBOARD
/*
|--------------------------------------------------------------------------
| Web Routes - PAINEL ADMINISTRATIVO
|--------------------------------------------------------------------------
|GET|HEAD  | /                      | home           | AuthController@index
|GET|HEAD  | admin                  | admin          | AuthController@dashboard
|GET|HEAD  | admin/login            | admin.login    | AuthController@loginForm
|POST      | admin/login/do         | admin.login.do | AuthController@login
|GET|HEAD  | admin/logout           | admin.logout   | AuthController@logout
*/
Route::get('/', 'AuthController@index')->name('home');
Route::get('/admin', 'AuthController@dashboard')->name('admin');
Route::get('/admin/login', 'AuthController@loginForm')->name('admin.login');
Route::get('/admin/logout', 'AuthController@logout')->name('admin.logout');
Route::post('/admin/login/do', 'AuthController@login')->name('admin.login.do');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');



/*CONFIGURAÇÕES
 *
 * */

Route::get('/configuracoes/', 'ConfigController@show')->name('config.show');
Route::post('/configuracoes/{config}', 'ConfigController@update')->name('config.update');
Route::get('/configuracoes/{config}/editar', 'ConfigController@edit')->name('config.edit');

/*ADMIN QUESTIONARIO*/
Route::get('/enquete/{questionario}', 'QuestionaireController@enqueteADM')->name('admin.enquete');

/*REDIRECIONAMENTO SOCIALITE*/
Route::get('login/facebook', 'AuthController@redirectToProviderFacebook')->name('user.facebook');
Route::get('login/facebook/callback', 'AuthController@handleProviderFacebookCallback');
Route::get('login/github', 'AuthController@redirectToProviderGithub')->name('user.github');
Route::get('login/github/callback', 'AuthController@handleProviderGithubCallback');
Route::get('login/google', 'AuthController@redirectToProviderGoogle')->name('user.google');
Route::get('login/google/callback', 'AuthController@handleProviderGoogleCallback');

/*REGISTRO DE NOVO USUÁRIO POR PEDIDO*/
Route::get('/registro', 'AuthController@registrarUsuario')->name('user.register');
Route::post('/resgitro/novo', 'AuthController@criarNovoUsuario')->name('user.novo');
Route::get('/pedido-novo', 'AuthController@registraPedido')->name('user.pedido');

/*REQUISIÇÕES DE USUÁRIOS*/
Route::get('/requisicoes', 'UserController@pedidos')->name('user.pedidos');
Route::get('/liberar-requisicao/{user}/requisicao', 'UserController@requisicaoUser')->name('user.requisicao');

Route::get('/negar-pedido/{user}', 'UserController@negarPedido')->name('user.negar');

//BOTÃO PARA LIBERAR USUÁRIO --
Route::get('/requisicao-liberada/{user}', 'UserController@liberaPedido')->name('user.liberar');
Route::get('/email', 'UserController@envio')->name('user.email');

//USUÁRIOS
/*
|--------------------------------------------------------------------------
| Web Routes - USUÁRIO
|--------------------------------------------------------------------------
|GET|HEAD  | usuarios               | user.index     | UserController@index
|POST      | usuarios               | user.store     | UserController@store
|GET|HEAD  | usuarios/novo          | user.create    | UserController@create
|GET|HEAD  | usuarios/{user}        | user.show      | UserController@show
|PUT|PATCH | usuarios/{user}        | user.update    | UserController@update
|DELETE    | usuarios/{user}        | user.destroy   | UserController@destroy
|GET|HEAD  | usuarios/{user}/editar | user.edit      | UserController@edit
|GET|HEAD  | registro               | user.register  | UserController@register
|POST      | resgitro/novo          | user.novo      | UserController@createNewUser
*/
Route::resource('usuarios', 'UserController')->names('user')->parameters(['usuarios'=> 'user']);
Route::resource('telefones', 'TelefoneController');
Route::get('/ativador', 'UserController@ativacao')->name('user.ativa');
Route::post('/user/{id}/ativar', 'UserController@ativacao')->name('user.ativar');
Route::resource('telefones', 'TelefoneController');

// Rota para exibir o formulário de edição de um telefone específico
Route::get('/telefones/{telefone}/edit', [TelefoneController::class, 'edit'])->name('telefones.edit');

// Rota para atualizar um telefone no banco de dados
Route::put('/telefones/{telefone}', [TelefoneController::class, 'update'])->name('telefones.update');

// Rota para remover um telefone do banco de dados
Route::delete('/telefones/{telefone}', [TelefoneController::class, 'destroy'])->name('telefones.destroy');


//CATEGORIAS
/*
|--------------------------------------------------------------------------
| Web Routes - CATEGORIAS
|--------------------------------------------------------------------------
|GET|HEAD  | categorias                     | categoria.index   | CategoriaController@index
|POST      | categorias                     | categoria.store   | CategoriaController@store
|GET|HEAD  | categorias/novo                | categoria.create  | CategoriaController@create
|PUT|PATCH | categorias/{categoria}         | categoria.update  | CategoriaController@update
|GET|HEAD  | categorias/{categoria}         | categoria.show    | CategoriaController@show
|DELETE    | categorias/{categoria}         | categoria.destroy | CategoriaController@destroy
|GET|HEAD  | categorias/{categoria}/editar  | categoria.edit    | CategoriaController@edit
*/
Route::resource('categorias', 'CategoriaController')->names('categoria')->parameters(['categorias'=> 'categoria']);

//CARGO
/*
|--------------------------------------------------------------------------
| Web Routes - CARGOS
|--------------------------------------------------------------------------
| GET|HEAD  | cargos                                      | cargo.index          | CargoController@index
| POST      | cargos                                      | cargo.store          | CargoController@store
| GET|HEAD  | cargos/novo                                 | cargo.create         | CargoController@create
| PUT|PATCH | cargos/{cargo}                              | cargo.update         | CargoController@update
| GET|HEAD  | cargos/{cargo}                              | cargo.show           | CargoController@show
| DELETE    | cargos/{cargo}                              | cargo.destroy        | CargoController@destroy
| GET|HEAD  | cargos/{cargo}/editar                       | cargo.edit           | CargoController@edit
*/
Route::resource('cargos', 'CargoController')->names('cargo')->parameters(['cargos'=> 'cargo']);

//UNIDADE
/*
|--------------------------------------------------------------------------
| Web Routes - UNIDADES
|--------------------------------------------------------------------------
| POST      | unidades                                    | unidade.store        | UnidadeController@store
| GET|HEAD  | unidades                                    | unidade.index        | UnidadeController@index
| GET|HEAD  | unidades/novo                               | unidade.create       | UnidadeController@create
| PUT|PATCH | unidades/{unidade}                          | unidade.update       | UnidadeController@update
| DELETE    | unidades/{unidade}                          | unidade.destroy      | UnidadeController@destroy
| GET|HEAD  | unidades/{unidade}                          | unidade.show         | UnidadeController@show
| GET|HEAD  | unidades/{unidade}/editar                   | unidade.edit         | UnidadeController@edit
*/
Route::resource('unidades', 'UnidadeController')->names('unidade')->parameters(['unidades'=> 'unidade']);
Route::get('/ramais', 'UnidadeController@ramais')->name('ramais');
//POSTAGENS
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - POSTAGENS
|---------------------------------------------------------------------------------------------------
| POST      | noticias                      | post.store     | PostController@store
| GET|HEAD  | noticias                      | post.index     | PostController@index
| GET|HEAD  | noticias/novo                 | post.create    | PostController@create
| GET|HEAD  | noticias/{post}               | post.show      | PostController@show
| PUT|PATCH | noticias/{post}               | post.update    | PostController@update
| DELETE    | noticias/{post}               | post.destroy   | PostController@destroy
| GET|HEAD  | noticias/{post}/editar        | post.edit      | PostController@edit
| GET|HEAD  | download/{post}               | post.download  | PostController@download
|POSTAGENS - DOWNLOAD
| GET|HEAD  | todos-postagens               | post.all       | PostController@listPosts
| GET|HEAD  | download/{post}               | post.download  | PostController@download
* */
Route::resource('noticias', 'PostController')->names('post')->parameters(['noticias'=> 'post']);
Route::get('/postagens/all', 'PostController@listPosts')->name('post.all')->prefix('listagemGeral');
Route::get('/download/{post}', 'PostController@download')->name('post.download');
Route::get('/home/noticias', 'PostController@indexAllPages')->name('post.home.noticias');


Route::get('/teste', 'PostController@summernote')->name('post.note');


//COMENTÁRIO
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - COMENTÁRIO
|---------------------------------------------------------------------------------------------------
| POST      | comments/{post}                             | comment.store        | CommentController@store
* */
Route::post('comments/{post}', 'CommentController@store')->name('comment.store');

//LIKES
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - LIKES
|---------------------------------------------------------------------------------------------------
| POST      | like                          | like              | LikeController@postLike
* */
Route::post('/like', 'LikeController@postLike')->name('like');

//QUESTIONARIO
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - QUESTIONARIO
|---------------------------------------------------------------------------------------------------
| POST      | questionarios                               | questionario.store   | \QuestionaireController@store   |
| GET|HEAD  | questionarios                               | questionario.index   | \QuestionaireController@index   |
| GET|HEAD  | questionarios/novo                          | questionario.create  | \QuestionaireController@create  |
| GET|HEAD  | questionarios/{questionario}                | questionario.show    | \QuestionaireController@show    |
| GET|HEAD  | questionarios/{questionario}/editar         | questionario.edit    | \QuestionaireController@edit    |
| PUT|PATCH | questionarios/{questionario}                | questionario.update  | \QuestionaireController@update  |
| DELETE    | questionarios/{questionario}                | questionario.destroy | \QuestionaireController@destroy |
*/
Route::resource('questionarios', 'QuestionaireController')->names('questionario')->parameters(['questionarios'=>'questionario']);
Route::get('/download/{questionario}', 'QuestionaireController@download')->name('questionario.download');
Route::get('/finaliza/{questionario}', 'QuestionaireController@finaliza')->name('questionario.finaliza');
Route::get('/enquetes', 'QuestionaireController@questionariosFinalizados')->name('quest.do.finaliza');
Route::get('/enquetes/{questionario}', 'QuestionaireController@showEnquete')->name('quest.enquete');
//QUESTÕES
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - QUESTÕES
|---------------------------------------------------------------------------------------------------
| POST      | questionarios/{questionario}/questions      | question.criar       | QuestionController@store
| GET|HEAD  | questionarios/{questionario}/questions/novo | question.novo        | QuestionController@create
| DELETE    | questionarios/{questionario}/questions/novo | question.delete        | QuestionController@destroy

| GET|HEAD  | questionarios/{questionario}/editar         | questionario.edit    | \QuestionaireController@edit    |
| PUT|PATCH | questionarios/{questionario}                | questionario.update  | \QuestionaireController@update  |
 * */
Route::post('questionarios/{questionario}/questions', 'QuestionController@store')->name('question.criar');
Route::get('questionarios/{questionario}/questions/novo', 'QuestionController@create')->name('question.novo');
Route::get('questionarios/{questionario}/questao/{question}/edit', 'QuestionController@edit')->name('question.edit');
Route::put('questionarios/{questionario}/questao/{question}', 'QuestionController@update')->name('question.update');

Route::delete('questionarios/{questionario}/deleta/questao/{question}', 'QuestionController@destroy')->name('question.delete');

//DESENVOLVENDO ***********



//SURVEY - PESQUISA
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - SURVEY - PESQUISA
|---------------------------------------------------------------------------------------------------
| GET|HEAD  | surveys/{questionario}                      | survey.show          | SurveyController@show
 * */
Route::get('/surveys/{questionario}', 'SurveyController@show')->name('survey.show');
Route::post('/surveys/{questionario}', 'SurveyController@store')->name('survey.store');

//ROLES
/*
|---------------------------------------------------------------------------------------------------
| Web Routes - ROLES
|---------------------------------------------------------------------------------------------------
| GET|HEAD  | roles                                        | role.index           | RoleController@index
| POST      | roles                                        | role.store           | RoleController@store
| GET|HEAD  | roles/novo                                   | role.create          | RoleController@create
| PUT|PATCH | roles/{role}                                 | role.update          | RoleController@update
| GET|HEAD  | roles/{role}                                 | role.show            | RoleController@show
| DELETE    | roles/{role}                                 | role.destroy         | RoleController@destroy
| GET|HEAD  | roles/{role}/editar                          | role.edit            | RoleController@edit
 * */
Route::resource('/roles', 'RoleController')->names('role')->parameters(['roles'=> 'role']);


/*QUERYS TESTES*/
Route::get('/query-users', 'GraficoController@queryUsers')->name('query.users');
Route::get('/graficos', 'GraficoController@getTodosMeses')->name('grafico.dados');

/*GRAFICOS CHATS.JS * */
Route::get('/geragrafico', 'GraficoController@getMonthlyPostData')->name('grafico.create');
/*TESTES*/
Route::get('/todosmeses', 'GraficoController@getTodosMeses')->name('grafico.meses');
Route::get('/contaPostagensMes', 'GraficoController@getContagemDePostsPorMes')->name('grafico.conta');

/*PDF'S * */
Route::get('pdf-users', 'PDFController@PDFUsuarios')->name('pdf.users');
Route::get('pdf-pedidos', 'PDFController@PDFPedidos')->name('pdf.pedidos');
Route::get('pdf-categorias', 'PDFController@PDFCategorias')->name('pdf.categorias');
Route::get('pdf-cargos', 'PDFController@PDFCargos')->name('pdf.cargos');
Route::get('pdf-unidades', 'PDFController@PDFUnidades')->name('pdf.unidades');
Route::get('pdf-noticias', 'PDFController@PDFNoticias')->name('pdf.noticias');
Route::get('pdf-questionarios', 'PDFController@PDFQuestionarios')->name('pdf.questionarios');

/*EXCEL'S * */
Route::get('excel-users', 'UserController@export')->name('excel.users');
Route::get('excel-pedidos', 'UserController@exportPedidos')->name('excel.pedidos');
Route::get('excel-categorias', 'CategoriaController@export')->name('excel.categorias');
Route::get('excel-cargos', 'CargoController@export')->name('excel.cargos');
Route::get('excel-unidades', 'UnidadeController@export')->name('excel.unidades');
Route::get('excel-noticias', 'PostController@export')->name('excel.noticias');
Route::get('excel-questionarios', 'QuestionaireController@export')->name('excel.questionarios');

/*MARCAR FERIAS*/
// Exibir a view para marcar férias
Route::get('/ferias/marcar', 'FeriaController@create')->name('ferias.marcar');

// Processar o pedido de férias
Route::post('/ferias/marcar', 'FeriaController@store')->name('ferias.store');

// Exibir os pedidos de férias (notificações)
Route::get('/ferias/pedidos', 'FeriaController@pedidos')->name('ferias.pedidos');

// Aprovar pedido de férias
Route::get('/ferias/{id}/aprovar', [FeriaController::class, 'aprovar'])->name('ferias.aprovar');

// Rejeitar pedido de férias
Route::get('/ferias/{id}/rejeitar', [FeriaController::class, 'rejeitar'])->name('ferias.rejeitar');

/*ATRIBUIR FERIAS*/
// Atualizar os dias de férias de um usuário
Route::post('/ferias/updateDias', [FeriaController::class, 'updateDiasFerias'])->name('ferias.updateDias');

// Exibir o formulário de atualização de férias
Route::get('/usuarios/{userId}/ferias', [FeriaController::class, 'showDiasFeriasForm'])
    ->name('users.ferias');



    



Route::get('/test-twilio', [AuthController::class, 'testTwilio'])->name('test.twilio');

//Notificações

Route::middleware('auth')->group(function () {
    // Página de notificações
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notificacoes.index');
    
    // Marcar notificações como vistas
    Route::post('/notificacoes/vista', [NotificationController::class, 'marcarComoVista'])->name('notificacoes.vista');

    // Marcar uma única notificação como lida


    // Marcar todas as notificações como vistas/lidas
    Route::post('/notificacoes/marcar-como-vistas', [NotificationController::class, 'marcarComoVistas'])->name('notificacoes.marcar-todas');

    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware('auth')
     ->name('notifications.markAsRead');
});



Route::post('/test-csrf', function () {
    return response()->json(['success' => true, 'message' => 'CSRF válido']);
});

Route::get('/events', [FeriaController::class, 'getEventos']);
Route::get('/calendar', function () {
    return view('public.calendar');  // Chama a view calendar.blade.php
})->name('public.calendar');

Route::get('/telefones/search', [TelefoneController::class, 'search'])->name('telefones.search');

Route::middleware('auth')->group(function () {
    Route::get('/documents', [AusenciaController::class, 'index'])->name('documents.index');
    Route::post('/documents', [AusenciaController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}', [AusenciaController::class, 'show'])->name('documents.show');
    Route::delete('/ausencias/{id}', [AusenciaController::class, 'destroy'])->name('ausencias.destroy');
    Route::get('baixar/{id}', [AusenciaController::class, 'downloadFile'])->name('downloadFile');
    Route::get('/ausencias/view/{id}', [AusenciaController::class, 'showById'])->name('documents.visualizar');
    Route::put('/ausencias/{id}/aprovar-rejeitar', [AusenciaController::class, 'aprovarRejeitar'])->name('ausencias.aprovarRejeitar');
});


Route::get('/ferias/{id}', [FeriaController::class, 'show'])->name('ferias.show');
Route::get('/documents/show', [DocumentController::class, 'showDocuments'])->name('documents.show');
Route::post('/documents/pedidos', [DocumentRequestController::class, 'store'])->name('document-request.store');
Route::get('/documents/pedidos', [DocumentRequestController::class, 'create'])->name('document-request.create');
Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

Route::get('/contas-suspensas', [UserController::class, 'mostrarContasSuspensas'])->name('contas.suspensas');

Route::middleware(['auth'])->group(function () {
    Route::get('/document-request', [DocumentRequestController::class, 'index'])->name('document-request.index');
});

Route::middleware(['auth',])->group(function () {
    Route::get('/admin/document-request', [AdminDocumentRequestController::class, 'index'])->name('document-request.index');
    Route::post('/admin/document-request/{id}/upload', [AdminDocumentRequestController::class, 'uploadDocument'])->name('admin.document-request.upload');
    Route::post('/admin/document-request/{id}/complete', [AdminDocumentRequestController::class, 'markAsComplete'])->name('document-request.complete');
});