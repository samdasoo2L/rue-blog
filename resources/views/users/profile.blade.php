@extends('layouts.app')

@section('title', '프로필 - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" 
                     alt="Avatar" class="w-24 h-24 rounded-full">
            </div>
            
            <div class="flex-1">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-lg text-gray-600">{{ $user->nickname }}</p>
                        @if($user->isGithubUser())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fab fa-github mr-1"></i>GitHub 사용자
                            </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        프로필 수정
                    </a>
                </div>
                
                @if($user->bio)
                    <p class="text-gray-700 mb-4">{{ $user->bio }}</p>
                @endif
                
                <div class="text-sm text-gray-500">
                    <p>가입일: {{ $user->created_at->format('Y년 m월 d일') }}</p>
                    <p>게시글 수: {{ $user->posts->count() }}개</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 내 게시글 -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">내 게시글</h2>
        
        @if($user->posts->count() > 0)
            <div class="space-y-4">
                @foreach($user->posts->take(5) as $post)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <h3 class="font-medium text-gray-900 mb-1">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h3>
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
                
                @if($user->posts->count() > 5)
                    <div class="text-center pt-4">
                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800">
                            모든 게시글 보기 →
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-file-alt text-4xl mb-4"></i>
                <p>아직 작성한 게시글이 없습니다.</p>
                <a href="{{ route('posts.create') }}" class="text-blue-600 hover:text-blue-800">
                    첫 번째 게시글 작성하기
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
