@extends('layouts.app')

@section('title', $user->nickname . ' - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- 사용자 정보 -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" 
                     alt="Avatar" class="w-24 h-24 rounded-full">
            </div>
            
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-lg text-gray-600">{{ $user->nickname }}</p>
                @if($user->isGithubUser())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <i class="fab fa-github mr-1"></i>GitHub 사용자
                    </span>
                @endif
                
                @if($user->bio)
                    <p class="text-gray-700 mt-4">{{ $user->bio }}</p>
                @endif
                
                <div class="text-sm text-gray-500 mt-4">
                    <p>가입일: {{ $user->created_at->format('Y년 m월 d일') }}</p>
                    <p>게시글 수: {{ $posts->total() }}개</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 게시글 목록 -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $user->nickname }}님의 게시글</h2>
        
        @if($posts->count() > 0)
            <div class="space-y-4">
                @foreach($posts as $post)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <h3 class="font-medium text-gray-900 mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <div class="text-gray-600 mb-2 line-clamp-2">
                            {{ Str::limit($post->content, 150) }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $post->created_at->format('Y년 m월 d일') }}</span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="fas fa-comment mr-1"></i>
                                {{ $post->comments->count() }}
                            </span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="fas fa-heart mr-1"></i>
                                {{ $post->likes_count }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-file-alt text-4xl mb-4"></i>
                <p>아직 작성한 게시글이 없습니다.</p>
            </div>
        @endif
    </div>
</div>
@endsection
