<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ViewsServices;
use App\Services\CommentsServices;
use App\Services\SingleNewsServices;
use Illuminate\Support\Facades\Auth;
use App\Services\CommentReplyServices;

class TrendingController extends Controller
{
    protected $singleNewsServices, $commentsServices, $commentReplyServices, $viewsServices;

    public function __construct(SingleNewsServices $singleNewsServices, CommentsServices $commentsServices, CommentReplyServices $commentReplyServices, ViewsServices $viewsServices){
      $this->singleNewsServices = $singleNewsServices;
      $this->commentsServices = $commentsServices;
      $this->commentReplyServices = $commentReplyServices;
      $this->viewsServices = $viewsServices;
    }
    public function showSingleNews(){
        // $trendingNews =$this-commentsServices->showTrendingNews();
        $topCommentNews =$this->singleNewsServices->singleNewsTrendingPage();
        $articleId = $topCommentNews->articles_id;
        $trendingNews =$this->singleNewsServices->showTrendingNews();

        $allCategories = Category::all();
        $allComments = "";
        $singleNews = "";
        $viewsCount = "";
        $allcommentReplies = "";
        $trendingNews = "";

         if($articleId){
            $allComments = $this->commentsServices->getAllArticleComments($articleId);
        }
        $allcommentReplies = $this->commentReplyServices->showAllCommentReplys();
        $trendingNews =$this->singleNewsServices->showTrendingNews();

            $singleNews =  $this->singleNewsServices->singleNewsPage($articleId);
            $body = $singleNews->body;
            $bodyLength = strlen($body);
            $firstPart = substr($body, 0, $bodyLength / 3);
            $secondPart = substr($body, $bodyLength / 3, ($bodyLength / 3) * 2);
            $thirdPart = substr($body, ($bodyLength / 3) * 2, $bodyLength);
            $rowsNum = $this->viewsServices->getUserViewsOnArticle($articleId, Auth::user()->id);
            if ($rowsNum == 0) {
                $this->viewsServices->addUserViewsOnArticle($articleId, Auth::user()->id);
            }
            $viewsCount = $this->viewsServices->getViewsOnArticle($articleId);

        return view('trending', compact(['allCategories', 'allComments', 'singleNews', 'viewsCount',
        'allcommentReplies', 'trendingNews', 'firstPart', 'secondPart', 'thirdPart']));
    }
}









// public function showSingleNews($articleId){

//     $allCategories = Category::all();

//     $allComments = "";

//     $singleNews = "";

//     $viewsCount = "";

//     $allcommentReplies = "";

//     $trendingNews = "";


//      if($articleId){

//         $allComments = $this->commentsServices->getAllArticleComments($articleId);

//     }

//     $allcommentReplies = $this->commentReplyServices->showAllCommentReplys();

//     $trendingNews =$this->commentsServices->showTrendingNews();


//         $singleNews =  $this->singleNewsServices->singleNewsPage($articleId);
