<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $request->validate(['query'=>'required',]);
        $query = $request->input('query');
        //dd($query);
        $items = Item::where('title', 'LIKE',"%$query%")->orWhere('description','like',"%$query%")->orderby('updated_at', 'desc')->paginate(16);
        return view('/results.results', compact('items'));
    }



}
