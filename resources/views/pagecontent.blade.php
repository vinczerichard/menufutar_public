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
        <script src="{{ asset('js/pagecontent.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    </head>
@stop


@section('content')
    <div class="container">

        <div class="text-center mt-1"><img src="images/menufutar.png" class="" alt="MenuFutar"></div>
        @can('isAdmin')
            <div class="text-center"><button class="btn btn-outline-secondary m-3" id="changetext"
                    value="{{ $data->page_name }}"> Szöveg szerkesztése </button></div>
        @endcan
        <div class="text-center text-secondary">{!! $data->page_text !!}</div>


        <!-- Edit Modal -->
        <div class="modal" id="edit_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Tartalom szerkesztése</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="edit_form" name="edit_form" class="form-horizontal">
                            @csrf
                            @method('put')
                            <input type="hidden" name="edit_id" id="edit_id" value="{{$data->id}}">

                            <textarea type="input" name="edit_text" id="edit_text" rows="5" cols="80" maxlength="4096">
                                {!! $data->page_text !!}
                           </textarea>

                            <script>
                                CKEDITOR.replace('edit_text');
                            </script>

                            <div>
                                <button type="submit" class="btn btn-outline-success btn-block mt-1" id="edit_modal_save"
                                    value="create">Mentés
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    </div>

                </div>
            </div>
        </div>

        @include('auth')
    </div><!-- End Container -->

@endsection
