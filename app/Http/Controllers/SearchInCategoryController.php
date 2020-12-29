<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Http\Request;
class SearchInCategoryController extends Controller
{
    public function search(Request $request, string $category)
    {
        $request->validate(['query' => 'required',]);
        $query = $request->input('query');
        $categoryFromDb = Category::where('id', 'LIKE', "$category")->first();
        $items = Item::where('title', 'LIKE', "%$query%")->where('category_id','LIKE',"$categoryFromDb->id")->orderby('updated_at','desc')->paginate(16);
        return view('/results.results', compact('items'));

    }
}
