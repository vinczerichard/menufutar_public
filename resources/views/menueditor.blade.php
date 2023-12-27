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
        <script src="{{ asset('js/menueditor.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="{{ asset('cdn/jquery.slim.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('cdn/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    </head>
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"><a href="{{ url()->previous() }}"
                    class='btn btn-outline-secondary btn-block text-center form-control' id="prev"><i
                        class="fas fa-angle-double-left"></i>&nbsp;&nbsp;&nbsp;Vissza</a></div>
            <div class="col-md-6">
                <h2 class="text-center h2 mt-1">Menük szerkesztése</h1>
            </div>
            <div class="col-md-3"><button class='btn btn-outline-success btn-block text-center form-control create'
                    id="create"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Új</button></div>
        </div>

        <form id="postform">
            @csrf
            @method('POST')
            <div class="row mt-3">
                <div class="input-group input-daterange">
                <div class="col-md-3">
                <h5 class="mt-1">Dátum intervallum:</h5>
                    </div>
                    <div class="col-md-3 mb-1">
                        <input type="date" id="min-date" name="from" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="Dátumtól" value="{{date("Y-m-d")}}">
                    </div>
                    <div class="col-md-3 mb-1">
                        <input type="date" id="max-date" name="to" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="Dátumig" value="">
                    </div>
                    <div class="col-md-3 mb-1">
                    <button class="btn btn-outline-secondary btn-block" name="submit" id="getlist"><i class="fas fa-sync-alt"></i> Keres / Frissít</button>
                    </div>
                </div>
            </div>
        </form>   
                <div id="results">
                    <table class="table table-borderless table-striped text-center">
                        <thead>
                            <tr id="thead" class='bg-secondary'>
                            </tr>
                        </thead>
                        <tbody id="tcontent">

                        </tbody>
                    </table>
                </div>

            <!--Create Modal-->
            <div class="modal fade" id="create_modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title w-100 text-center" id="add_modal_title">Létrehozás
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form id="create_form" name="create_form" class="form-horizontal">
                                @csrf
                                @method('post')
                                
                                <div class="form-group">
                                    <label for="">Körzet / Város</label>
                                    <select class="form-control" id="add_location" name="add_location" required>
                                        <option value="mind">Mindegyik</option>
                                        @foreach ($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Típusa</label>
                                    <select class="form-control" id="add_menutype" name="add_menutype" required>
                                        <option value="">Kérem válasszon!</option>
                                        @foreach ($menutypes as $m)
                                            <option value="{{ $m->id }}">{{ $m->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="add_delivery_date" class="control-label">Kiszállítási dátum</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" id="add_delivery_date" name="add_delivery_date"
                                            value="" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="add_name" class="control-label">Megnevezés</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="add_name" name="add_name"
                                            value="" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="add_price" class="control-label">Ár</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="add_price" name="add_price"
                                            value="" required="" min=1>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <select class="form-control" id="add_orderable" name="add_orderable" required>
                                        <option value=1>Rendelhető</option>
                                        <option value=0>Nem rendelhető</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="add_visible" name="add_visible" required>
                                        <option value=1>Megjelenítendő</option>
                                        <option value=0>Nem megjelenítendő</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success btn-block mb-3" id="save_new"
                                            value="save_new">Létrehozás
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

                        <!--Edit Modal-->
                        <div class="modal fade" id="edit_modal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title w-100 text-center" id="edit_modal_title">Szerkesztés
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                    aria-hidden="true">&times;</span>
                                            </button>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit_form" name="edit_form" class="form-horizontal">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="edit_id" id="edit_id" value="">
            
                                            <div class="form-group">
                                                <label for="">Körzet / Város</label>
                                                <select class="form-control" id="edit_location" name="edit_location" required>
                                                    <option value="mind">Mindegyik</option>
                                                    @foreach ($locations as $l)
                                                        <option value="{{ $l->id }}">{{ $l->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Típusa</label>
                                                <select class="form-control" id="edit_menutype" name="edit_menutype" required>
                                                    <option value="">Kérem válasszon!</option>
                                                    @foreach ($menutypes as $m)
                                                        <option value="{{ $m->id }}">{{ $m->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="add_delivery_date" class="control-label">Kiszállítási dátum</label>
                                                <div class="col-sm-12">
                                                    <input type="date" class="form-control" id="edit_delivery_date" name="edit_delivery_date"
                                                        value="" required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="add_name" class="control-label">Megnevezés</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="edit_name" name="edit_name"
                                                        value="" required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="add_price" class="control-label">Ár</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="edit_price" name="edit_price"
                                                        value="" required="" min=1>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <select class="form-control" id="edit_orderable" name="edit_orderable" required>
                                                    <option value=1>Rendelhető</option>
                                                    <option value=0>Nem rendelhető</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" id="edit_visible" name="edit_visible" required>
                                                    <option value=1>Megjelenítendő</option>
                                                    <option value=0>Nem megjelenítendő</option>
                                                </select>
                                            </div>
            
                                            <hr>
                                            <div class="row">
                                                <div class="col-10">
                                                    <button type="submit" class="btn btn-secondary btn-block" id="save_edit"
                                                        value="save_edit">Módosítás
                                                    </button>
                                                </div>
                                        </form>
                                        <div class="col-2">
                                            <button class="btn btn-danger delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
            
            
                                </div>
                            </div>
                        </div>

    </div>

    @include('auth')




    </div><!-- End Container -->



@endsection
