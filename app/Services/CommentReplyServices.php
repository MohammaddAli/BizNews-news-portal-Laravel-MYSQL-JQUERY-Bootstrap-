<?php
namespace App\Services;
use App\Models\CommentReply;
class CommentReplyServices{
    public function addNewCommentReply($message, $comment_id)
{
$commentReply = CommentReply::create(['message'=>$message, 'comments_id'=>$comment_id]);
return $commentReply;
}

public function showAllCommentReplys()
{
return CommentReply::all();
}

public function getCommentReply($id)
{
return CommentReply::find($id);
}
}

