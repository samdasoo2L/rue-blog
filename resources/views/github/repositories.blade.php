@extends('layouts.app')

@section('title', 'GitHub 레포지토리 - RUE Blog')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">GitHub 레포지토리</h1>
    <p class="mt-2 text-gray-600">{{ auth()->user()->nickname }}님의 GitHub 레포지토리 목록입니다. (프라이빗 레포지토리 포함)</p>
    
    @php
        $publicCount = collect($repositories)->where('private', false)->count();
        $privateCount = collect($repositories)->where('private', true)->count();
        $totalCount = count($repositories);
    @endphp
    
    <div class="mt-4 flex items-center space-x-4 text-sm">
        <span class="flex items-center">
            <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
            퍼블릭: {{ $publicCount }}개
        </span>
        <span class="flex items-center">
            <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
            프라이빗: {{ $privateCount }}개
        </span>
        <span class="flex items-center text-gray-600">
            <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
            전체: {{ $totalCount }}개
        </span>
    </div>
</div>

<div class="grid gap-6">
    @forelse($repositories as $repo)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="{{ $repo['html_url'] }}" target="_blank" class="hover:text-blue-600">
                            <i class="fab fa-github mr-2"></i>{{ $repo['name'] }}
                        </a>
                    </h3>
                    
                    @if($repo['description'])
                        <p class="text-gray-600 mb-4">{{ $repo['description'] }}</p>
                    @endif
                    
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        @if($repo['language'])
                            <span class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                                {{ $repo['language'] }}
                            </span>
                        @endif
                        
                        <span class="flex items-center">
                            <i class="fas fa-star mr-1"></i>
                            {{ number_format($repo['stargazers_count']) }}
                        </span>
                        
                        <span class="flex items-center">
                            <i class="fas fa-code-branch mr-1"></i>
                            {{ number_format($repo['forks_count']) }}
                        </span>
                        
                        <span class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            {{ number_format($repo['watchers_count']) }}
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-col items-end space-y-2">
                    @if($repo['fork'])
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Fork
                        </span>
                    @endif
                    
                    @if($repo['private'])
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Private
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Public
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>생성일: {{ \Carbon\Carbon::parse($repo['created_at'])->format('Y년 m월 d일') }}</span>
                <span>마지막 업데이트: {{ \Carbon\Carbon::parse($repo['updated_at'])->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <i class="fab fa-github text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">레포지토리가 없습니다</h3>
            <p class="text-gray-600">GitHub에 레포지토리를 생성해보세요!</p>
        </div>
    @endforelse
</div>

<div class="mt-8 text-center">
    <a href="https://github.com/{{ auth()->user()->nickname }}" target="_blank" 
       class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
        <i class="fab fa-github mr-2"></i>
        GitHub 프로필 보기
    </a>
</div>
@endsection
