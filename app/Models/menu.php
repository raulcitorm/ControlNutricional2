<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'meal_type', 'dish_id', 'servings'];

    protected $casts = [
        'date' => 'date',
        'servings' => 'decimal:1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function calculateDailyMacros($date, $userId)
    {
        $menus = self::where('date', $date)
            ->where('user_id', $userId)
            ->with('dish.products')
            ->get();

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

        foreach ($menus as $menu) {
            $dishMacros = $menu->dish->calculateMacros();
            $servings = $menu->servings;

            foreach ($dishMacros as $key => $value) {
                $total[$key] += $value * $servings;
            }
        }

        return $total;
    }
}