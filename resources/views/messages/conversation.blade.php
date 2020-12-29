@extends('layouts.app')

@section('content')

        @foreach($messages as $message)
            <div class="row" id = "autodata">
                @if ($message->user_id == auth()->user()->id)<div class="col-md-8 offset-md-6 col-lg-5 pb-4"><div class = "card text-white bg-primary mb-3"> @else <div class="col-md-8 offset-2 col-lg-5 pb-4"> <div class ="card">@endif


                            <div class = "card-body pb-0">
                                <h5 class="card-title">{{$message->message}}</h5>
                                <p>{{date_format($message->created_at,"m/d H:i:s")}}</p>
                            </div>
                        </div>

            </div>
            </div>
                </div>
            </div>
        @endforeach

    <div class="container">


        <form action="{{ route('message.store2', $conversation) }}" method="post">
            @csrf

            <div class="row">
                <div class="col-8 offset-2">

                    <div class="form-group row">
                        <label for="message" class="col-md-4 col-form-label">{{ __('Treść wiadomości') }}</label>

                        <textarea id="message"
                                  class="form-control @error('message') is-invalid @enderror"
                                  name="message"
                                  rows="4"
                                  required
                                  autocomplete="message" autofocus
                        >{{ old('message') }}</textarea>

                        @error('message')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <button class="btn btn-primary">Wyślij</button>
                        <a href="{{ route('message.show') }}" class="btn btn-secondary ml-2">Anuluj</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection


