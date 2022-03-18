<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $req){
        $like=new Like();
        $like->user_id=Auth::user()->id;
        $like->blog_id=$req->blog_id;
        $like->save();
        return back();

    }

    public function remove(Request $req){

        Like::where('blog_id',$req->blog_id)->where('user_id',Auth::user()->id)->delete();
        return back();
    }
}
