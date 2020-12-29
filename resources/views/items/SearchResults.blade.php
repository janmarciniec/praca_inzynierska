@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center my-2">
            <form action="{{ route('item.search') }}" method="get">
                <div class="form-group row">
                    <input type="text" class="search-input border-primary rounded p-2" name="query" id="query" value="{{ request()->input('query') }}" placeholder="Wyszukaj">
                    <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        
        <div class="row">
            @if(count($items)>0)
                @foreach($items as $item)
                    <div class="col-3 pb-4">
                        <a href="{{ route('item.show', $item) }}">
                            <div class="card">
                                <img class="card-img-top" src="http://localhost/wymianaUzywanychTowarow/public/storage/{{ $item->image }}" alt="" class="mw-100" style="max-height: 142px;">

                                <div class="card-body pb-0">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <h2>Brak ogłoszeń</h2>
            @endif
        </div>

    </div>
@endsection

