@extends('../layouts.app')

@section('content')
<div class="container">

    <h1 class="text-secondary text-center">Form Page</h1>

  

    <form action="store" method="post" class="form-group col-md-6 offset-3" enctype="multipart/form-data">
        @csrf
       
        <input placeholder="title" name="title" type="text" class="form-control mt-2 @error('title') is-invalid @enderror"  value="{{old('title')}}">
        @error('title')
       <span class="text-danger">{{ $message }}</span>
        @enderror

        <input placeholder="content" name="content" type="text" class="form-control mt-2 @error('content') is-invalid @enderror"  value="{{old('content')}}">
        @error('content')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <select class="form-control" name="category_id" id="">
            @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>

            @endforeach

            

        </select>

        <input name="photo" type="file" class="form-control mt-2">
        @error('photo')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <button class="btn btn-outline-success mt-2 form-control">save</button>

    </form>
</div>
@endsection