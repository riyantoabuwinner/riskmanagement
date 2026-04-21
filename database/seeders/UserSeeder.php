<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@uinsc.ac.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // Optional: Create an Admin user for testing
        $admin = User::firstOrCreate(
            ['email' => 'admin_tester@uinsc.ac.id'],
            [
                'name' => 'Admin Tester',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('Admin');

        // Optional: Create a Risk Owner for testing
        $riskOwner = User::firstOrCreate(
            ['email' => 'owner@uinsc.ac.id'],
            [
                'name' => 'Risk Owner',
                'password' => Hash::make('password'),
            ]
        );
        $riskOwner->assignRole('Risk Owner');
    }
}
