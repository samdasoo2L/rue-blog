@extends('layouts.app')

@section('title', '댓글 수정 - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">댓글 수정</h1>
        <p class="mt-2 text-gray-600">댓글을 수정해보세요.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('comments.update', $comment) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    댓글 내용
                </label>
                <textarea id="content" name="content" rows="6" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="댓글 내용을 입력하세요">{{ old('content', $comment->content) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('posts.show', $comment->post) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    취소
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    댓글 수정
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
