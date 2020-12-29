@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ url()->previous() }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Zgłoś problem dotyczący transakcji</h1>
        </div>
    </div>

    <form action="{{ route('claim.store', $transaction) }}" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="form-group row">
                    <label for="message" class="col-md-4 col-form-label">{{ __('Treść zgłoszenia') }}</label>

                    <textarea id="message" 
                           class="form-control @error('message') is-invalid @enderror" 
                           name="message" 
                           rows="4"
                           required 
                           autocomplete="message" autofocus
                           placeholder="Opisz problem ze sprzedawcą lub zakupionym przedmiotem. Po rozpatrzeniu zgłoszenia, poinformujemy Cię o dalszym postępowaniu.">{{ old('message') }}</textarea>

                    @error('message')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row mt-4">
                    <button class="btn btn-primary">Wyślij</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary ml-2">Anuluj</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
