@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="#" data-toggle="modal" data-target="#deleteTransactionModal" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Wybierz metodę dostawy:</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-md-5 col-lg-4 col-xl-3">
            <a href="{{ route('deliveryAddress.create', $item->transaction->id) }}" class="btn btn-primary btn-block py-5 btn-lg"><i class="fas fa-shipping-fast"></i> Wysyłka</a>
        </div>
        <div class="col-6 col-md-5 col-lg-4 col-xl-3">
            <a href="{{ route('transaction.confirm', $item->transaction->id) }}" class="btn btn-primary btn-block py-5 btn-lg"><i class="fas fa-map-marker-alt"></i> Odbiór osobisty</a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            
            <button class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#deleteTransactionModal"><i class="fas fa-window-close"></i> Anuluj</button>

            <form action="{{ route('transaction.destroy', $item->transaction->id) }}" method="post">
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
