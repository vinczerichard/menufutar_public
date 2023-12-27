@extends('adminlte::page')

@section('content_header')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@stop


@section('content')
<div class="container">
<h2 class="text-center mt-1 text-danger">{{$message}}</h1>








</div><!-- End Container -->

<script src="{{asset('js/denied.js')}}?ver=1" type="text/javascript"></script>

@endsection