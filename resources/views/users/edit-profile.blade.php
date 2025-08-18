@extends('layouts.app')

@section('title', '프로필 수정 - RUE Blog')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">프로필 수정</h1>
        <p class="mt-2 text-gray-600">프로필 정보를 수정해보세요.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">기본 정보</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        이름
                    </label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('name', $user->name) }}">
                </div>

                <div>
                    <label for="nickname" class="block text-sm font-medium text-gray-700 mb-2">
                        닉네임
                    </label>
                    <input type="text" id="nickname" name="nickname" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('nickname', $user->nickname) }}">
                </div>
            </div>

            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    자기소개
                </label>
                <textarea id="bio" name="bio" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="자기소개를 입력하세요">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    프로필 수정
                </button>
            </div>
        </form>
    </div>

        @if(!auth()->user()->isGithubUser())
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">비밀번호 변경</h2>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        현재 비밀번호
                    </label>
                    <input type="password" id="current_password" name="current_password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        새 비밀번호
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    새 비밀번호 확인
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    비밀번호 변경
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-4">
            <i class="fab fa-github mr-2"></i>GitHub 계정
        </h2>
        <p class="text-blue-800">
            GitHub로 로그인한 계정은 비밀번호 변경이 불가능합니다. 
            비밀번호를 변경하려면 GitHub 계정 설정에서 변경하세요.
        </p>
    </div>
    @endif

    <!-- 계정 탈퇴 섹션 -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-red-900 mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>계정 탈퇴
        </h2>
        <p class="text-red-800 mb-4">
            계정을 탈퇴하면 모든 데이터가 영구적으로 삭제되며 복구할 수 없습니다.
            신중하게 결정해주세요.
        </p>
        
        @if(!auth()->user()->isGithubUser())
        <button type="button" 
                onclick="showDeleteModal()"
                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
            <i class="fas fa-trash mr-2"></i>계정 탈퇴
        </button>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-yellow-800 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                GitHub로 로그인한 계정은 이 페이지에서 탈퇴할 수 없습니다. 
                GitHub 계정 설정에서 연동을 해제하거나 GitHub 계정 자체를 삭제해주세요.
            </p>
        </div>
        @endif
    </div>
</div>

<!-- 탈퇴 확인 모달 -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">계정 탈퇴 확인</h3>
            <div class="text-sm text-gray-500 mb-6 text-left">
                <p class="mb-2">계정을 탈퇴하면 다음 데이터가 <strong>영구적으로 삭제</strong>됩니다:</p>
                <ul class="list-disc list-inside space-y-1 text-red-600">
                    <li>프로필 정보</li>
                    <li>작성한 모든 게시글</li>
                    <li>작성한 모든 댓글</li>
                    <li>좋아요 기록</li>
                </ul>
                <p class="mt-3 text-gray-600">이 작업은 되돌릴 수 없습니다.</p>
            </div>
            
            <form method="POST" action="{{ route('profile.delete') }}" id="deleteForm">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2 text-left">
                        계정 탈퇴를 위해 비밀번호를 입력하세요
                    </label>
                    <input type="password" id="delete_password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="현재 비밀번호">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="hideDeleteModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        취소
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>계정 탈퇴
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('delete_password').focus();
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteForm').reset();
}

// 모달 외부 클릭 시 닫기
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});

// ESC 키로 모달 닫기
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
    }
});
</script>
@endsection
