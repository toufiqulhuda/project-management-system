<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Supper Admin',
                'description' => 'Can monitor',
                'isactive' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'role_name' => 'Admin',
                'description' => 'Admin can monitor client task',
                'isactive' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'role_name' => 'Client',
                'description' => 'Who order the work',
                'isactive' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
            [
                'role_name' => 'Employee',
                'description' => 'Can delivered the works',
                'isactive' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'created_by_ip' => request()->ip(),
            ],
        ]);
    }
}
