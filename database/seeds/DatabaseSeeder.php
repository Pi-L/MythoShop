<?php

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
        $this->call(AddresseSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(AddresseUserSeeder::class);
    }
}
