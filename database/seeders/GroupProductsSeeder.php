<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use StaticKidz\BedcaAPI\BedcaClient;

class GroupProductsSeeder extends Seeder
{
    public function run(): void
    {
        $client = new BedcaClient();
        $categories = Category::all();

        foreach ($categories as $category) {
            $foods = $client->getFoodsInGroup($category->id);

            foreach ($foods->food ?? [] as $food) {
                $foodDetails = $client->getFood($food->f_id);
                $foodData = $foodDetails->food;
                
                $nutrients = [];
                if (isset($foodData->foodvalue) && is_array($foodData->foodvalue)) {
                    foreach ($foodData->foodvalue as $component) {
                        $value = $component->best_location ?? 0;
                        
                        if (is_object($value)) {
                            $value = 0;
                        }
                        $nutrients[$component->c_ori_name] = floatval($value);
                    }
                }
                
                Product::create([
                    'name' => $foodData->f_ori_name ?? 'Unknown',
                    'category_id' => $category->id,
                    'is_global' => true,
                    'calories' => $nutrients['energía, total'] ?? 0,
                    'total_fat' => $nutrients['grasa, total (lipidos totales)'] ?? 0,
                    'saturated_fat' => $nutrients['ácidos grasos saturados totales'] ?? 0,
                    'cholesterol' => $nutrients['colesterol'] ?? 0,
                    'polyunsaturated_fat' => $nutrients['ácidos grasos, poliinsaturados totales'] ?? 0,
                    'monounsaturated_fat' => $nutrients['ácidos grasos, monoinsaturados totales'] ?? 0,
                    'carbohydrates' => $nutrients['carbohidratos'] ?? 0,
                    'fiber' => $nutrients['fibra, dietetica total'] ?? 0,
                    'protein' => $nutrients['proteina, total'] ?? 0,
                ]);
            }
        }
    }
}
