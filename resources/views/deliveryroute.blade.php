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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"
            integrity="sha512-Eezs+g9Lq4TCCq0wae01s9PuNWzHYoCMkE97e2qdkYthpI0pzC3UGB03lgEHn2XM85hDOUF6qgqqszs+iXU4UA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('js/deliveryroute.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <style>
            .col {
                width: 50%;
                float: left;
            }
        </style>

    </head>
@stop


@section('content')
    <div class="container">

        <h3 class="list-group col text-center text-secondary mb-3">
            Rendezetlen
        </h3>
        <h3 class="list-group col text-center text-secondary mb-3">
            Rendezett
        </h3>

        <div id="example2-left" class="list-group col notordered">
            @foreach ($news as $n)
                <div class="list-group-item" value=0 data-id={{ $n->id }}>{{ $n->postal }} {{ $n->city }} {{ $n->street }} {{ $n->number }}
                </div>
            @endforeach
        </div>

        <div id="example2-right" class="list-group col orderedlist">
            @foreach ($ordered as $o)
                <div class="list-group-item" value={{ $o->sortnumber }} data-id={{ $o->id }}>{{ $o->postal }} {{ $o->city }} {{ $o->street }} {{ $o->number }}</div>
            @endforeach
        </div>

    </div>



    @include('auth')




    </div><!-- End Container -->

@endsection
