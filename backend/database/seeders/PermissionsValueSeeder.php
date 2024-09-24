<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = DB::table('permissions')->where('permission_name', 'user_management')->first();

        DB::table('permissions_values')->insert([
            [
                'permissions_id' => $permission->id,
                'value' => 'admin_role',
                'description' => 'Vai trò quản trị Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permissions_id' => $permission->id,
                'value' => 'client_role',
                'description' => 'Vai trò khách hàng Client',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
