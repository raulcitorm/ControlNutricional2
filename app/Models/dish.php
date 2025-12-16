<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function calculateMacros()
    {
        $total = [
            'calories' => 0,
            'total_fat' => 0,
            'saturated_fat' => 0,
            
            'polyunsaturated_fat' => 0,
            'monounsaturated_fat' => 0,
            'carbohydrates' => 0,
            'sugars' => 0,
            'fiber' => 0,
            'protein' => 0,
        ];

        foreach ($this->products as $product) {
            $quantity = $product->pivot->quantity / 100; 
            
            $total['calories'] += $product->calories * $quantity;
           
            $total['saturated_fat'] += $product->saturated_fat * $quantity;
            $total['trans_fat'] += $product->trans_fat * $quantity;
            $total['polyunsaturated_fat'] += $product->polyunsaturated_fat * $quantity;
            $total['monounsaturated_fat'] += $product->monounsaturated_fat * $quantity;
            $total['carbohydrates'] += $product->carbohydrates * $quantity;
            $total['sugars'] += $product->sugars * $quantity;
            $total['fiber'] += $product->fiber * $quantity;
            $total['protein'] += $product->protein * $quantity;
        }

        return $total;
    }
}