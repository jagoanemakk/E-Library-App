<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('table_buku')->insert([
            'user_id' => 1,
            'nama_buku' => 'Malioboro At Midnight',
            'author' => 'Skysphire',
            'deskripsi' => 'Novel perjalanan hidup',
            'status_buku' => 'Ada'
        ]);
        DB::table('table_buku')->insert([
            'user_id' => 1,
            'nama_buku' => 'Angsa dan kelelawar',
            'author' => 'Keigo Higashi',
            'deskripsi' => 'Kisah Misteri yang Dramatis',
            'status_buku' => 'Ada'
        ]);
        DB::table('table_buku')->insert([
            'user_id' => 1,
            'nama_buku' => 'KKN di Desa Penari',
            'author' => 'Simpleman',
            'deskripsi' => 'novel horor yang dialihwahanakan dari sebuah utas Twitter yang viral.',
            'status_buku' => 'Ada'
        ]);
    }
}
