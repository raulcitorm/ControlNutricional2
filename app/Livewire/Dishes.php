<?php



namespace App\Livewire;

use Livewire\Component;
use App\Models\Dish;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Dishes extends Component
{
    public $dishes;

    public $name;
    public $editingDishId = null;


    public $products = [];
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'products' => 'required|array',
            'products.*' => 'nullable|numeric|min:0.01',
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre del plato es obligatorio.',
        'name.min' => 'El nombre del plato debe tener al menos 3 caracteres.',

        'products.required' => 'Debes añadir al menos un ingrediente.',
        'products.*.numeric' => 'La cantidad debe ser un número.',
        'products.*.min' => 'La cantidad debe ser mayor que 0.',
    ];


    public function mount()
    {
        $this->loadDishes();
    }

    #[On('product-created')]
    public function refreshProducts()
    {
        // Refresh cuando se crea un producto nuevo
    }

    public function loadDishes()
    {
        $this->dishes = Dish::where('user_id', Auth::id())
            ->with('products')
            ->get();
    }

    public function save()
    {
        $this->validate();


        $validProducts = collect($this->products)
            ->filter(fn($qty) => $qty > 0);

        if ($validProducts->isEmpty()) {
            $this->addError('products', 'Debes añadir al menos un ingrediente con cantidad.');
            return;
        }

        $dish = Dish::updateOrCreate(
            ['id' => $this->editingDishId],
            [
                'name' => $this->name,
                'user_id' => Auth::id(),
            ]
        );

        $syncData = [];
        foreach ($validProducts as $productId => $quantity) {
            $syncData[$productId] = ['quantity' => $quantity];
        }

        $dish->products()->sync($syncData);

        $this->resetForm();
        $this->resetErrorBag();
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
