<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Dish;
use App\Models\Menu;

class StatsController extends Controller
{
    public function index()
    {
        
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'acceso prohibido');
        }

        
        $stats = [
            'total_products' => Product::count(),
            'total_dishes' => Dish::count(),
            'total_menus' => Menu::count(),
            'global_products' => Product::where('is_global', true)->count(),
        ];

        return view('stats', $stats);
    }
}
