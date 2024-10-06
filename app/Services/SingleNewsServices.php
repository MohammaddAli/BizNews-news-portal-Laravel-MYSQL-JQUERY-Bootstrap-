<?php
namespace App\Services;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class SingleNewsServices{
    public function singleNewsPage($id)
    {
       return Article::with('articleImage', 'category', 'employee')
        ->where('articles.id', $id)
        ->leftJoin('comments', 'articles.id', '=', 'comments.articles_id')
        ->select('articles.*', 'comments.message')
        ->get()->first();
    }
    public function singleNewsTrendingPage()
    {
    return Comment::select(DB::raw('count(id) as count, articles_id'))
    ->groupBy('articles_id')
    ->orderBy('count', 'desc')
    ->first();
    }

    public function showTrendingNews()
    {
        return DB::table('comments')
        ->select(
            DB::raw('count(comments.id) AS commentsCount'),
            'comments.articles_id',
            'articles.title',  'articles.body', 'articles.created_at AS articles_created_at',
            'categories.name AS categoryName',
            'article_images.url_main', 'article_images.url_sub1', 'article_images.url_sub2')
        ->join('articles', 'comments.articles_id', '=', 'articles.id')
        ->join('categories', 'articles.categories_id', '=', 'categories.id')
        ->join('article_images', 'articles.id', '=', 'article_images.articles_id')
        ->groupBy('comments.articles_id', 'articles.title',  'articles.body', 'articles_created_at',
            'categoryName', 'article_images.url_main', 'article_images.url_sub1', 'article_images.url_sub2')
        ->having('commentsCount', '>', 5)
        ->get();
    }

    public function showAllGategoryNews($category)
    {
Article::with('articleImage', 'category', 'employee')
->where('categories.name', $category)
->get();
}
    public function showAllNewsCategories()
    {
return Article::with('category')
->get();
    }
    public function getSingleNewsByCategoryId($categoryId)
    {
return Article::with('articleImage', 'category', 'employee')
->where('categories.id', $categoryId)
->get();
    }
    public function getSingleNewsByCategoryIdLimit($categoryId)
    {
return Article::with('articleImage', 'category', 'employee')
->where('categories.id', $categoryId)
->limit(2)
->get();
    }
      public function getSingleNewsCategory()
    {
return Article::with('articleImage', 'category', 'employee')
->groupBy('categories')
->get();
    }
    public function search($searchedTitle)
    {
return Article::with('articleImage', 'category', 'employee')
->where('articles.title', 'LIKE', '%'.$searchedTitle.'%')
->limit(2)
->get();
    }
}
