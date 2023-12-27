@extends('adminlte::page')

@section('content_header')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.sortElements.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
        <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('jquery-validate/jquery.validate.min.js') }}"></script>
        <link rel="stylesheet" href="/css/custom.css">
        <script src="{{ asset('js/reset.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    </head>
@stop


@section('content')
    <div class="container">


        <!-- Reset Modal -->
        <div class="modal fade" id="reset_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title text-center">Jelszó visszaállítása</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="reset_form">
                            @csrf
                            @method('post')
                            <input type="hidden" id="userid" name="userid" value={{ $id }}>
                            <input type="hidden" id="hash" name="hash" value={{ $hash }}>
                            <input type="hidden" id="isvalid" name="isvalid" value={{ $ready }}>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Új jelszó</span>
                                </div>
                                <input id="newpass" type="password" name="newpass" class="form-control">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Jelszó ismét</span>
                                </div>
                                <input id="newpass2" type="password" name="newpass2" class="form-control">
                            </div>
                            <div id="reset_response"></div>

                            <button id="makemenewpass" type="button" class="btn btn-block btn-success">Jelszó
                                módosítása</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Reset Modal -->
        @include('auth')

    </div><!-- End Container -->



@endsection
