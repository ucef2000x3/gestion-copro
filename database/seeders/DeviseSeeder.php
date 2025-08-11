<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Devise::truncate(); // Vide la table avant de la remplir

        $devises = [
            ['nom' => 'Moroccan Dirham', 'code' => 'MAD', 'symbole' => 'DH'],
            ['nom' => 'Euro', 'code' => 'EUR', 'symbole' => '€'],
            ['nom' => 'US Dollar', 'code' => 'USD', 'symbole' => '$'],
            ['nom' => 'Livre Sterling', 'code' => 'GBP', 'symbole' => '£'],
            ['nom' => 'Franc Suisse', 'code' => 'CHF', 'symbole' => 'CHF'],
        ];

        foreach ($devises as $devise) {
            Devise::create($devise);
        }
    }
}
