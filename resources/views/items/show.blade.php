@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12 mb-4">
                <a href="{{ route('category.show', $item->category) }}"><b><i class="fas fa-chevron-left mr-2"></i>Wróć do kategorii {{ $item->category->name }}</b></a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-8 text-center">
                <a href="http://localhost/wymianaUzywanychTowarow/public/storage/uploads/{{ $item->image }}" target="_blank"><img src="http://localhost/wymianaUzywanychTowarow/public/storage/uploads/{{ $item->image }}" alt="" class="mw-100" style="max-height: 600px;"></a>
            </div>

            <div class="col-12 col-lg-4 mt-2 mt-lg-0">

                <div class="row">

                    <div class="col-md-6 col-lg-12">
                        <div class="h1">{{ $item->title }}</div>

                        @if($item->user_id != null)
                            <div>Dodane przez: <a href="#" data-toggle="modal" data-target="#showSellerModal"><span class="h5">{{ $item->user->username }}</span></a></div>

                            <div class="modal fade text-center" id="showSellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title  font-weight-bold" id="exampleModalLabel">{{ $item->user->username }}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-left mt-2"><span class="h6">Imię i nazwisko: </span><span class="h5">{{ $item->user->firstName }} {{ $item->user->surname }}</span></div>
                                            <div class="text-left mt-3">
                                                <span class="h6">Liczba ogłoszeń: </span><span class="h5">{{ $item->user->items->where('availability', 1)->count() }}</span>
                                                <a href="{{ route('user.items', $item->user) }}" class="btn btn-primary ml-4">Ogłoszenia użytkownika</a>
                                            </div>
                                            <div class="h5 mt-5">Ocena użytkownika:</div>
                                            <div class="h3" id="rating3">
                                                <input id="input-1" name="ratedindex" type="hidden">
                                                <i class="fa fa-star" data-index="0"></i>
                                                <i class="fa fa-star" data-index="1"></i>
                                                <i class="fa fa-star" data-index="2"></i>
                                                <i class="fa fa-star" data-index="3"></i>
                                                <i class="fa fa-star" data-index="4"></i>
                                                <span class="ml-2">{{ round($item->user->comments->where('user_id', $item->user->id)->avg('rating'),2) }} / 5</span>
                                            </div>
                                            <a href="{{ route('comment.usercomments', $item->user) }}" class="btn btn-primary ml-4 mt-2">Komentarze o użytkowniku</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>Dodane przez: <span class="h5">konto usunięte</span></div>
                        @endif

                        @if($item->location != null)
                            <div class="h5 mt-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $item->location }}
                            </div>
                        @endif

                        <hr>
                        <div>
                            <h5>Opis:</h5>
                            <p>{{ $item->description }}</p>
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6 col-lg-12">
                        <!--jeśli nikt nie kupił przedmiotu-->
                        @if($item->availability == 1)
                            @auth
                                @can('update', $item)
                                    <a href="{{ route('item.edit', $item->id) }}" class="btn btn-primary btn-block mt-4 mt-lg-5 py-3"><i class="far fa-edit mr-2"></i>Edytuj ogłoszenie</a>
                                @endcan

                                @can('transfer', $item)
                                    <a href="{{ route('item.transfer', $item->id) }}" class="btn btn-primary btn-block mt-4 mt-lg-5 py-3"><i class="fas fa-exchange-alt mr-2"></i>Przenieś do innej kategorii</a>
                                @endcan

                                @can('delete', $item)
                                    <button class="btn btn-danger btn-block mt-1 py-3" data-toggle="modal" data-target="#deleteItemModal"><i class="far fa-trash-alt mr-2"></i>Usuń ogłoszenie</button>

                                    <form action="{{ route('item.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz usunąć ogłoszenie?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                        <button type="submit" class="btn btn-danger">Usuń</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endcan

                                @can('buy', $item)
                                <a href="{{ route('item.buy', $item->id) }}" class="btn btn-primary btn-block mt-4 mt-lg-5 py-4"><span class="h3"><i class="fas fa-shopping-cart mr-2"></i>Kup teraz</span></a>
                                    @if($item->user->conversations)
                                        <a href="{{ route('message.create', $item->user) }}" class="btn btn-primary btn-block mt-3 py-3"><span class="h5"><i class="fas fa-envelope mr-2"></i>Napisz wiadomość</span></a>
                                    @else
                                        <a href="{{ route('message.create', $item->user) }}" class="btn btn-primary btn-block mt-3 py-3"><span class="h5"><i class="fas fa-envelope mr-2"></i>Napisz wiadomość</span></a>
                                    @endif
                                @endcan

                            <!--Jedynym użytkownikiem, który nie może edytować adresu jest administrator - nie będzie mu się wyświetlała informacja o braku tokenów-->
                                @can('update', App\Address::class)
                                    @if(auth()->user()->tokens <= 0)
                                        <b>Nie masz wystarczająco dużo środków, aby kupić ten przedmiot.</b>
                                            <a href="{{ route('message.create', $item->user) }}" class="btn btn-primary btn-block mt-4 mt-lg-5 py-3">Napisz wiadomość</a>

                                        @endif
                                @endauth
                            @endcan

                            @guest
                                <b>Zaloguj się, aby kupić przedmiot.</b>
                            @endguest
                        <!--jeśli ktoś kupił przedmiot-->
                        @else
                            <button type="button" class="btn btn-danger btn-block mt-4 mt-lg-5 py-3" disabled>Ogłoszenie nieaktualne.</button>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
