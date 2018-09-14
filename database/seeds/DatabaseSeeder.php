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

        // $this->call(UserTableSeeder::class);
        DB::table('users')->insert([
            'name'=>'Owden',
            'email'=>'owden@inetstz.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('owden'),
            'remember_token'=>str_random(10)
        ]);

    }
}
