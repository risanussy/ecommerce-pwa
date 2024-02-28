<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'role' => 'admin',
            'nik' => 'admin',
            'alamat' => 'root',
            'no_hp' => '089509589977',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert data kedua
        DB::table('users')->insert([
            'name' => 'Kepala Koperasi',
            'role' => 'manager',
            'nik' => 'manager',
            'alamat' => 'root',
            'no_hp' => '089509589977',
            'email' => 'manager@test.com',
            'password' => bcrypt('manager1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}