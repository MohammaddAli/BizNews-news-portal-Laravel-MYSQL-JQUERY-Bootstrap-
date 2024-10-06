<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ViewsServices;
use App\Services\CommentsServices;
use App\Services\SingleNewsServices;
use Illuminate\Support\Facades\Auth;
use App\Services\CommentReplyServices;

class SingleNewsController extends Controller
{
    protected $singleNewsServices, $commentsServices, $commentReplyServices, $viewsServices;


    // $commentReliesArr[] = $onecommentReply;


    public function __construct(SingleNewsServices $singleNewsServices, CommentsServices $commentsServices, CommentReplyServices $commentReplyServices, ViewsServices $viewsServices){
      $this->singleNewsServices = $singleNewsServices;
      $this->commentsServices = $commentsServices;
      $this->commentReplyServices = $commentReplyServices;
      $this->viewsServices = $viewsServices;
    }
    public function showSingleNews($articleId){
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

        if ($articleId == '0') {
            header("Location: ./trending.php");
        } else {
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
        }
        // $thirdPart
        return view('singleNews', compact(['allCategories', 'allComments', 'singleNews', 'viewsCount',
        'allcommentReplies', 'trendingNews', 'firstPart', 'secondPart', 'thirdPart']));
    }
}


// <?php
// session_start();
// require "./lib/category.php";
// require "./lib/comment.php";
// require "./lib/comment_reply.php";
// require "./lib/employee.php";
// require "./lib/single_news.php";
// require "./lib/single_news_images.php";
// // require_once "./lib/users.php";
// require "./lib/views.php";

// $singleNewsObject = new singleNews;
// $viewsObject = new views;
// $singleNews = "";
// $errors = "";
// $imagePath = "./admin_dashboard/news/images/";
// $body = "";
// $firstPart = "";
// $secondPart = "";
// $thirdPart = "";
// $singleNewsId = "";
// $userId = $_SESSION["id"];
// $commentObject = new comment;
// $allComments = "";
// $categoriesObject = new category;
// $allCategories = $categoriesObject->showALLCategories();
// if (isset($_GET["id"])) {
//     $singleNewsId = $_GET["id"];
//     $allComments = $commentObject->getAllSingleNewsComments($singleNewsId);
// }

// $commentReplyObject = new commentReply;
// $allcommentReplies = $commentReplyObject->showAllCommentReplys();

// $trendingNews = $commentObject->showTrendingNews();

// if (isset($_GET["id"])) {
//     $singleNews =  $singleNewsObject->singleNewsPage($_GET["id"]);
//     // print_r($singleNews[0]['views']);
//     $body = $singleNews[0]["body"];
//     $bodyLength = strlen($body);
//     $firstPart = substr($body, 0, $bodyLength / 3);
//     $secondPart = substr($body, $bodyLength / 3, ($bodyLength / 3) * 2);
//     $thirdPart = substr($body, ($bodyLength / 3) * 2, $bodyLength);
//     $rowsNum = $viewsObject->userHasViewsOnSingleNews($singleNewsId, $userId);
//     if ($rowsNum == 0) {
//         $viewsObject->addUserViewsOnSingleNews($singleNewsId, $userId);
//     }
//     $viewsCount = $viewsObject->getViewsOnSingleNews($singleNewsId);
// } else {
//     header("Location: ./trending.php");
// }
