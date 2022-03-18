<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $req)

    {
        $comment=new Comment();
        $comment->content=$req->content;
        $comment->blog_id=$req->blog_id;
        $comment->user_id=Auth::user()->id;

        $comment->save();
        return back();



    }

    public function deleteComment($id){

        $comment=Comment::findOrFail($id);
        $this->authorize('delete',$comment);
        $comment->delete();

        return back();
    }
}
