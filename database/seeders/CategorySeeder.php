<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
           ['name' => 'Plomberie',         'icon' => '🔧', 'description' => 'Réparation et installation de plomberie'],
    ['name' => 'Électricité',       'icon' => '⚡', 'description' => 'Installation et réparation électrique'],
    ['name' => 'Menuiserie',        'icon' => '🪚', 'description' => 'Travaux de menuiserie et charpente'],
    ['name' => 'Maçonnerie',        'icon' => '🧱', 'description' => 'Construction et rénovation'],
    ['name' => 'Peinture',          'icon' => '🖌️', 'description' => 'Peinture intérieure et extérieure'],
    ['name' => 'Carrelage',         'icon' => '🏗️', 'description' => 'Pose de carrelage et revêtement'],
    ['name' => 'Climatisation',     'icon' => '❄️', 'description' => 'Installation et entretien climatisation'],
    ['name' => 'Soudure',           'icon' => '🔩', 'description' => 'Travaux de soudure et métallerie'],
    ['name' => 'Toiture',           'icon' => '🏠', 'description' => 'Réparation et construction de toiture'],
    ['name' => 'Vitrage',           'icon' => '🪟', 'description' => 'Installation et remplacement de vitres'],
        ];

        foreach ($categories as $category) {
            Category::create([...$category, 'is_active' => true]);
        }
    }
}