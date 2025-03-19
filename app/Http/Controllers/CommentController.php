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

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = new Comment();
        $comment->body = $request->comment;
        $comment->post_id = $post->id;
        $comment->user_id = auth()->id();
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comentário adicionado com sucesso!'
        ]);
    }

    public function show(Post $post)
    {
        $comments = $post->comments()
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($comments);
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
