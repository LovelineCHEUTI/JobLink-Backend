<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Admin JobLink',
            'email'     => 'admin@joblink.com',
            'password'  => Hash::make('Admin@1234'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
    }
}