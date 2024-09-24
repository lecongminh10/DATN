<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get the permission for user management
        $permission = DB::table('permissions')->where('permission_name', 'user_management')->first();

        // Create permission values if they don't exist
        $permissionValues = [
            ['value' => 'admin_role', 'description' => 'Vai trò quản trị Admin'],
            ['value' => 'client_role', 'description' => 'Vai trò khách hàng Client']
        ];

        foreach ($permissionValues as $value) {
            DB::table('permissions_values')->updateOrInsert(
                ['value' => $value['value'], 'permissions_id' => $permission->id],
                ['description' => $value['description'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Get the permission values
        $adminRole = DB::table('permissions_values')->where('value', 'admin_role')->first();
        $clientRole = DB::table('permissions_values')->where('value', 'client_role')->first();

        // Create the admin user
        $adminUserId = DB::table('users')->insertGetId([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Hashed password 
            'language' => 'en',
            'currency' => 'USD',
            'loyalty_points' => 0,
            'created_by' => null, // Admin is the first user, so no created_by
            'is_verified' => true,
            'profile_picture' => null,
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'phone_number' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Associate permission values with the admin user
        DB::table('permissions_value_users')->insert([
            ['permission_value_id' => $adminRole->id, 'user_id' => $adminUserId, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
