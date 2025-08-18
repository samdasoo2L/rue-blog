<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function repositories()
    {
        $user = Auth::user();
        
        if (!$user->isGithubUser()) {
            return redirect()->route('profile')->withErrors(['error' => 'GitHub 계정으로 로그인한 사용자만 이용할 수 있습니다.']);
        }

        try {
            // 사용자의 모든 레포지토리 (프라이빗 포함) 가져오기
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $user->github_token,
                'Accept' => 'application/vnd.github.v3+json',
            ])->get("https://api.github.com/user/repos", [
                'type' => 'all',        // all: public, private, internal 모두
                'sort' => 'updated',     // 최근 업데이트순
                'per_page' => 100,      // 한 번에 가져올 레포지토리 수
            ]);

            if ($response->successful()) {
                $repositories = $response->json();
                return view('github.repositories', compact('repositories'));
            } else {
                \Log::error('GitHub API 호출 실패: ' . $response->status() . ' - ' . $response->body());
                return redirect()->route('profile')->withErrors(['error' => 'GitHub API 호출에 실패했습니다. (상태: ' . $response->status() . ')']);
            }
        } catch (\Exception $e) {
            \Log::error('GitHub 레포지토리 조회 실패: ' . $e->getMessage());
            return redirect()->route('profile')->withErrors(['error' => 'GitHub 정보를 가져오는데 실패했습니다.']);
        }
    }
}
