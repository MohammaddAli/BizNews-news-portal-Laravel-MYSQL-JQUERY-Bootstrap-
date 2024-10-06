<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentsServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    protected $comment;
    public function __construct(CommentsServices $commentsServices){
        $this->comment = $commentsServices;
    }
    public function store(Request $request){
        $request->validate([
            'comment'=> 'required',
            'singleNewsId' => 'required|exists:articles,id',
        ]);
        $comment = $this->comment->addNewComment($request->comment, $request->singleNewsId, Auth::id());
        $comment = $this->comment->getComment($comment->id);
        // dd($comment);
        Session::flash('done', 'Comment added successfuly');
        return response()->json($comment);
    }
}
