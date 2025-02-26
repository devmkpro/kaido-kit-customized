<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //call BookSeeder
        $this->call(
            [
                PostSeeder::class,
                ContactSeeder::class,
                ShieldSeeder::class,
            ]
        );
       
        User::factory(10)->create();

        $super_admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $super_admin->assignRole('super_admin');


    }
}
