<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $topics = Topic::all();

        foreach ($topics as $topic) {
            for ($i = 0; $i < 2; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'topic_id' => $topic->id,
                    'body' => "This is a comment for topic $topic->id.",
                ]);
            }
        }
    }
}