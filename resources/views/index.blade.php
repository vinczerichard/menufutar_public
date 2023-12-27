@extends('adminlte::page')

@section('content_header')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="js/jquery.sortElements.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
        <script src="sweetalert2/sweetalert2.all.min.js"></script>
        <script src="jquery-validate/jquery.validate.min.js"></script>
        <link rel="stylesheet" href="/css/custom.css">
        <script src="{{ asset('js/index.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    </head>
@stop


@section('content')
    <div class="container">
        <div class="text-center mt-1"><img src="images/menufutar.png" class="" alt="MenuFutar"></div>

        <h2 class="text-center text-secondary mt-1">Válasszon várost!</h2>

        <div class="row">

            <div class="col-lg-4 col-12">
                <a href="javascript:void(0)" class="location" location="Miskolc">
                    <div class="small-box text-white"
                        style="background-image: url('/images/miskolc.jpg');height: 200px; background-size: cover; background-repeat: no-repeat;">
                        <div class="inner">
                            <h3>Miskolc</h3>
                            <p></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-12">
                <a href="javascript:void(0)" class="location" location="Kazincbarcika">
                    <div class="small-box text-white"
                        style="background-image: url('/images/kazincbarcika.jpg');height: 200px; background-size: cover; background-repeat: no-repeat;">
                        <div class="inner">
                            <h3>Kazincbarcika</h3>
                            <p></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-12">
                <a href="javascript:void(0)" class="location" location="Eger">
                    <div class="small-box text-white"
                        style="background-image: url('/images/eger.png');height: 200px; background-size: cover; background-repeat: no-repeat;">
                        <div class="inner">
                            <h3>Eger</h3>
                            <p></p>
                        </div>
                    </div>
                </a>
            </div>




        </div>



        @include('auth')




    </div><!-- End Container -->

@endsection
