<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'hello@imkyra.be'],
            [
                'name'     => 'Kyra Admin',
                'password' => Hash::make('change-me-in-production!'),
                'role'     => 'admin',
            ]
        );

        // Ensure existing user has admin role
        if ($user->role !== 'admin') {
            $user->update(['role' => 'admin']);
        }
    }
}
