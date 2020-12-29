@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Edytuj adres</h1>
        </div>
    </div>


    <form action="{{ route('address.update') }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="form-group row">
            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('Imię') }}</label>

            <div class="col-md-6">
                <input id="firstName" 
                       type="text" 
                       class="form-control @error('firstName') is-invalid @enderror" 
                       name="firstName" 
                       value="{{ old('firstName') ?? auth()->user()->address->firstName }}" required 
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
                       value="{{ old('surname') ?? auth()->user()->address->surname }}" required 
                       autocomplete="surname" autofocus>

                @error('surname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Ulica') }}</label>

            <div class="col-md-6">
                <input id="street" 
                       type="text" 
                       class="form-control @error('street') is-invalid @enderror" 
                       name="street" 
                       value="{{ old('street') ?? auth()->user()->address->street }}" required 
                       autocomplete="street" autofocus>

                @error('street')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="number" class="col-md-4 col-form-label text-md-right">{{ __('Numer') }}</label>

            <div class="col-md-6">
                <input id="number" 
                       type="text" 
                       class="form-control @error('number') is-invalid @enderror" 
                       name="number" 
                       value="{{ old('number') ?? auth()->user()->address->number }}" required 
                       autocomplete="number" autofocus>

                @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="flat" class="col-md-4 col-form-label text-md-right">{{ __('Lokal') }}</label>

            <div class="col-md-6">
                <input id="flat" 
                       type="text" 
                       class="form-control @error('flat') is-invalid @enderror" 
                       name="flat" 
                       value="{{ old('flat') ?? auth()->user()->address->flat }}" 
                       autocomplete="flat" autofocus>

                @error('flat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="postalCode" class="col-md-4 col-form-label text-md-right">{{ __('Kod pocztowy') }}</label>

            <div class="col-md-6">
                <input id="postalCode" 
                       type="text" 
                       class="form-control @error('postalCode') is-invalid @enderror" 
                       name="postalCode" 
                       value="{{ old('postalCode') ?? auth()->user()->address->postalCode }}" required 
                       autocomplete="postalCode" autofocus>

                @error('postalCode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Miasto') }}</label>

            <div class="col-md-6">
                <input id="city" 
                       type="text" 
                       class="form-control @error('city') is-invalid @enderror" 
                       name="city" 
                       value="{{ old('city') ?? auth()->user()->address->city }}" required 
                       autocomplete="city" autofocus>

                @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Kraj') }}</label>

            <div class="col-md-6">
                <input id="country" type="text" class="form-control" name="country" value="Polska" disabled>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="phoneNumber" class="col-md-4 col-form-label text-md-right">{{ __('Numer telefonu') }}</label>

            <div class="col-md-6">
                <input id="phoneNumber" 
                       type="text" 
                       class="form-control @error('phoneNumber') is-invalid @enderror" 
                       name="phoneNumber" 
                       value="{{ old('phoneNumber') ?? auth()->user()->address->phoneNumber }}" 
                       autocomplete="phoneNumber" autofocus>

                @error('phoneNumber')
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
