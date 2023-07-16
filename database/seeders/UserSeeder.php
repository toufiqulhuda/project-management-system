<?php

namespace Database\Seeders;



use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Md. Toufiqul Huda',
            'email' => 'tuloncse@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Secret123'), // password
            'type' => 1,
            'isactive' => 1,
            'created_by' => 1,
            'created_by_ip' => request()->ip(),

//            'remember_token' => Str::random(10),
        ]);
    }
//    function ipShow(Request $request)
//    {
//        return $request->ip();
//    }
}
