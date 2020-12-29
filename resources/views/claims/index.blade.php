@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Zgłoszenia użytkowników</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            
            @if($claims->count() == 0)
            <b>Brak zgłoszeń użytkowników.</b>
            @else
            <table class="table table-striped border text-center">
                
                <thead>
                    <tr class="table-secondary">
                        <th>Zgłoszenie nr</th>
                        <th>Zgłaszający użytkownik</th>
                        <th>Data wysłania zgłoszenia</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($claims as $claim)
                    <tr>
                        <td class="align-middle">{{ $claim->id }}</td>
                        <td class="align-middle">{{ $claim->transaction->user->username }}</td>
                        <td class="align-middle">{{ $claim->created_at }}</td>
                        <td class="align-middle"><a href="{{ route('claim.show', $claim) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i><span class="d-none d-lg-inline ml-2">Pokaż zgłoszenie</span></a></td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
            @endif

        </div>
    </div>

</div>
@endsection
