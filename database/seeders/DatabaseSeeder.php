<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(CountriesTableDataSeeder::class);

        $category = Category::create([
                'name' => 'Electronics',
                'slug' => 'electronics',
                'does_contain_sub_category' => 1,
                'publish' => 1,
        ]);

        $category->subcategory()->create([
                'name' => 'Mobile',
                'slug' => 'mobile',
                'publish' => 1,
        ]);

        $category->subcategory()->create([
                'name' => 'Laptop',
                'slug' => 'laptop',
                'publish' => 1,
        ]);

        $category->subcategory()->create([
                'name' => 'Tablet',
                'slug' => 'tablet',
                'publish' => 1,
        ]);
    }
}
