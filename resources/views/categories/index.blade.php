@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-1">
        <div class="col-1 mr-3 mr-md-0">
            <a href="{{ route('user.index') }}" class="h1"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="col-10">
            <h1>Kategorie ogłoszeń</h1>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('category.create') }}" class="btn btn-primary btn-lg my-4"><i class="fas fa-plus mr-2"></i>Nowa kategoria</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($categories->count() == 0)
            <b>Brak kategorii ogłoszeń.</b>
            @else
            <table class="table table-striped border text-center">

                <thead>
                    <tr class="table-secondary">
                        <th>Nazwa kategorii</th>
                        <th>Liczba ogłoszeń</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ route('category.show', $category) }}"><b>{{ $category->name }}</b></a>
                        </td>
                        
                        <td class="align-middle">
                            {{ $category->items->count() }}
                        </td>
                        
                        <td class="d-flex">
                            <a href="{{ route('category.edit', $category) }}" class="btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i><span class="d-none d-lg-inline ml-1"> Edytuj nazwę</span></a>

                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCategoryModal{{ $category->id }}"><i class="fas fa-trash"></i><span class="d-none d-lg-inline ml-2">Usuń</span></button>

                            <form action="{{ route('category.destroy', $category) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModal{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteCategoryModal{{ $category->id }}">Czy na pewno chcesz usunąć kategorię?</h5>
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
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>    
</div>
@endsection
