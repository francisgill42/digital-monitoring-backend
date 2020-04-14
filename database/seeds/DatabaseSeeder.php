<?php

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
        // $this->call(UsersTableSeeder::class);
        	$user = \App\User::create([
        	'name' => 'master',
        	'email' => 'master@erp.com',
        	'password' => bcrypt('secret'),
        	'master' => 1
        ]);
        $user->createToken('myApp')->accessToken; 


    }
}
