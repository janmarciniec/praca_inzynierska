@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <h1><a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Szczegóły transakcji</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-4">
            <div class="h5">Sprzedano użytkownikowi:</div>
            <table>
                <tr>
                    <td align="right" class="font-weight-bold">Nazwa użytkownika:</td>
                    <td class="pl-3">{{ $transaction->user->username }}</td>
                </tr>
                <tr>
                    <td align="right" class="font-weight-bold">Imię i nazwisko:</td>
                    <td class="pl-3">{{ $transaction->user->firstName }} {{ $transaction->user->surname }}</td>
                </tr>
            </table>
        </div>

        <div class="col-4">
            <div class="h5">Sprzedany przedmiot:</div>
            <div>{{ $transaction->item->title }}</div>
        </div>

        <div class="col-4">
            <div class="h5">Data sprzedaży:</div>
            <!--updated_at a nie created_at, bo data sprzedaży to data zmiany statusu transakcji na potwierdzony, a nie data utworzenia transakcji-->
            <div>{{ $transaction->updated_at }}</div>
        </div>

    </div>

    @if($transaction->deliveryAddress != null)
    <div class="row">

        <div class="col-12 col-md-6 col-lg-5 col-xl-4">
            <div class="h5">Adres wysyłki:</div>
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
        </div> 

        <div class="col-10 col-md-6 col-xl-5 mt-5 mt-md-0">
            <b>
                {{ $transaction->user->firstName }} {{ $transaction->user->surname }} prosi o wysłanie przedmiotu na podany adres.
                <hr>
                Skontaktujcie się w celu uzgodnienia płatności za przesyłkę.
            </b>
        </div> 

    </div>
    @else
    <div class="row">

        <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <b>
                {{ $transaction->user->firstName }} {{ $transaction->user->surname }} chce osobiście odebrać zamówiony przedmiot.
                <hr>
                Skontaktujcie się w celu uzgodnienia czasu i miejsca spotkania.
            </b>
        </div>

    </div>
    @endif

</div>
@endsection
