<?php



namespace App\Livewire;

use Livewire\Component;
use App\Models\Dish;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Dishes extends Component
{
    public $dishes;

    public $name;
    public $editingDishId = null;

  
    public $products = []; 

    public function mount()
    {
        $this->loadDishes();
    }

    public function loadDishes()
    {
        $this->dishes = Dish::where('user_id', Auth::id())
            ->with('products')
            ->get();
    }

    public function save()
    {
        $dish = Dish::updateOrCreate(
            ['id' => $this->editingDishId],
            [
                'name' => $this->name,
                'user_id' => Auth::id()
            ]
        );

      
        $syncData = [];
        foreach ($this->products as $productId => $quantity) {
            if ($quantity > 0) {
                $syncData[$productId] = ['quantity' => $quantity];
            }
        }

        $dish->products()->sync($syncData);

        $this->resetForm();
        $this->loadDishes();
    }

    public function edit($id)
    {
        $dish = Dish::where('user_id', Auth::id())
            ->with('products')
            ->findOrFail($id);

        $this->editingDishId = $dish->id;
        $this->name = $dish->name;

        $this->products = [];
        foreach ($dish->products as $product) {
            $this->products[$product->id] = $product->pivot->quantity;
        }
    }

    public function delete($id)
    {
        Dish::where('user_id', Auth::id())->findOrFail($id)->delete();
        $this->loadDishes();
    }

    public function resetForm()
    {
        $this->editingDishId = null;
        $this->name = '';
        $this->products = [];
    }

    public function render()
    {
        return view('livewire.dishes', [
            'availableProducts' => Product::where(function ($q) {
                $q->where('is_global', true)
                  ->orWhere('user_id', Auth::id());
            })->orderBy('name')->get()
        ]);
    }
}
