@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Potwierdź adres e-mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link weryfikacyjny został ponownie wysłany na Twój adres e-mail.') }}
                        </div>
                    @endif

                    {{ __('Na Twój adres e-mail został wysłany link weryfikujący. Kliknij go, aby móc korzystać z pełni możliwości konta.') }}<br/>
                    {{ __('Jeśli nie otrzymałeś e-maila') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kliknij tutaj, a zostanie on wysłany ponownie') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
