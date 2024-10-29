<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class LikeController extends Controller
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

    public function postLike(Request $request)
{
    Log::debug($request->all());
    try {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';

        $post = Post::find($post_id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post não encontrado.']);
        }

        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();

        if ($like && !$is_like) {
            // Remove a curtida
            $like->delete();
            Log::debug("Curtida removida para o post ID: $post_id");
        } elseif (!$like && $is_like) {
            // Cria uma nova curtida
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $like->like = true;
            $like->save();
            Log::debug("Curtida adicionada para o post ID: $post_id");
        }

        // Atualiza a contagem de likes
        $likes_count = likes_post($post_id);
        return response()->json(['success' => true, 'likes_count' => $likes_count]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro ao processar a curtida.']);
    }
}

}
