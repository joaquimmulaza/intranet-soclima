<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        try{
            $post_id = $request['postId'];

            $is_like = $request['isLike'] === 'true';
            $update = false;
            $post = Post::find($post_id);

            if (!$post) {
                return null;
            }

            $user = Auth::user();
            $like = $user->likes()->where('post_id', $post_id)->first();
                if ($like) {
                    $already_like = $like->like;
                    $update = true;
                    if ($already_like == $is_like) {
                        $like->delete();
                        return null;
                    }
                } else {
                    $like = new Like();
                }
            $like->like = $is_like;
            $like->user_id = $user->id;
            $like->post_id = $post->id;
                if ($update) {
                    $like->update();
                } else {
                    $like->save();
                }
            return null;
        }catch (\Exception $e){
            if(env('APP_DEBUG')){
                flash($e->getMessage())->warning();
                return redirect()->back();
            }
            notify()->error("Ocorreu um erro ao tentar realizar like/deslike!","Error","bottomRight");
            return redirect()->back();
        }
    }

}
