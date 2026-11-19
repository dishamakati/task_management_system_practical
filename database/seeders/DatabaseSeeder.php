<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = [
            'admin',
            'team_leader',
            'employee',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }
        
        //Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
            ]
        );

        $admin->assignRole('admin');

        // Team Leader User
        $teamLeader = User::firstOrCreate(
            ['email' => 'teamleader@gmail.com'],
            [
                'name' => 'Team Leader',
                'password' => Hash::make('Team@123'),
            ]
        );

        $teamLeader->assignRole('team_leader');
    }
}
