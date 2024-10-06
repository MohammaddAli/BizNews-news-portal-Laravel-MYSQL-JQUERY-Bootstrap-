<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $request->validate(['search' => 'required']);
       $searchedArticle = Article::with('articleImage', 'category', 'employee')
         ->where('title', 'LIKE', "%$request->search%")
         ->limit(2)
         ->first();
         return redirect()->route('singleNews', $searchedArticle->id);
    }
}

