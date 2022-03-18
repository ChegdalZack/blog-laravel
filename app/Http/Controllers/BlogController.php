<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

        // public function __construct()
        // {
        //     return $this->middleware('auth')->except('home');
        // }


    public function home()
    {
        
        $blogs=Blog::latest()->paginate(2);

        return view('blogs.Home',['blogs'=>$blogs,'tab'=>'current']);
    }
    public function trashed_blog()
    {
        $blogs= Blog::onlyTrashed()
        ->where('user_id',Auth::user()->id)->paginate(2);
        return view('blogs.Home',['blogs'=>$blogs,'tab'=>'trashed']);


    }

    public function all()
    {
        $blogs=Blog::withoutTrashed()
        ->where('user_id',Auth::user()->id)->paginate(2);
        return view('blogs.Home',['blogs'=>$blogs,'tab'=>'with_trashed']);
}

    public function details($id)
    {
        $blog=Blog::findOrFail($id);

        // dd($blog);
        return view('blogs.details',['blog'=>$blog]);
    }
  
    public function create()
    {
        $categories=Category::all();

        return view('blogs.create',['categories'=>$categories]);
    }

    public function store(BlogRequest $req)
    {

        $blog=new Blog();
        $blog->title=$req->title;
        $blog->content=$req->content;
        $blog->user_id=Auth::user()->id;
        $blog->category_id=$req->category_id;
        if($req->hasFile('photo'))
        {
        //    $path=$req->photo->store('images');
        $path=Storage::putFile("images",$req->photo);
        // dd(Storage::url($path));   
        $blog->photo=$path;
           
        }
        $blog->save();
        return redirect('home');
    }


    public function show($id)
    {
        $blog=Blog::findOrFail($id);
        $categories=Category::all();

        $this->authorize('view',$blog);


        return view('blogs.show',['blog'=>$blog,"categories"=>$categories]);
    }

    public function updateBlog(BlogRequest $req,$id)   
    {
        $blog=Blog::findOrFail($id);
        $this->authorize('update',$blog);
        $blog->title=$req->title;
        $blog->content=$req->content;
        if($req->hasFile('photo'))
        {
        //    $path=$req->photo->store('images');
        if($blog->photo){

        
        Storage::delete($blog->photo);
        }
        $path=Storage::putFile("images",$req->photo);
        // dd(Storage::url($path));   
        $blog->photo=$path;
           
        }
        $blog->save();

      
        return redirect('home');

    }


    public function destroy($id)
    {
        
       $blog=Blog::findOrFail($id);
        $this->authorize('delete',$blog);

        $blog->delete();
        return back();
    }

    public function restore($id)
    {

       $blog=Blog::withTrashed()

        ->where('id',$id)
        ->first();
        $this->authorize('restore',$blog);

        $blog->restore();


        return redirect('/home');
    }

    public function forceDelete($id){
        
        $blog=Blog::onlyTrashed($id)
        ->where('id',$id)
        ->first();

        $this->authorize('forceDelete',$blog);

        $blog->forceDelete();
        return back();

    }
    



 
   
    public function getData()
    {
        //   $blogs=Category::find(5)->blogs;

        //   foreach ($blogs as $blog) {
              
        //     echo $blog->title;
        //     echo '<br>';
        //     echo $blog->content;
        //     echo '<hr>';
        //   }

        // $category=Blog::findOrFail(8)->category;

        //  echo $category->name;

        // // get all blogs==> array contains 'second blog ' in title
        // $blogs=Blog::where('title',"second blog")->get();

        // // get first blog==> object  contains 'second blog ' in title
        // $blogs=Blog::where('title',"second blog")->first();


        // // select * from categories inner join blogs on category.id=blog.category_id
        // categories with blogs
        // $categories=  Category::whereHas('blogs')->get();

         // select * from categories inner join blogs on category.id!=blog.category_id
        //  categories with none blogs
        //  $categories=  Category::whereDoesntHave('blogs')->get();


        // get categories with blogs
        // $categories=Category::with('blogs')->get();

        // // get categories with blogs
        // $blogs=Blog::with('category')->get();


        // $categories=Category::withCount('blogs')->get();


        //  return response()->json(['categories'=>$categories]);



    }
}

