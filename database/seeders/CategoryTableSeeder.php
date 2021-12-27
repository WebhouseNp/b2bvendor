<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Furniture', 'Wood', 'Bamboo', 'Fish', 'Meat'];
        for($i=0; $i<count($names); $i++){
            Category::create(
                [
                    'name' => $names[$i],
                    'publish'=> 1
                ]
            );
        }
        
    }
}
