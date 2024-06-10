<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run()
    {
        $users = User::all();

        for ($i = 0; $i < 5; $i++) {
            Topic::create([
                'user_id' => $users->random()->id,
                'title' => "Topic Title $i",
                'body' => "This is the body of topic $i.",
            ]);
        }
    }
}
