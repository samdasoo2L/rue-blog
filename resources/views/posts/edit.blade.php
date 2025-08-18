@extends('layouts.app')

@section('title', '게시글 수정 - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">게시글 수정</h1>
        <p class="mt-2 text-gray-600">게시글을 수정해보세요.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    제목
                </label>
                <input type="text" id="title" name="title" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="게시글 제목을 입력하세요" value="{{ old('title', $post->title) }}">
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    내용
                </label>
                <textarea id="content" name="content" rows="12" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="게시글 내용을 입력하세요">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('posts.show', $post) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    취소
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    게시글 수정
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
