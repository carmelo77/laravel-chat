<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
        	'name' => 'usuario 1',
        	'username' => 'user1',
        	'password' => \Hash::make(123456),
            'image' => 'https://robohash.org/quiaistesit.png?size=50x50&set=set1'
        ]);

        DB::table('users')->insert([
            'name' => 'usuario 2',
            'username' => 'user2',
            'password' => \Hash::make(123456),
            'image' => 'https://robohash.org/laboriosamteneturet.png?size=50x50&set=set1'
        ]);

        DB::table('users')->insert([
            'name' => 'usuario 3',
            'username' => 'user3',
            'password' => \Hash::make(123456),
            'image' => 'https://robohash.org/sitrerumullam.jpg?size=50x50&set=set1'
        ]);

        DB::table('users')->insert([
            'name' => 'usuario 4',
            'username' => 'user4',
            'password' => \Hash::make(123456),
            'image' => 'https://robohash.org/aliquidimpeditvelit.jpg?size=50x50&set=set1'
        ]);

        DB::table('users')->insert([
            'name' => 'usuario 5',
            'username' => 'user5',
            'password' => \Hash::make(123456),
            'image' => 'https://robohash.org/quouteligendi.bmp?size=50x50&set=set1'
        ]);
    }
}
