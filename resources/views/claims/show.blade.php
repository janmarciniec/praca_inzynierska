@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row pb-5">
        <div class="col-8">
            @can('update', $claim)
                <h1 class="mb-4"><a href="{{ route('claim.index') }}" class="mr-3"><i class="fas fa-arrow-circle-left"></i></a>Zgłoszenie #{{ $claim->id }}</h1>
            @endcan
            
            @cannot('update', $claim)
                <h1 class="mb-4"><a href="{{ route('user.index') }}" class="mr-3"><i class="fas fa-arrow-circle-left"></i></a>Zgłoszenie #{{ $claim->id }}</h1>
            @endcan
            
            @if($claim->transaction->item->user_id != null)
            
            <h4>Zgłoszony użytkownik: <span class="font-weight-bold">{{ $claim->transaction->item->user->username }}</span></h4>

            <h4>Imię i nazwisko: {{ $claim->transaction->item->user->firstName }} {{ $claim->transaction->item->user->surname }}</h4>
            
            @else
            <h4>Zgłoszony użytkownik: <span class="font-weight-bold">Konto usunięte</span></h4>
            @endif
            
            <h4>Tytuł ogłoszenia: {{ $claim->transaction->item->title }}</h4>
            <h4>Data transakcji: {{ $claim->transaction->updated_at }}</h4>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            
            <h5>Treść zgłoszenia:</h5>
            <div class="border rounded p-3">
                <div>{{ $claim->message }}</div>
            </div>

            @can('update', $claim)
            <a href="{{ route('claim.edit', $claim) }}" class="btn btn-secondary mt-3"><i class="fas fa-comment-dots mr-2"></i>Odpowiedz</a>
            @endcan
            
            @if($claim->reply != null)
            <h5 class="mt-4">Odpowiedź:</h5>
            <div class="border rounded p-3">
                <div>{{ $claim->reply }}</div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
