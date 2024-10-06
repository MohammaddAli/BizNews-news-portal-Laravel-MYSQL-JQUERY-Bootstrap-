<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentReplyServices;
use Illuminate\Support\Facades\Session;

class CommentReplyController extends Controller
{
    protected $commentReply;
    public function __construct(CommentReplyServices $CommentReplyServices){
$this->commentReply = $CommentReplyServices;
    }
    public function store(Request $request){
        $request->validate([
            'commentId' => 'required|exists:comments,id',
            'replyMessage'=> 'required',
        ]);

        $commentReply = $this->commentReply->addNewCommentReply($request->replyMessage, $request->commentId);
        $commentReply = $this->commentReply->getCommentReply($commentReply->id);

        Session::flash('done', 'Comment added successfuly');
        return response()->json($commentReply);
    }
}
