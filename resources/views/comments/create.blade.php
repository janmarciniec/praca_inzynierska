@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{route('comment.store', $transaction)}}" method="post">
                @csrf

                <div class="comment">
                    <input id="input-1" name="ratedindex" type="hidden">
                        <i class="fa fa-star" data-index="0"></i>
                        <i class="fa fa-star" data-index="1"></i>
                        <i class="fa fa-star" data-index="2"></i>
                        <i class="fa fa-star" data-index="3"></i>
                        <i class="fa fa-star" data-index="4"></i>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-md-4 col-form-label">{{ __('Komentarz') }}</label>

                    <textarea id="comment"
                              class="form-control @error('comment') is-invalid @enderror"
                              name="comment"
                              rows="4"
                              required
                              autocomplete="comment" autofocus
                              placeholder="Napisz komentarz oraz oceń transakcję.">{{ old('message') }}</textarea>

                    @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $comment }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row mt-4">
                    <button class="btn btn-primary">Dodaj</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary ml-2">Anuluj</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    var ratedindex = -1;
    $(document).ready(function () {
        resetStarColors();


        $('.fa-star').on('click', function () {
            ratedindex = parseInt($(this).data('index'));
            localStorage.setItem('ratedindex', ratedindex);
            document.getElementById("input-1").value = ratedindex;



        });
        $('.fa-star').mouseover(function () {
            resetStarColors();
            var currentindex = parseInt($(this).attr('data-index'));
            setStars(currentindex);

        });
        $('.fa-star').mouseleave(function () {
            //resetStarColors();
            if(ratedindex = !-1)
                setStars(ratedindex);


        });

    });
    function resetStarColors() {
        $('.fa-star').css('color', 'white');

    }
    function setStars(max) {
        for(var i=0; i<=max; i++)
            $('.fa-star:eq('+i+')').css('color', 'yellow');


    }


</script>

@endsection
