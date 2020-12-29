@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ url()->previous() }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Przenieś ogłoszenie do innej kategorii</h1>
        </div>
    </div>

    <form action="{{ route('item.update', $item->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')
        
        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <label for="category_id" class="col-md-4 col-form-label">{{ __('Nowa kategoria') }}</label>

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

                <div class="row mt-4">
                    <button class="btn btn-primary mr-2">Zapisz zmiany</button>
                    <a href="{{ URL::previous() }}" class="btn btn-secondary">Anuluj</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
