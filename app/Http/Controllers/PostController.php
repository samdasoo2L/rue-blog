<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Post::withUser()->withComments();
        
        // 검색어가 있는 경우 검색 조건 추가
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nickname', 'like', "%{$search}%");
                  });
            });
        }
        
        $posts = $query->latest()->paginate(10)->withQueryString();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        function generateUniqueSlug($title) {
            $slug = Str::slug($title);
            $originalSlug = $slug;
            $count = 1;
        
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        
            return $slug;
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'slug' => generateUniqueSlug($request->title),
        ]);

        return redirect()->route('posts.show', $post)->with('success', '게시글이 작성되었습니다!');
    }

    public function show(Post $post)
    {
        // Post $post – 라우트 모델 바인딩
        // 라라벨은 URL에서 넘어온 {post} 파라미터를 자동으로 Post 모델의 인스턴스로 변환해줍니다.
        // 예: /posts/3 요청이 오면, $post = Post::findOrFail(3)과 같은 효과.
        // 이걸 **라우트 모델 바인딩**이라고 합니다.

        // Eager Loading
        // 데이터베이스에서 데이터를 가져올 때, 관련된 데이터도 함께 가져오는 기능
        // 예: $post->load(['user', 'comments.user']);
        // 이걸 **Eager Loading**이라고 합니다.

        $post->load(['user', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $post)->with('success', '게시글이 수정되었습니다!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();
        return redirect()->route('posts.index')->with('success', '게시글이 삭제되었습니다!');
    }
}
