<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("users_status")->insert([
            [
                "name" => "Hoạt dộng"
            ],
            [
                "name" => "Tạm khoá"
            ]
        ]);
    }
}
