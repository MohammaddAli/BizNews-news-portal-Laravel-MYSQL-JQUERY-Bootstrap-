<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryContoller extends Controller
{
    public function categoryPageLimit(){
        $categories = Category::has('articles')->get();
        foreach ($categories as $category) {
            $category->articles = $category->articles()->take(2)->get();
        }
    // $categories = Category::whereHas('articles', function($query) {
    //     $query->with(['articleImage', 'employee']);
    // })->with(['articles' => function($query) {
    //     $query->limit(2)->with(['articleImage', 'employee']);
    // }])->get();
    // $categories = Category::whereHas('articles')->with(['articles' => function($query) {
    //     $query->take(2)->with(['articleImage', 'employee']);
    // }])->get();
        return view('categories', compact('categories'));
        }

        public function categoryPageAll($id){
            $category = Category::with(['articles.articleImage', 'articles.employee'])->find($id);
            return view('categoryAll', compact('category'));
        }
}
