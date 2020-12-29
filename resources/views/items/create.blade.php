@extends('layouts.app')

@section('content')
<div class="container">

    @auth
    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Dodaj ogłoszenie</h1>
        </div>
    </div>

    <form action="{{ route('item.store') }}" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Tytuł ogłoszenia <span class="text-danger">*</span></label>

                    <input id="title" 
                           type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           name="title" 
                           value="{{ old('title') }}" required 
                           autocomplete="title" autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Opis (minimum 10 znaków) <span class="text-danger">*</span></label>

                    <textarea id="description" 
                           class="form-control @error('description') is-invalid @enderror" 
                           name="description" 
                           required 
                           autocomplete="description" autofocus>{{ old('description') }}</textarea>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="location" class="col-md-4 col-form-label">Lokalizacja</label>

                    <input id="location" 
                           type="text" 
                           class="form-control @error('location') is-invalid @enderror" 
                           name="location" 
                           value="{{ old('location') ?? $location }}" 
                           autocomplete="location" autofocus>

                    @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group row">
                    <label for="category_id" class="col-md-4 col-form-label">Kategoria <span class="text-danger">*</span></label>

                    <select id="category_id" 
                            class="form-control @error('category_id') is-invalid @enderror" 
                            name="category_id"
                            required>
                        
                        <option value="" selected disabled hidden>Wybierz kategorię</option>
                                                
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        
                    </select>

                    @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <label for="image" class="col-md-4 col-form-label">Zdjęcie <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file mb-3" id="image" name="image">

                    @error('image')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <span class="text-danger">*</span> - pole obowiązkowe
                    </div>
                </div>
                
                <div class="row mt-4">
                    <button class="btn btn-primary mr-2">Dodaj ogłoszenie</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Anuluj</a>
                </div>

            </div>
        </div>
    </form>
    @endauth
    
    @guest
    <div class="row">
        <b>Zaloguj się, aby dodać ogłoszenie.</b>
    </div>
    @endguest
</div>
@endsection
