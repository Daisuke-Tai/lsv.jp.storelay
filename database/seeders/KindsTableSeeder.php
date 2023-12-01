<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KindsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')->first(); // ★

        $titles = ['プライベート', '仕事', '旅行'];

        foreach ($titles as $title) {
            DB::table('kinds')->insert([
                'title' => $title,
                'user_id' => $user->id, // ★
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
