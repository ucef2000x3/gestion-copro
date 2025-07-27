<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Langue::create(['code_langue' => 'fr', 'nom' => 'Français']);
        \App\Models\Langue::create(['code_langue' => 'en', 'nom' => 'English']);
    }
}
