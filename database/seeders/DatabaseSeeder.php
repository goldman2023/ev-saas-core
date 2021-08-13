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
        $this->call(BusinessSettingsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        $this->call(HomeCategoriesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PoliciesTableSeeder::class);
        $this->call(ProductStocksTableSeeder::class);
        $this->call(ProductTaxesTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(TranslationsTableSeeder::class);
        $this->call(UploadsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SellersTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
    }
}
