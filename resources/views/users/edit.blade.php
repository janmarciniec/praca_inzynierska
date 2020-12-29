@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Edytuj profil</h1>
        </div>
    </div>

    <form action="{{ route('user.update') }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="form-group row">
            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('Imię') }}</label>

            <div class="col-md-6">
                <input id="firstName" 
                       type="text" 
                       class="form-control @error('firstName') is-invalid @enderror" 
                       name="firstName" 
                       value="{{ old('firstName') ?? auth()->user()->firstName }}" required 
                       autocomplete="firstName" autofocus>

                @error('firstName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Nazwisko') }}</label>

            <div class="col-md-6">
                <input id="surname" 
                       type="text" 
                       class="form-control @error('surname') is-invalid @enderror" 
                       name="surname" 
                       value="{{ old('surname') ?? auth()->user()->surname }}" required 
                       autocomplete="surname" autofocus>

                @error('surname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row pt-4 offset-4">
            <button class="btn btn-primary mr-2">Zapisz zmiany</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Anuluj</a>
        </div>

    </form>
</div>
@endsection
