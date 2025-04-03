<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\CommentLike;
use App\CommentReply;
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
            ->with(['user:id,name,avatar', 'likes', 'replies.user:id,name,avatar'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($comments);
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return response()->json($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment->body = $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comentário atualizado com sucesso!',
            'comment' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comentário excluído com sucesso!'
        ]);
    }

    public function like(Comment $comment)
{
    $user = Auth::user();
    
    if ($comment->isLikedBy($user)) {
        // Se o usuário já deu like, vamos remover
        $comment->likes()->where('user_id', $user->id)->delete();
        $message = 'Like removido com sucesso!';
        $likedByUser = false;
    } else {
        // Se o usuário ainda não deu like, vamos adicionar
        $comment->likes()->create([
            'user_id' => $user->id,
            'like' => true
        ]);
        $message = 'Comentário curtido com sucesso!';
        $likedByUser = true;
    }
    
    // Retorna a contagem atual de likes e o estado do like para o usuário
    return response()->json([
        'success' => true,
        'message' => $message,
        'likes_count' => $comment->likes()->count(),
        'liked_by_user' => $likedByUser
    ]);
}

public function likeReply(CommentReply $commentReply)
{
    $user = Auth::user();
    $like = $commentReply->likes()->where('user_id', $user->id)->first();

    if ($like) {
        // Remove o like existente
        $like->delete();
        $message = 'Like removido com sucesso!';
        $likedByUser = false;
    } else {
        // Adiciona um novo like
        $commentReply->likes()->create([
            'user_id' => $user->id,
            'like' => true
        ]);
        $message = 'Resposta curtida com sucesso!';
        $likedByUser = true;
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'likes_count' => $commentReply->likes()->count(),
        'liked_by_user' => $likedByUser
    ]);
}
    


    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply' => 'required|string|max:1000'
        ]);

        $reply = new CommentReply();
        $reply->body = $request->reply;
        $reply->user_id = auth()->id();
        $reply->comment_id = $comment->id;
        $reply->save();

        return response()->json([
            'success' => true,
            'message' => 'Resposta adicionada com sucesso!',
            'reply' => $reply->load('user:id,name,avatar')
        ]);
    }
}
