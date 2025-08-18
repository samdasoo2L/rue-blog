@extends('layouts.app')

@section('title', '홈 - RUE Blog')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">최신 게시글</h1>
    
    <!-- 검색 폼 -->
    <div class="mb-6">
        <form action="{{ route('posts.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="제목, 내용, 작성자로 검색..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search mr-2"></i>검색
            </button>
            @if(request('search'))
                <a href="{{ route('posts.index') }}" 
                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>초기화
                </a>
            @endif
        </form>
    </div>
    
    @auth
        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>새 게시글 작성
        </a>
    @endauth
</div>

<!-- 검색 결과 정보 -->
@if(request('search'))
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-blue-800">
            <i class="fas fa-search mr-2"></i>
            <strong>"{{ request('search') }}"</strong> 검색 결과: <strong>{{ $posts->total() }}</strong>개의 게시글
        </p>
    </div>
@endif

<div class="grid gap-6">
    @forelse($posts as $post)
        <article class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h2>
                    
                    <div class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit($post->content, 200) }}
                    </div>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . $post->user->name }}" 
                                     alt="Avatar" class="w-6 h-6 rounded-full mr-2">
                                <a href="{{ route('users.show', $post->user) }}" class="hover:text-blue-600">
                                    {{ $post->user->nickname }}
                                </a>
                            </div>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-comment mr-1"></i>
                                {{ $post->comments->count() }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-heart mr-1"></i>
                                {{ $post->likes_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="text-center py-12">
            @if(request('search'))
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">검색 결과가 없습니다</h3>
                <p class="text-gray-600 mb-4">"{{ request('search') }}"에 대한 검색 결과를 찾을 수 없습니다.</p>
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 underline">
                    모든 게시글 보기
                </a>
            @else
                <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">아직 게시글이 없습니다</h3>
                <p class="text-gray-600">첫 번째 게시글을 작성해보세요!</p>
            @endif
        </div>
    @endforelse
</div>

@if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->appends(request()->query())->links() }}
    </div>
@endif
@endsection
