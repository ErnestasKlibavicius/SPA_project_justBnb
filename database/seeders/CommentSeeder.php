<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function(User $user) {
            $comment = Comment::factory()->make(); 
            $bookable = Bookable::findOrFail(random_int(1, 100));
            $comment->user_id = $user->id;
            $comment->bookable_id = $bookable->id;

            $user->comment()->save($comment);
        });
    }
}
