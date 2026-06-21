<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [];

        $userData = [
            ['name' => 'テストユーザー1', 'username' => 'user1', 'email' => 'user1@example.com'],
            ['name' => 'テストユーザー2', 'username' => 'user2', 'email' => 'user2@example.com'],
            ['name' => 'テストユーザー3', 'username' => 'user3', 'email' => 'user3@example.com'],
        ];

        foreach ($userData as $data) {
            $users[] = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'bio' => 'これはテストアカウントです。',
            ]);
        }

        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                Post::create([
                    'user_id' => $user->id,
                    'content' => "{$user->name}の投稿 #{$i} #テスト",
                ]);
            }
        }

        $posts = Post::all();
        foreach ($users as $user) {
            foreach ($posts->random(5) as $post) {
                Like::firstOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }

            foreach ($posts->random(3) as $post) {
                Comment::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'content' => "{$user->name}からのコメントです！",
                ]);
            }
        }

        $users[0]->following()->attach($users[1]->id);
        $users[0]->following()->attach($users[2]->id);
        $users[1]->following()->attach($users[0]->id);
    }
}
