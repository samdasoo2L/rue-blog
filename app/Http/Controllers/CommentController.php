<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post)->with('success', '댓글이 작성되었습니다!');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $comment->post)->with('success', '댓글이 수정되었습니다!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $post = $comment->post;
        $comment->delete();
        
        return redirect()->route('posts.show', $post)->with('success', '댓글이 삭제되었습니다!');
    }
}
