<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $categories;

    public $name, $category_id;
    public $calories, $total_fat, $saturated_fat, $cholesterol;
    public $polyunsaturated_fat, $monounsaturated_fat;
    public $carbohydrates, $fiber, $protein;

    public $editingId = null;

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
    }

    public function save()
    {
        Product::updateOrCreate(
            ['id' => $this->editingId],
            [
                'user_id' => Auth::id(),
                'is_global' => false,
                'name' => $this->name,
                'category_id' => $this->category_id,

                'calories' => $this->calories,
                'total_fat' => $this->total_fat,
                'saturated_fat' => $this->saturated_fat,
                'cholesterol' => $this->cholesterol,
                'polyunsaturated_fat' => $this->polyunsaturated_fat,
                'monounsaturated_fat' => $this->monounsaturated_fat,
                'carbohydrates' => $this->carbohydrates,
                'fiber' => $this->fiber,
                'protein' => $this->protein,
            ]
        );

        $this->resetForm();
        $this->resetPage(); 
    }

    public function edit($id)
    {
        $product = Product::personal(Auth::id())->findOrFail($id);

        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;

        $this->calories = $product->calories;
        $this->total_fat = $product->total_fat;
        $this->saturated_fat = $product->saturated_fat;
        $this->cholesterol = $product->cholesterol;
        $this->polyunsaturated_fat = $product->polyunsaturated_fat;
        $this->monounsaturated_fat = $product->monounsaturated_fat;
        $this->carbohydrates = $product->carbohydrates;
        $this->fiber = $product->fiber;
        $this->protein = $product->protein;
    }

    public function delete($id)
    {
        Product::personal(Auth::id())->findOrFail($id)->delete();
        $this->resetPage(); 
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = null;
        $this->category_id = null;

        $this->calories = $this->total_fat = $this->saturated_fat = 0;
        $this->cholesterol = $this->polyunsaturated_fat = $this->monounsaturated_fat = 0;
        $this->carbohydrates = $this->fiber = $this->protein = 0;
    }

    public function render()
    {
        return view('livewire.products', [
            'products' => Product::personal(Auth::id())
                ->orderBy('name')
                ->paginate(5)
        ]);
    }
}
