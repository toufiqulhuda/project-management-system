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
            [
                'name' => 'Md. Toufiqul Huda',
                'email' => 'tuloncse@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Secret123'), // password
                'type' => 1,
                'isactive' => 1,
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Secret123'), // password
                'type' => 2,
                'isactive' => 1,
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Secret123'), // password
                'type' => 3,
                'isactive' => 1,
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'name' => 'employee',
                'email' => 'employee@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Secret123'), // password
                'type' => 4,
                'isactive' => 1,
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ]

        ]);
    }

}
