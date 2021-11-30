<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        //ユーザーデータを10件作成、かつ作成したユーザーデータを使ってブログデータを2〜5件作成する
        User::factory(10)->create()->each(function ($user) {
            //$user->idは$userに省略が可能
            Blog::factory(random_int(2, 5))->create(['user_id' => $user->id])->each(function ($blog) {
                //blogデータを使ってcommentデータを1~3件を作成する
                Comment::factory(random_int(1, 3))->create(['blog_id' => $blog]);
            });
        });
    }
}
