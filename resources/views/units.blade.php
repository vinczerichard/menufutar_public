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
    <script src="{{asset('js/units.js')}}" type="text/javascript"></script>
    @stop


    @section('content')
    <div class="container">

        <div class="d-none d-md-block">
            <div class="row">
                <div class="col-md-3"><a href="{{ url()->previous() }}" class='btn btn-outline-secondary btn-block text-center form-control' id="prev"><i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;&nbsp;Vissza</a></div>
                <div class="col-md-6">
                    <h2 class="text-center h2 mt-1">Mértékegységek</h1>
                </div>
                <div class="col-md-3"><button class='btn btn-outline-success btn-block text-center form-control create' id="create"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Új</button></div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="text-secondary">
                    <tr>
                        <th class="sortbutton">Azonosító</th>
                        <th class="sortbutton">Név</th>
                        <th class="text-right">Műveletek</th>
                    </tr>
                </thead>
                <tbody class="records">
                </tbody>
            </table>
        </div>


        <!--Create Modal-->
        <div class="modal fade" id="create_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title w-100 text-center" id="add_modal_title">Létrehozás
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="create_form" name="create_form" class="form-horizontal">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="add_name" class="control-label">Név</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="add_name" name="add_name" value="" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-block mb-3" id="save_new" value="save_new">Létrehozás
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Conversion Modal-->
        <div class="modal fade" id="conv_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title w-100 text-center" id="add_modal_title">Átváltás
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="conv_form" name="conv_form" class="form-horizontal">
                            @csrf
                            @method('post')

                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-block mb-3" id="save_conv" value="save_conv">Mentés
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="edit_form" name="edit_form" class="form-horizontal">
                            @csrf
                            @method('put')
                            <input type="hidden" name="edit_id" id="edit_id" value="">

                            <div class="form-group">
                                <label for="edit_name" class="control-label">Név</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="edit_name" name="edit_name" value="" required="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-secondary btn-block" id="save_edit" value="save_edit">Módosítás
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




    </div><!-- End Container -->



    @endsection