<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'permission_name' => 'user_management',
                'description' => 'Quản lý quyền người dùng',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
