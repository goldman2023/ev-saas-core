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
        $this->call(UserSeeder::class);
        $this->call(TenantSettingsTableSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(UploadsTableSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(ShopSettingsTableSeeder::class);
        $this->call(ProductTaxesTableSeeder::class);
        $this->call(ProductStocksTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
