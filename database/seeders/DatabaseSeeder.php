<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 사용자 생성
        $users = User::factory(10)->create();
        
        // GitHub 사용자 생성
        User::factory(3)->github()->create();
        
        // 게시글 생성
        $posts = Post::factory(20)->create();
        
        // 댓글 생성
        foreach ($posts as $post) {
            Comment::factory(rand(0, 5))->create(['post_id' => $post->id]);
        }
        
        // 좋아요 생성
        foreach ($posts as $post) {
            $likeCount = rand(0, 8);
            $randomUsers = $users->random(min($likeCount, $users->count()));
            
            foreach ($randomUsers as $user) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
