<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = new Category();

        $category->create($data);
        
        $notification = array(
                    'message' => 'Kategoria została utworzona',
                    'alert-type' => 'success'
                );

        return redirect()->route('category.index')->with($notification);
    }

    public function show(Category $category)
    {
        $items = Item::where('category_id', $category->id)->where('availability', 1)->orderBy('created_at','DESC')->paginate(16);

        return view('categories.show', compact('category', 'items'));
    }
    
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        
        $categories = Category::all();
        
        return view('categories.index', compact('categories'));
    }
    
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }
    
    public function update(Category $category)
    {
        $this->authorize('update', $category);
        
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        
        $category->update($data);
        
        $notification = array(
                    'message' => 'Nazwa kategorii została zmieniona',
                    'alert-type' => 'success'
                );
        
        return redirect()->route('category.index')->with($notification);
    }
    
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
 
        try {
            $category->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000") {
                $notification = array(
                    'message' => 'Nie można usunąć kategorii, która zawiera ogłoszenia',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }

        $notification = array(
                    'message' => 'Kategoria została usunięta',
                    'alert-type' => 'success'
                );
        
        return redirect()->route('category.index')->with($notification);
    }
}
