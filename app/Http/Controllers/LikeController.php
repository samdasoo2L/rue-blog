<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $message = '좋아요가 취소되었습니다.';
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
            $message = '좋아요가 추가되었습니다.';
        }

        return back()->with('success', $message);
    }
}
