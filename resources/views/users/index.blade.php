@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-6 col-lg-4">
            <div class="h1">Cześć, {{ auth()->user()->firstName }}!</div>
            <!--Jedynym użytkownikiem, który nie może edytować adresu jest administrator - na jego profilu nie będzie wyświetlać się liczba tokenów ani ogłoszeń-->
            @can('update', App\Address::class)
            <div><span class="h5">Portfel tokenów: </span><span class=h3>{{ auth()->user()->tokens }}</span></div>
            @endcan
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('user.edit') }}" class="btn btn-primary btn-block"><i class="fas fa-user-edit mr-2"></i>Edytuj profil</a>
        @can('update', App\Address::class)
            <a href="{{ route('address.edit') }}" class="btn btn-primary btn-block"><i class="fas fa-address-card mr-2"></i>Edytuj adres</a>
        @endcan
        </div>
    </div>

    @can('create', App\Item::class)
    <div class="row mt-3">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('item.create') }}" class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i>Dodaj ogłoszenie</a>
        </div>
    </div>
    @endcan

    @can('viewAny', App\Claim::class)
    <div class="row mt-3">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('accounts.index') }}" class="btn btn-primary btn-lg btn-block"><i class="fas fa-users-cog mr-2"></i>Konta użytkowników</a>
        </div>
    </div>
    @endcan

    @can('viewAny', App\Category::class)
    <div class="row mt-2">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-lg btn-block">Zarządzaj kategoriami ogłoszeń</a>
        </div>
    </div>
    @endcan

    @can('viewAny', App\Claim::class)
    <div class="row mt-2">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('claim.index') }}" class="btn btn-primary btn-lg btn-block"><i class="fas fa-comments mr-2"></i>Zgłoszenia użytkowników</a>
        </div>
    </div>
    @endcan

    @can('viewAny', App\Invitation::class)
    <div class="row mt-2">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('invitation.index') }}" class="btn btn-primary btn-block"><i class="fas fa-users mr-2"></i>Zaproś znajomych do rejestracji</a>
        </div>
    </div>
    @endcan

    @can('delete', auth()->user())
    <div class="row mt-2">
        <div class="col-md-6 col-lg-4">
            <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteUserModal"><i class="fas fa-user-alt-slash mr-2"></i>Usuń konto</button>

            <form action="{{ route('user.destroy', auth()->user()) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz usunąć konto?</h5>
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
        </div>
    </div>
    @endcan

    <!--Jedynym użytkownikiem, który nie może edytować adresu jest administrator - na jego profilu nie będą się wyświetlać ogłoszenia ani historia transakcji-->
    @can('update', App\Address::class)
    <div class="row">
        <div class="col-8 col-md-12 pt-5 pb-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#items" class="nav-link h5 active" role="tab" data-toggle="tab">Moje ogłoszenia ({{ auth()->user()->items->where('availability', 1)->count() }})</a>
                </li>
                <li class="nav-item">
                    <a href="#sold" class="nav-link h5" role="tab" data-toggle="tab">Sprzedane przedmioty ({{ auth()->user()->items->where('availability', 0)->count() }})</a>
                </li>
                <li class="nav-item">
                    <a href="#bought" class="nav-link h5" role="tab" data-toggle="tab">Kupione przedmioty ({{ auth()->user()->transactions->where('status', 'confirmed')->count() }})</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">

       <div role="tabpanel" class="tab-pane fadeIn active" id="items">
            <!-- jeśli liczba ogłoszeń użytkownika jest równa 0 lub wszystkie ogłoszenia mają status niedostępnych -->
           @if(auth()->user()->items->count() == 0 || (auth()->user()->items->every(function ($value, $key) { return $value->availability == 0; }) == true))
           <b>Brak ogłoszeń.</b>
           @else
           <div class="row">
               <div class="col-12">
                   <table class="table table-striped border text-center">

                       <thead>
                            <tr class="table-secondary">
                                <th>Tytuł</th>
                                <th>Dodano</th>
                                <th></th>
                            </tr>
                       </thead>

                       <tbody>
                            @foreach(auth()->user()->items as $item)
                            @if($item->availability == 1)
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ route('item.show', $item->id) }}"><b>{{ $item->title }}</b></a>
                                </td>
                                <td class="align-middle">
                                    {{ $item->created_at }}
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('item.edit', $item) }}" class="btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i><span class="d-none d-lg-inline ml-2">Edytuj</span></a>

                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteItemModal{{ $item->id }}"><i class="fas fa-trash"></i><span class="d-none d-lg-inline ml-2">Usuń</span></button>

                                    <form action="{{ route('item.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                </td>
                            </tr>
                            @endif
                            @endforeach
                       </tbody>

                   </table>
               </div>
           </div>
           @endif
       </div>

       <div role="tabpanel" class="tab-pane fade" id="sold">
            <!-- jeśli każdy z przedmiotów jest albo niepowiązany transakcją, albo powiązany z niepotwierdzoną transakcją -->
           @if(auth()->user()->items->every(function ($value, $key) { return $value->transaction == null || $value->transaction->status == 'unconfirmed'; }) == true)
           <b>Brak sprzedanych przedmiotów.</b>
           @else
           <div class="row">
               <div class="col-12">
                   <table class="table table-striped border text-center">

                       <thead>
                            <tr class="table-secondary">
                                <th class="align-middle">Przedmiot</th>
                                <th>Data sprzedaży</th>
                                <th>Sprzedano użytkownikowi</th>
                                <th></th>
                                <th></th>
                            </tr>
                       </thead>

                       <tbody>
                            @foreach(auth()->user()->items as $item)
                            <!-- sprawdzenie, czy przedmiot jest powiązany z transakcją oraz czy transakcja została potwierdzona -->
                            @if($item->transaction != null && $item->transaction->status == 'confirmed')
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ route('item.show', $item->id) }}">{{ $item->title }}</a>
                                </td>
                                <td class="align-middle">
                                    <!-- updated_at a nie created_at, bo data sprzedaży to data zmiany statusu transakcji na potwierdzony, a nie data utworzenia transakcji -->
                                    {{ $item->transaction->updated_at }}
                                </td>
                                <td class="align-middle">
                                    @if($item->transaction->user_id != null)
                                    <a href="#" data-toggle="modal" data-target="#showBuyerModal{{ $item->transaction->user->id }}">{{ $item->transaction->user->username }}</a>
                                    
                                    <div class="modal fade" id="showBuyerModal{{ $item->transaction->user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title  font-weight-bold" id="exampleModalLabel">{{ $item->transaction->user->username }}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-left mt-2"><span class="h6">Imię i nazwisko: </span><span class="h5">{{ $item->transaction->user->firstName }} {{ $item->transaction->user->surname }}</span></div>
                                                    <div class="text-left mt-3">
                                                        <span class="h6">Liczba ogłoszeń: </span><span class="h5">{{ $item->transaction->user->items->where('availability', 1)->count() }}</span>
                                                        <a href="{{ route('user.items', $item->transaction->user) }}" class="btn btn-primary ml-4">Ogłoszenia użytkownika</a>
                                                    </div>
                                                    <div class="h5 mt-5">Ocena użytkownika:</div>
                                                    <div class="h3" id="rating3">
                                                        <input id="input-1" name="ratedindex" type="hidden">
                                                        @for($i=0;$i<$item->transaction->user->comments->where('user_id', $item->transaction->user->id)->avg('rating')-1;$i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                        <span class="ml-2">{{ round($item->transaction->user->comments->where('user_id', $item->transaction->user->id)->avg('rating'),2) }} / 5</span>
                                                    </div>
                                                    <a href="{{ route('comment.usercomments', $item->transaction->user) }}" class="btn btn-primary ml-4 mt-2">Komentarze o użytkowniku</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    Konto usunięte
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#restoreItemModal{{ $item->id }}"><i class="fas fa-undo"></i><span class="d-none d-lg-inline ml-2">Przywróć ogłoszenie</span></button>

                                    <div class="modal fade" id="restoreItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz przywrócić przedmiot do sprzedaży?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Informacje o transakcji zostaną bezpowrotnie usunięte.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                    <a href="{{ route('item.restore', $item) }}" class="btn btn-primary">Przywróć</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if($item->transaction->user_id != null)
                                    <a href="{{ route('transaction.show', $item->transaction->id) }}" class="btn-sm font-weight-bold"><i class="fas fa-info-circle"></i><span class="d-none d-lg-inline ml-2">Szczegóły</span></a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                       </tbody>

                   </table>
               </div>
           </div>
           @endif
       </div>

       <div role="tabpanel" class="tab-pane fade" id="bought">
            <!-- jeśli liczba transakcji jest równa 0 lub wszystkie transakcje są niepotwierdzone -->
           @if((auth()->user()->transactions->count() == 0) || (auth()->user()->transactions->every(function ($value, $key) { return $value->status == 'unconfirmed'; }) == true))
           <b>Brak kupionych przedmiotów.</b>
           @else
           <div class="row">
               <div class="col-12">
                   <table class="table table-striped border text-center">

                       <thead>
                            <tr class="table-secondary">
                                <th class="align-middle">Przedmiot</th>
                                <th class="align-middle">Data zakupu</th>
                                <th>Kupiono od użytkownika</th>
                                <th></th>
                            </tr>
                       </thead>

                       <tbody>
                            @foreach(auth()->user()->transactions as $transaction)
                            <!-- sprawdzenie, czy transakcja została potwierdzona -->
                            @if($transaction->status == 'confirmed')
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ route('item.show', $transaction->item->id) }}">{{ $transaction->item->title }}</a>
                                </td>
                                <td class="align-middle">
                                    <!-- updated_at a nie created_at, bo data zakupu to data zmiany statusu transakcji na potwierdzony, a nie data utworzenia transakcji -->
                                    {{ $transaction->updated_at }}
                                </td>
                                <td class="align-middle">
                                    @if($transaction->item->user_id != null)
                                    <a href="#" data-toggle="modal" data-target="#showSellerModal{{ $transaction->item->user->id }}">{{ $transaction->item->user->username }}</a>

                                    <div class="modal fade" id="showSellerModal{{ $transaction->item->user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title  font-weight-bold" id="exampleModalLabel">{{ $transaction->item->user->username }}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-left mt-2"><span class="h6">Imię i nazwisko: </span><span class="h5">{{ $transaction->item->user->firstName }} {{ $transaction->item->user->surname }}</span></div>
                                                    <div class="text-left mt-3">
                                                        <span class="h6">Liczba ogłoszeń: </span><span class="h5">{{ $transaction->item->user->items->where('availability', 1)->count() }}</span>
                                                        <a href="{{ route('user.items', $transaction->item->user) }}" class="btn btn-primary ml-4">Ogłoszenia użytkownika</a>
                                                    </div>
                                                    <div class="h5 mt-5">Ocena użytkownika:</div>
                                                    <div class="h3" id="rating2">
                                                        <input id="input-1" name="ratedindex" type="hidden">
                                                        @for($i=0;$i<$transaction->item->user->comments->where('user_id', $transaction->item->user->id)->avg('rating')-1;$i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                        <span class="ml-2">{{ round($transaction->item->user->comments->where('user_id', $transaction->item->user->id)->avg('rating'),2) }} / 5</span>
                                                    </div>
                                                    <a href="{{ route('comment.usercomments', $transaction->item->user) }}" class="btn btn-primary ml-4 mt-2">Komentarze o użytkowniku</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    Konto usunięte
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @if($transaction->comment == null)
                                    <a href="{{ route('comment.create', $transaction) }}" class="btn btn-secondary btn-sm mr-2 mr-lg-3"><i class="fas fa-comment-medical"></i><span class="d-none d-lg-inline ml-2">Napisz komentarz</span></a>
                                    @else
                                            <a href="{{ route('comment.show', $transaction->comment) }}" class="btn btn-outline-secondary btn-sm mr-2 mr-lg-3"><i class="far fa-comment"></i><span class="d-none d-lg-inline ml-2">Pokaż komentarz</span></a>
                                    @endif

                                    @if($transaction->claim == null)
                                    <a href="{{ route('claim.create', $transaction) }}" class="btn btn-secondary btn-sm"><i class="fas fa-exclamation-triangle"></i><span class="d-none d-lg-inline ml-2">Zgłoś problem</span></a>
                                    @else
                                    <a href="{{ route('claim.show', $transaction->claim) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-exclamation-triangle"></i><span class="d-none d-lg-inline ml-2">Pokaż zgłoszenie</span></a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                       </tbody>

                   </table>
               </div>
           </div>
           @endif
       </div>

    </div>
    @endcan
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function () {
            resetStarColors();

        });
        function resetStarColors() {
            $('.fa-star').css('color', 'yellow')};

    </script>
</div>
@endsection
