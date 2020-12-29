@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center mt-2 mb-4">
        <form action="{{ route('search') }}" method="get">
            <div class="form-group row">
                <input type="text" class="search-input border-primary rounded p-2" name="query" id="query" value="{{ request()->input('query') }}" placeholder="Wyszukaj">
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    
    <div class="row">
        @foreach($categories as $category)
        <div class="col-6 col-sm-4 col-md-3 col-xl-2">
            <a href="{{ route('category.show', $category) }}" class="btn btn-info btn-block btn-lg py-5 mb-4 text-white">{{ $category->name }}</a>
        </div>
        @endforeach
    </div>
    
</div>
@endsection
