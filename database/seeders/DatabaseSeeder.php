<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Marketing Test',
            'email' => 'marketing@application.test',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sales Test',
            'email' => 'sales@application.test',
        ]);
    }
}
