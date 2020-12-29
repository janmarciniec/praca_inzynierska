@extends('layouts.app')

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card card-white post">
                    <div class="post-heading">
                        <div class="float-left meta">
                            <div class="title h5">
                                <a>{{$comment->comment}}</a>
                            </div>
                            <h6 class="text-muted time">{{$comment->created_at}}</h6>
                        </div>
                    </div>
                    <div class="post-description">
                        <p>{{$comment->transaction->user->username}}</p>
                    </div>
                    <div class="post-description">
                        <div class="comment">
                            <input id="input-1" name="ratedindex" type="hidden">
                            @for($i=0;$i<$comment->rating;$i++)
                                <i class="fa fa-star"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function () {
            resetStarColors();
        });
        function resetStarColors() {
            $('.fa-star').css('color', 'yellow');

        }



    </script>
@endsection
