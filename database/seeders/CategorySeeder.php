<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use StaticKidz\BedcaAPI\BedcaClient;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $client = new BedcaClient();
        $categories = $client->getFoodGroups() ;

        foreach ($categories->food as $category) {
            
        $categoria = new Category();
        $categoria->name = $category->fg_ori_name ;
        $categoria->bedca_id = $category->fg_id;
        $categoria->save();
        }
    }
}