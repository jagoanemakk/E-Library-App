<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama' => 'pendik',
            'email' => 'jagoanemakk1234@gmail.com',
            'hak_akses' => 'Super Admin',
            'password' => Hash::make('12345'),
        ]);
        DB::table('users')->insert([
            'nama' => 'alfin',
            'email' => 'alfianzah123@gmail.com',
            'hak_akses' => 'Admin',
            'password' => Hash::make('12345'),
        ]);
        DB::table('users')->insert([
            'nama' => 'kuncara',
            'email' => 'jkuncara123@gmail.com',
            'hak_akses' => 'Member',
            'password' => Hash::make('12345'),
        ]);
    }
}
