<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'password' => Hash::make('iamadmin'),
                'role_id' => '1'
            ],
            [
                'name' => 'user1',
                'password' => Hash::make('iamuser'),
                'role_id' => '2'
            ],
        ]);

        DB::table('roles')->insert([
            [
                'id'=> 1,
                'name' => 'admin',
            ],
            [
                'id'=> 2,
                'name' => 'user',
            ],
        ]);

        DB::table('films')->insert([
            [
                'title' => 'Encanto',
                'thumbnail' => 'https://i.ibb.co/d0k7B6r/011185900-1633506834-Disney-s-Encanto-1-web.webp',
                'status_id' => '1'
            ],
            [
                'title' => 'Spider-Man: No Way Home',
                'thumbnail' => 'https://i.ibb.co/WzwV55y/poster-film-spiderman-no-way-home-20211108172602-web.webp',
                'status_id' => '1'
            ],
            [
                'title' => 'Aquaman and the Lost Kingdom',
                'thumbnail' => 'https://i.ibb.co/GJY6Frv/w6tisn-UMZFk2f2-BQa-Hu7-On-UGkgb-web.webp',
                'status_id' => '2'
            ],
            [
                'title' => 'LightYear',
                'thumbnail' => 'https://i.ibb.co/VTWhqWM/uhdpaper-com-download-phone-hd-wallpaper-119-1-e.jpg',
                'status_id' => '2'
            ],

        ]);

        DB::table('statuses')->insert([
            [
                'id'=> 1,
                'name' => 'Now Playing',
            ],
            [
                'id'=> 2,
                'name' => 'Coming Soon',
            ],

        ]);

        DB::table('user_film')->insert([
            [
                'user_id'=> 1,
                'film_id'=> 1,
                'favorite'=> true,
                'rating'=>5
            ],
            [
                'user_id'=> 1,
                'film_id'=> 2,
                'favorite'=> true,
                'rating'=>5
            ],
            [
                'user_id'=> 2,
                'film_id'=> 2,
                'favorite'=> true,
                'rating'=>5
            ],

        ]);
    }
}
