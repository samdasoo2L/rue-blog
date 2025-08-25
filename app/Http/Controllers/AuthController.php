<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nickname' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nickname' => $request->nickname,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', '회원가입이 완료되었습니다!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => '제공된 정보가 일치하지 않습니다.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->scopes(['read:user', 'repo'])->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::where('github_id', $githubUser->id)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email,
                    'nickname' => $githubUser->nickname,
                    'avatar' => $githubUser->avatar,
                    'github_token' => $githubUser->token,
                    'github_id' => $githubUser->id,
                ]);
            } else {
                $user->update([
                    'github_token' => $githubUser->token,
                ]);
            }
            
            Auth::login($user);

            return redirect()->route('home')->with('success', 'GitHub 로그인이 완료되었습니다!');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'GitHub 로그인에 실패했습니다.']);
        }
    }
}
