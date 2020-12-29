@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="#" data-toggle="modal" data-target="#deleteTransactionModal" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Potwierdzenie</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="h3">Kupiony przedmiot: </div>
            <div><a href="{{ route('item.show', $transaction->item->id) }}" target="_blank"><b>{{ $transaction->item->title }}</b></a></div>
        </div>

        <div class="col-12 col-lg-6 mt-5 mt-lg-0">
            @if($transaction->deliveryAddress != null)
            <div class="h3">Adres dostawy: </div>
            <table>
                <tr>
                    <td align="right" class="font-weight-bold">Imię i nazwisko:</td>
                    <td class="pl-3">{{ $transaction->deliveryAddress->firstName }} {{ $transaction->deliveryAddress->surname }}</td>
                </tr>
                <tr>
                    <td align="right" class="font-weight-bold">Adres:</td>
                    <td class="pl-3">
                        {{ $transaction->deliveryAddress->street }} {{ $transaction->deliveryAddress->number }}
                        @if($transaction->deliveryAddress->flat != null)
                        / {{ $transaction->deliveryAddress->flat }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td align="right" class="font-weight-bold">Miejscowość:</td>
                    <td class="pl-3">{{ $transaction->deliveryAddress->postalCode }} {{ $transaction->deliveryAddress->city }}</td>
                </tr>
                <tr>
                    <td align="right" class="font-weight-bold">Kraj:</td>
                    <td class="pl-3">Polska</td>
                </tr>
                @if($transaction->deliveryAddress->phoneNumber != null)
                <tr>
                    <td align="right" class="font-weight-bold">Numer telefonu:</td>
                    <td class="pl-3">{{ $transaction->deliveryAddress->phoneNumber }}</td>
                </tr>
                @endif
            </table>
            <b>
                <hr>
                Skontaktuj się ze sprzedawcą w celu uzgodnienia płatności za przesyłkę.
            </b>
            @else
            <b>Umów się ze sprzedawcą na termin i miejsce odbioru przedmiotu.</b>
            @endif
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-12 d-flex">
            
            <form action="{{ route('transaction.save', $transaction) }}" method="post">
                @csrf
                <button class="btn btn-primary mr-2 btn-lg"><i class="fas fa-check"></i> Potwierdź zakup</button>
            </form>

            <button class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#deleteTransactionModal"><i class="fas fa-window-close"></i> Anuluj</button>

            <form action="{{ route('transaction.destroy', $transaction) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal fade" id="deleteTransactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Anulować transakcję?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
                                <button type="submit" class="btn btn-danger">Tak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
