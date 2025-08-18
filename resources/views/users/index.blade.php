@extends('layouts.app')

@section('title', '사용자 목록 - RUE Blog')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">사용자 목록</h1>
    <p class="mt-2 text-gray-600">가입한 모든 사용자를 확인할 수 있습니다.</p>
</div>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    @forelse($users as $user)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4 mb-4">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name }}" 
                     alt="Avatar" class="w-16 h-16 rounded-full">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <a href="{{ route('users.show', $user) }}" class="hover:text-blue-600">
                            {{ $user->name }}
                        </a>
                    </h3>
                    <p class="text-gray-600">{{ $user->nickname }}</p>
                    @if($user->isGithubUser())
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fab fa-github mr-1"></i>GitHub
                        </span>
                    @endif
                </div>
            </div>
            
            @if($user->bio)
                <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ Str::limit($user->bio, 50) }}</p>
            @endif
            
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>게시글 {{ $user->posts_count }}개</span>
                <span>{{ $user->created_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">사용자가 없습니다</h3>
            <p class="text-gray-600">첫 번째 사용자가 가입해보세요!</p>
        </div>
    @endforelse
</div>

@if($users->hasPages())
    <div class="mt-8">
        {{ $users->links() }}
    </div>
@endif
@endsection
