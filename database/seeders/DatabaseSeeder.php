<?php

namespace Database\Seeders;

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
        $this->call([
            UserSeeder::class,
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
        ]);

        // Seeder of Cities by States
        $numberOfStates = 51;

        for ($stateNumber = 1; $stateNumber <= $numberOfStates; $stateNumber++) {
            $seederClass = sprintf('Database\Seeders\state_cities\state%dTableSeeder', $stateNumber);
            $this->call($seederClass);
        }
    }
}
