<?php
namespace app\Services;

use App\Models\Article;
use App\Models\ArticleView;

class ViewsServices{
    public function addUserViewsOnArticle($articleId, $useId)
    {
       return ArticleView::create(['articles_id' => $articleId, 'users_id' => $useId]);
    }

    public function getViewsOnArticle($articleId)
    {
    return ArticleView::where('articles_id', '=', $articleId)->count();
    }
    public function getUserViewsOnArticle($articleId, $useId)
    {
        return ArticleView::where('articles_id', '=', $articleId)->where('users_id', '=', $useId)->count();
    }
}
