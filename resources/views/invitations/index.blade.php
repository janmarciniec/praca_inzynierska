@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-1 mb-3">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">Skopiuj link i wyślij znajomemu, a po rejestracji otrzyma 3 dodatkowe tokeny.</div>

                <div class="card-body font-weight-bold">{{ $url }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
