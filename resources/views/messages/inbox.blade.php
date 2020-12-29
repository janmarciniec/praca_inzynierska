@extends('layouts.app')

@section('content')
    <div class="row">

        @if($conversations->count() == 0)
            <h2>Brak konwersacji.</h2>
        @else
            @foreach($conversations as $conversation)
                <div class="col-6 offset-2 col-md-4 col-lg-3 pb-4">

                        <div class="card">

                            <div class="card-body pb-0">
                                <a href="{{ route('message.conversation', $conversation) }}">
                                <h5 class="card-title">{{ $conversation->contact->username }}</h5>
                                    </a>
                                <p>{{$conversation->messages->last()->message}}</p>
                            </div>

                        </div>

                </div>
            @endforeach
        @endif
    </div>
@endsection
