@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Konta użytkowników</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($users->count() == 0)
            <b>Brak kont użytkowników.</b>
            @else
            <table class="table table-striped border text-center">

                <thead>
                    <tr class="table-secondary">
                        <th>Nazwa użytkownika</th>
                        <th class="align-middle">Data rejestracji</th>
                        <th>Liczba tokenów</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="align-middle">
                            <a href="#" data-toggle="modal" data-target="#showUserModal{{ $user->id }}"><b>{{ $user->username }}</b></a>

                            <div class="modal fade" id="showUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title  font-weight-bold" id="exampleModalLabel">{{ $user->username }}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-left mt-2"><span class="h6">Imię i nazwisko: </span><span class="h5">{{ $user->firstName }} {{ $user->surname }}</span></div>
                                            <div class="text-left mt-3">
                                                <span class="h6">Liczba ogłoszeń: </span><span class="h5">{{ $user->items->where('availability', 1)->count() }}</span>
                                                <a href="{{ route('user.items', $user) }}" class="btn btn-primary ml-4">Ogłoszenia użytkownika</a>
                                            </div>
                                            <div class="h5 mt-5">Ocena użytkownika:</div>
                                            <div class="h3" id="rating2">
                                                <input id="input-1" name="ratedindex" type="hidden">
                                                @for($i=0;$i<$user->comments->where('user_id', $user->id)->avg('rating')-1;$i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                                <span class="ml-2">{{ round($user->comments->where('user_id', $user->id)->avg('rating'),2) }} / 5</span>
                                            </div>
                                            <a href="{{ route('comment.usercomments', $user) }}" class="btn btn-primary ml-4 mt-2">Komentarze o użytkowniku</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="align-middle">
                            {{ $user->created_at }}
                        </td>

                        <td class="align-middle">
                            <b>{{ $user->tokens }}</b>
                            <a href="#" data-toggle="modal" data-target="#editTokensModal{{ $user->id }}" class="ml-1 btn-sm"> <i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('accounts.update', $user) }}" enctype="multipart/form-data" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="modal fade" id="editTokensModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label for="title" class="col-md-4 col-form-label mr-3">Liczba tokenów użytkownika <b>{{ $user->username }}</b></label>
                                                <div class="d-flex align-items-baseline">
                                                    <div class="form-group row">
                                                        <input id="tokens" 
                                                               type="text" 
                                                               class="form-control @error('tokens') is-invalid @enderror" 
                                                               name="tokens" 
                                                               value="{{ $user->tokens }}" required 
                                                               autocomplete="tokens" autofocus>

                                                        @error('tokens')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                <button type="submit" class="btn btn-primary">Zapisz</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>

                        <td class="d-flex">
                            <a href="#" data-toggle="modal" data-target="#WriteMailModal{{ $user->id }}" class="btn btn-secondary btn-sm mr-2 mr-lg-3"><i class="far fa-envelope"></i><span class="d-none d-lg-inline ml-2">Wyślij wiadomość</span></a>
                            <form action="{{ route('accounts.send-mail', $user) }}" enctype="multipart/form-data" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="modal fade" id="WriteMailModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Nowa wiadomość do użytkownika <b>{{ $user->username }}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row m-1">
                                                    <input id="subject" 
                                                           type="text" 
                                                           class="form-control @error('subject') is-invalid @enderror" 
                                                           name="subject" 
                                                           value="{{ old('subject') }}" required 
                                                           autocomplete="subject" autofocus
                                                           placeholder="Temat">

                                                    @error('subject')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group row m-1">
                                                    <textarea id="content" 
                                                              class="form-control @error('content') is-invalid @enderror" 
                                                              name="content" 
                                                              required 
                                                              autocomplete="content" autofocus
                                                              rows="15">{{ old('content') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                <button type="submit" class="btn btn-primary">Wyślij</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal{{ $user->id }}"><i class="fas fa-user-slash"></i><span class="d-none d-lg-inline ml-2">Usuń konto</span></button>

                            <form action="{{ route('user.destroy', $user) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Usuń konto użytkownika <b>{{ $user->username }}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row m-1">
                                                    <label for="explanation" class="col-12 col-form-label text-md-left">{{ __('Powód usunięcia konta:') }}</label>
                                                    <textarea id="explanation" 
                                                              class="form-control @error('explanation') is-invalid @enderror" 
                                                              name="explanation" 
                                                              required 
                                                              autocomplete="explanation" autofocus
                                                              rows="5">{{ old('explanation') }}</textarea>
                                                </div>
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
                    @endforeach
                </tbody>

            </table>
            @endif
        </div>
    </div>    
</div>
@endsection
