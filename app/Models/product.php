<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'user_id', 'is_global',
        'calories', 'total_fat', 'saturated_fat', 'trans_fat',
        'polyunsaturated_fat', 'monounsaturated_fat', 'carbohydrates',
        'sugars', 'fiber', 'protein'
    ];

    protected $casts = [
        'calories' => 'decimal:2',
        'total_fat' => 'decimal:2',
        'saturated_fat' => 'decimal:2',
        'trans_fat' => 'decimal:2',
        'polyunsaturated_fat' => 'decimal:2',
        'monounsaturated_fat' => 'decimal:2',
        'carbohydrates' => 'decimal:2',
        'sugars' => 'decimal:2',
        'fiber' => 'decimal:2',
        'protein' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    public function scopePersonal($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->where('is_global', false);
    }
}