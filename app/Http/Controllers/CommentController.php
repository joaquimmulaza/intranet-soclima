<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
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

    public function index(){
        //
    }

    public function create(){
        //
    }

    public function store(Request $request, Post $post){
        $this->validate($request, [
            'comment'=>'required'
        ]);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::user()->id;

        $comment->body = $request->comment;

        $comment->save();
        notify()->success("Comentário realizado com sucesso!","Success","bottomRight");
        return redirect()->back();
    }

    public function show(Comment $comment){
        //
    }

    public function edit(Comment $comment){
        //
    }

    public function update(Request $request, Comment $comment){
        //
    }

    public function destroy(Comment $comment){
        //
    }
}
