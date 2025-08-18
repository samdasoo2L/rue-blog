<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('posts')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $posts = $user->posts()->latest()->paginate(10);
        return view('users.show', compact('user', 'posts'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('users.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname,' . $user->id,
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'bio' => $request->bio,
        ]);

        return redirect()->route('profile')->with('success', '프로필이 수정되었습니다!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', '비밀번호가 변경되었습니다!');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        
        // 사용자와 관련된 모든 데이터 삭제 (cascade 설정으로 자동 처리)
        $user->delete();
        
        // 로그아웃 처리
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', '계정이 성공적으로 삭제되었습니다. 이용해주셔서 감사합니다.');
    }
}
