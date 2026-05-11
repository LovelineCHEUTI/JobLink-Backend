<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'Loveline Ruth',    'city' => 'Yaoundé',   'phone' => '699001122'],
            ['name' => 'Paul Kenfack',    'city' => 'Douala',    'phone' => '677223344'],
            ['name' => 'Marie Atangana', 'city' => 'Yaoundé',   'phone' => '655445566'],
            ['name' => 'Eric Fouda',     'city' => 'Bafoussam', 'phone' => '688667788'],
        ];

        foreach ($providers as $index => $data) {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => 'provider' . ($index + 1) . '@test.com',
                'password'  => Hash::make('Password123'),
                'role'      => 'provider',
                'city'      => $data['city'],
                'phone'     => $data['phone'],
                'is_active' => true,
            ]);

            ProviderProfile::create([
                'user_id'        => $user->id,
                'description'    => 'Prestataire professionnel avec plusieurs années d\'expérience.',
                'is_validated'   => true,
                'average_rating' => round(rand(30, 50) / 10, 1),
                'reviews_count'  => rand(5, 30),
            ]);

            Subscription::create([
                'user_id'    => $user->id,
                'type'       => 'monthly',
                'status'     => 'active',
                'starts_at'  => now(),
                'expires_at' => now()->addDays(30),
            ]);
        }
    }
}