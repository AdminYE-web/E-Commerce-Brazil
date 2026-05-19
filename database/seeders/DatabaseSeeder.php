<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            AdminUserSeeder::class,
            UsersSeeder::class,
            CategoriesSeeder::class,
            MaterialsSeeder::class,
            OptionGroupsSeeder::class,
            ProductsSeeder::class,
            ProductDetailsSeeder::class,
            ProductImagesSeeder::class,
            ProductOptionsSeeder::class,
            OptionImagesSeeder::class,
            OptionDependenciesSeeder::class,
            ProductOptionAssignmentsSeeder::class,
            ProductOptionVariantsSeeder::class,
            ProductPriceRulesSeeder::class,
            ProductPriceRuleOptionsSeeder::class,
            ProductPriceRuleTiersSeeder::class,
            ProductPriceTiersSeeder::class,
            HomeBannersSeeder::class,
            MaterialHomesSeeder::class,
            ProductListBannersSeeder::class,
            ArticlesSeeder::class,
            ContactSubmissionsSeeder::class,
            SocialAccountsSeeder::class,

        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
