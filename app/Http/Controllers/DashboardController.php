<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //     public function showBreakingNews(){

    // // $breakingNews = DB::table('articles')
// // ->select('users.*', 'article_images.*', 'categories.name', 'employees.name')
// // ->join('article_images', '=', 'articles.id', 'article_images.articles_id')
// // ->join('categories', 'categories.id', '=', 'articles.categories_id')
// // ->join('employees', 'employees.id', '=', 'articles.employees_id')
// // ->where('created_at', '>', DB::raw('CURDATE() - INTERVAL 1 DAY'))
// // ->get();
// $breakingNews = Article::with('articleImage', 'category', 'employee')
// ->where('created_at', '>', Carbon::yesterday())->get();
// // dd($breakingNews);
// // return redirect()->route('dashboard');
// return view('dashboard', compact('breakingNews'));
//     }

    public function getBreakingNews()
    {
        return Article::with('articleImage', 'category', 'employee')
            ->where('created_at', '>', Carbon::yesterday())->get();
    }
    public function getLatestNews()
    {
        return Article::with('articleImage', 'category', 'employee', 'articleViews', 'comments')
            ->where('created_at', '>', Carbon::now()->subDays(7))->limit(4)->get();
    }
    public function getFeaturedNews()
    {
        return Article::with('articleImage', 'category', 'employee')
            ->where('is_feature', '=', 1)->get();
    }

    public function showDashboard()
    {
        $breakingNews = $this->getBreakingNews();
        $latestNews = $this->getLatestNews();
        $featuredNews = $this->getFeaturedNews();

        return view('dashboard', compact('breakingNews', 'latestNews', 'featuredNews'));
    }
}
