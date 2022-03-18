

@extends('../layouts.app')

@section('content')
<div class="container">

    <h1 class="text-secondary text-center">Blogs page</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if($tab=='current') active @endif" aria-current="page" href="/home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($tab=='trashed') active @endif" href="/trash">Trashed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($tab=='with_trashed') active @endif" href="/all">All</a>
          </li>
        
        
      </ul>

<div class="row">

    @forelse ($blogs as $blog)

    <ul class="list-group col-md-4 mt-2">

      <img src="{{Storage::url($blog->photo)}}" alt="">


        <li class="list-group-item">{{$blog->title}}</li>
        <li class="list-group-item">{{$blog->content}}</li>
        <li class="list-group-item">
          
            @if($blog->deleted_at==NULL)
            @can('delete',$blog)
            <form action="destroy/{{$blog->id}}" method="post">
                 @method('DELETE')
                 @csrf
                 <button class="btn btn-danger">delete</button>
                
            </form>
            @endcan
            @can('update',$blog)
            <a href="show/{{$blog->id}}" class="btn btn-warning">update</a>
            @endcan
            <a href="details/{{$blog->id}}" class="btn btn-primary">details</a>

            @else
            <form action="/forceDelete/{{$blog->id}}" method="post">
            @csrf 
            @method("DELETE")
            <button class="btn btn-danger" onclick="return(confirm('are you sure'))">Perma delete</button>
            <a href="restore/{{$blog->id}}" class="btn btn-primary">Restore</a>


            
            
            </form>
            

        @endif
            

        </li>
        <li class="list-group-item active">{{$blog->category->name}}-published by {{$blog->user->name}} - ({{$blog->comments->count()}}) Comment </li>
        <li class="list-group-item active">{{$blog->created_at->diffForHumans()}}</li>



{{-- Like button --}}
       


<li class="list-group-item">

  @if ($blog->likes()->where('blog_id',$blog->id)->where('user_id',Auth::user()->id)->first())
      
  
      
  
  
  <form action="/removeLike" method="post">
    @csrf 
    @method('DELETE')
    <input type="hidden" name="blog_id" value="{{$blog->id}}">
    <button style="border:none;background-color:white;" class="float-right">
      ({{$blog->likes->count()}}) <i class="fa fa-heart" style="font-size:36px;color:red;"></i>
    </button>
  </form>
</li>

  <form action="/storeLike" method="post">
    @csrf 
    <input type="hidden" name="blog_id" value="{{$blog->id}}">
    <button style="border:none;background-color:white;" class="float-right">
      ({{$blog->likes->count()}}) <i class="fa fa-heart-o" style="font-size:36px;"></i>
    </button>
  </form>
  @endif
</li>


    </ul>
        
    @empty 

    <h1 class="text-secondary text-center">No record</h1>
    @endforelse
     
    
    
    

</div>

{{--  paginator design   --}}


<div class="mt-5">
  {{$blogs->links()}}
    </div>
    
</div>
@endsection
