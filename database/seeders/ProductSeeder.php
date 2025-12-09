<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use StaticKidz\BedcaAPI\BedcaClient;



class ProductSeeder extends Seeder

{
    public function run(): void
    {
        $client = new BedcaClient();
        $categories = $client->getFoodGroups() ;

        foreach ($categories->food as $category) {
             foreach ($categories->food as $category) {
            $food = new Product();
            $food->name = $category->fg_ori_name ;
            $food->bedca_id = $category->fg_id;
            $food->save();
             }

        }
    }
}