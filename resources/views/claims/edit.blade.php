@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-1">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ url()->previous() }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Odpowiedz na zgłoszenie</h1>
        </div>
    </div>

    <form action="{{ route('claim.update', $claim) }}" method="post">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <label for="reply" class="col-md-4 col-form-label">{{ __('Odpowiedź') }}</label>

                    <textarea id="reply" 
                           class="form-control @error('reply') is-invalid @enderror" 
                           name="reply" 
                           required 
                           autocomplete="reply" autofocus>{{ old('reply') }}</textarea>

                    @error('reply')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $reply }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row mt-4">
                    <button class="btn btn-primary">Wyślij</button>
                    <a href="{{ route('claim.show', $claim) }}" class="btn btn-secondary ml-2">Anuluj</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
