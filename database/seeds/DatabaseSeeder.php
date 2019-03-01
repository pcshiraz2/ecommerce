<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersSeeder::class);
        $this->call([RolesAndPermissionsSeeder::class]);
        $this->call([CategoriesSeeder::class]);
        $this->call([SettingsSeeder::class]);
        $this->call([AttributesSeeder::class]);
        $this->call([CurrenciesSeeder::class]);
    }
}
