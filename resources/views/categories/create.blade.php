@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-1">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ url()->previous() }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Dodaj kategorię ogłoszeń</h1>
        </div>
    </div>

    <form action="{{ route('category.store') }}" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label">{{ __('Nazwa kategorii') }}</label>

                    <input id="name" 
                           type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           name="name" 
                           value="{{ old('name') }}" required 
                           autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row mt-4">
                    <button class="btn btn-primary">Dodaj kategorię</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Anuluj</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
