<?php
namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
class CommentsServices{
    public function addNewComment($message, $articlesId, $userId)
    {
        $comment = Comment::create([
            'message' => $message,
            'articles_id' => $articlesId,
            'users_id' => $userId,
        ]);
        return $comment;
    }

    public function getAllComments()
    {
       return Comment::orderBy('created_at')->get();
    }

    public function getAllArticleComments($articlesId)
    {
// Comment::with(['articles', 'users'])
// ->select(
//  'comments.id AS commentId', 'comments.message', 'comments.created_at',
//  'articles.id AS articleId', 'articles.title',
//  'users.id AS userId', 'users.name AS userName', 'users.image AS userImage')
// ->orderBy('comments.created_at')
// ->get();

return DB::table('comments')
->where('comments.articles_id', '=', $articlesId)
->join('articles', 'comments.articles_id', '=', 'articles.id')
->join('users', 'comments.users_id', '=', 'users.id')
->select(
    'comments.id AS commentId', 'comments.message', 'comments.created_at',
    'articles.id AS articleId', 'articles.title',
    'users.id AS userId', 'users.name AS userName', 'users.image AS userImage')
->orderBy('comments.created_at')
->get();
    }

    public function getComment($id)
    {
return DB::table('comments')
->select(
    'comments.id AS commentId', 'comments.message', 'comments.created_at',
    'articles.id AS articleId', 'articles.title',
    'users.id AS userId', 'users.name AS userName', 'users.image AS userImage')
->join('articles', 'comments.articles_id', '=', 'articles.id')
->join('users', 'comments.users_id', '=', 'users.id')
->where('comments.id', '=', $id)
->get()->first();
    }
}

// $comments = DB::table('comments')
//     ->select(
//         DB::raw('count(comments.id) AS commentsCount'),
//         'comments.article_id'
//     )
//     ->groupBy('comments.article_id')
//     ->having('commentsCount', '>', 5);

// $results = DB::table('articles')
//     ->join('categories', 'articles.categories_id', '=', 'categories.id')
//     ->join('article_images', 'articles.id', '=', 'article_images.articles_id')
//     ->joinSub($comments, 'comments', function ($join) {
//         $join->on('articles.id', '=', 'comments.article_id');
//     })
//     ->select(
//         'comments.commentsCount',
//         'comments.article_id',
//         'articles.title',
//         'articles.body',
//         'articles.created_at',
//         'categories.name AS categoryName',
//         'article_images.url_main',
//         'article_images.url_sub1',
//         'article_images.url_sub2'
//     )
//     ->get();
