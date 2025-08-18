<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RUE Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- 네비게이션 -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                        RUE Blog
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isGithubUser())
                        <a href="{{ route('github.repositories') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fab fa-github mr-1"></i>GitHub
                        </a>
                        @endif
                    @endauth
                    
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">게시글</a>
                    <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900">사용자</a>
                    
                    @auth
                        <div class="relative profile-button">
                            <button class="flex items-center text-gray-600 hover:text-gray-900">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}" 
                                     alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                                {{ auth()->user()->nickname }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50
                                        profile-dropdown opacity-0 invisible scale-95
                                        transition-all duration-300 ease-in-out transform origin-top">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-2"></i>프로필
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i>로그아웃
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">로그인</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">회원가입</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 메인 콘텐츠 -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- 푸터 -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 RUE Blog. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.querySelector('.profile-button');
        const dropdownMenu = document.querySelector('.profile-dropdown');
        let timeoutId;

        if (profileButton && dropdownMenu) {
            // 마우스가 프로필 버튼에 들어왔을 때
            profileButton.addEventListener('mouseenter', function() {
                clearTimeout(timeoutId);
                dropdownMenu.classList.remove('opacity-0', 'invisible', 'scale-95');
                dropdownMenu.classList.add('opacity-100', 'visible', 'scale-100');
            });

            // 마우스가 프로필 버튼을 벗어났을 때
            profileButton.addEventListener('mouseleave', function() {
                timeoutId = setTimeout(() => {
                    dropdownMenu.classList.remove('opacity-100', 'visible', 'scale-100');
                    dropdownMenu.classList.add('opacity-0', 'invisible', 'scale-95');
                }, 500); // 500ms 지연 (0.5초)
            });

            // 마우스가 드롭다운 메뉴에 들어왔을 때
            dropdownMenu.addEventListener('mouseenter', function() {
                clearTimeout(timeoutId);
            });

            // 마우스가 드롭다운 메뉴를 벗어났을 때
            dropdownMenu.addEventListener('mouseleave', function() {
                timeoutId = setTimeout(() => {
                    dropdownMenu.classList.remove('opacity-100', 'visible', 'scale-100');
                    dropdownMenu.classList.add('opacity-0', 'invisible', 'scale-95');
                }, 500); // 500ms 지연 (0.5초)
            });
        }
    });
    </script>
</body>
</html>
