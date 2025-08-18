@extends('layouts.app')

@section('title', $post->title . ' - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- 게시글 헤더 -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . $post->user->name }}" 
                         alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                    <a href="{{ route('users.show', $post->user) }}" class="hover:text-blue-600">
                        {{ $post->user->nickname }}
                    </a>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->format('Y년 m월 d일 H:i') }}</span>
                    @if($post->updated_at != $post->created_at)
                        <span class="mx-2">•</span>
                        <span>수정됨 {{ $post->updated_at->format('Y년 m월 d일 H:i') }}</span>
                    @endif
                </div>
            </div>
            
            @can('update', $post)
                <div class="flex space-x-2">
                    <a href="{{ route('posts.edit', $post) }}" 
                       class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        수정
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                onclick="return confirm('정말로 이 게시글을 삭제하시겠습니까?')">
                            삭제
                        </button>
                    </form>
                </div>
            @endcan
        </div>
        
        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>
        
        <!-- 좋아요 버튼 -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <form method="POST" action="{{ route('posts.like', $post) }}" class="inline">
                @csrf
                <button type="submit" 
                        class="flex items-center space-x-2 px-4 py-2 {{ auth()->check() && auth()->user()->hasLiked($post) ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700' }} rounded-full hover:bg-red-500 hover:text-white transition-colors">
                    <i class="fas fa-heart"></i>
                    <span>{{ $post->likes_count }} 좋아요</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 댓글 섹션 -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">
            댓글 ({{ $post->comments->count() }})
        </h3>
        
        @auth
            <!-- 댓글 작성 폼 -->
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="댓글을 작성하세요..."></textarea>
                </div>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    댓글 작성
                </button>
            </form>
        @else
            <div class="mb-6 p-4 bg-gray-50 rounded-md text-center">
                <p class="text-gray-600">댓글을 작성하려면 <a href="{{ route('login') }}" class="text-blue-600 hover:underline">로그인</a>이 필요합니다.</p>
            </div>
        @endauth
        
        <!-- 댓글 목록 -->
        <div class="space-y-4">
            @forelse($post->comments as $comment)
                <div class="border-l-4 border-gray-200 pl-4 py-2">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . $comment->user->name }}" 
                                     alt="Avatar" class="w-6 h-6 rounded-full mr-2">
                                <a href="{{ route('users.show', $comment->user) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $comment->user->nickname }}
                                </a>
                                @if($comment->isAuthor())
                                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">작성자</span>
                                @endif
                                <span class="ml-2 text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-gray-700">
                                {!! nl2br(e($comment->content)) !!}
                            </div>
                        </div>
                        
                        @can('update', $comment)
                            <div class="flex space-x-2 ml-4">
                                <a href="{{ route('comments.edit', $comment) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">수정</a>
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('정말로 이 댓글을 삭제하시겠습니까?')">
                                        삭제
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-comments text-4xl mb-4"></i>
                    <p>아직 댓글이 없습니다.</p>
                    <p class="text-sm">첫 번째 댓글을 작성해보세요!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
