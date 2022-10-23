<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(BookablesTableSeeder::class);
       $this->call(BookingsTableSeeder::class);
       $this->call(ReviewsTableSeeder::class);
       $this->call(UsersTableSeeder::class);
       $this->call(CommentSeeder::class);
    }
}
