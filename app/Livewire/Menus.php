<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Menus extends Component
{
    public $selectedDate;
    public $selectedDish = null;
    public $servings = 1;
    public $menus = [];
    public $dailyMacros = [];
    public $availableDishes = [];
    public $mealTypes = ['breakfast' => 'Desayuno', 'lunch' => 'Almuerzo', 'snack' => 'Merienda', 'dinner' => 'Cena'];
    public $selectedMealType = 'lunch';
    public $userId;

    public function mount()
    {
        $this->userId = Auth::id();
        $this->selectedDate = now()->format('Y-m-d');
        $this->loadAvailableDishes();
        $this->loadMenusForDate();
        $this->calculateDailyMacros();
    }

    public function loadAvailableDishes()
    {
        $this->availableDishes = Dish::where('user_id', $this->userId)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function loadData()
    {
        $this->loadAvailableDishes();
        $this->loadMenusForDate();
        $this->calculateDailyMacros();
    }

    public function loadMenusForDate()
    {
        $this->menus = Menu::where('user_id', Auth::id())
            ->whereDate('date', $this->selectedDate)
            ->with('dish.products')
            ->get();
    }

    public function calculateDailyMacros()
    {
        $this->dailyMacros = Menu::where('user_id', Auth::id())
            ->whereDate('date', $this->selectedDate)
            ->with('dish.products')
            ->get()
            ->reduce(function ($carry, $menu) {
                $macros = $menu->dish->calculateMacros();
                $servings = $menu->servings ?? 1;

                foreach ($macros as $key => $value) {
                    $carry[$key] = ($carry[$key] ?? 0) + ($value * $servings);
                }

                return $carry;
            }, [
                'calories' => 0,
                'total_fat' => 0,
                'saturated_fat' => 0,
                'trans_fat' => 0,
                'polyunsaturated_fat' => 0,
                'monounsaturated_fat' => 0,
                'carbohydrates' => 0,
                'sugars' => 0,
                'fiber' => 0,
                'protein' => 0,
            ]);
    }

    public function addDishToMenu()
    {
        if (!$this->selectedDish) {
            $this->addError('selectedDish', 'Selecciona un plato');
            return;
        }

        $menu = Menu::create([
            'user_id' => Auth::id(),
            'date' => $this->selectedDate,
            'meal_type' => $this->selectedMealType,
            'dish_id' => $this->selectedDish,
            'servings' => $this->servings,
        ]);

        $this->selectedDish = null;
        $this->servings = 1;
        $this->loadData();
    }

    public function removeDish($menuId)
    {
        Menu::find($menuId)->delete();
        $this->loadData();
    }

    public function changeDate()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.menus');
    }
}
