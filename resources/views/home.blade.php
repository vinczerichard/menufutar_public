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
        <script src="{{ asset('js/home.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    </head>
@stop


@section('content')
    <div class="container">
        <div class="text-center mt-1"><img src="images/menufutar.png" class="" alt="MenuFutar"></div>

        @if (session()->has('location'))
            <div id="menu">
                <h2 id="location" value="{{ session()->get('location') }}" class="text-center text-secondary mt-1">
                    {{ session()->get('location') }}</h2>

                <div id="results">
                    <table class="table table-borderless text-center">
                        <thead>
                            <tr id="thead" class='bg-secondary'>
                            </tr>
                        </thead>
                        <tbody id="tcontent">

                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <h1 class="text-center text-warning">Válasszon várost!</h1>
        @endif

    </div>

    @include('auth')




    </div><!-- End Container -->



@endsection
