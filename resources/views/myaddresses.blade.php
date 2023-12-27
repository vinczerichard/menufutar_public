@extends('adminlte::page')

@section('content_header')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="js/jquery.sortElements.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="/css/custom.css">
        <link rel="stylesheet" href="/css/custom.css">
        <script src="sweetalert2/sweetalert2.all.min.js"></script>
        <script src="jquery-validate/jquery.validate.min.js"></script>
        <script src="{{ asset('js/myaddresses.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/auth.js') }}?ver=1" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    @stop


    @section('content')
        <div class="container">

            <div class="d-none d-md-block">
                <div class="row">
                    <div class="col-md-3"><a href="{{ url()->previous() }}"
                            class='btn btn-outline-secondary btn-block text-center form-control' id="prev"><i
                                class="fas fa-angle-double-left"></i>&nbsp;&nbsp;&nbsp;Vissza</a></div>
                    <div class="col-md-6">
                        <h2 class="text-center h2 mt-1">Rendelési címeim</h1>
                    </div>
                    <div class="col-md-3"><button class='btn btn-outline-success btn-block text-center form-control create'
                            id="create"><i class="fas fa-plus"></i>&nbsp;&nbsp;&nbsp;Új</button></div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-secondary">
                        <tr>
                            <th class="sortbutton">Elnevezés</th>
                            <th class="sortbutton">Szállítási cím</th>
                            <th class="text-right"></th>
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
                                    <label for="add_name" class="control-label">Elnevezés</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="add_name" name="add_name"
                                            value="" required="" placeholder="pl: Otthon">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Körzet</label>
                                    <select class="form-control" id="add_location" name="add_location" required>
                                        <option value="">Kérem válasszon!</option>
                                        <option value="Miskolc">Miskolc</option>
                                        <option value="Eger">Eger</option>
                                        <option value="Kazincbarcika">Kazincbarcika</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Település</label>
                                    <select class="form-control" id="add_city" name="add_city" required>
                                        <option value="">Kérem válasszon!</option>
                                        <option value="3525">3525 Miskolc</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Utca</label>
                                    <select class="form-control" id="add_street" name="add_street" required>
                                        <option value="">Kérem válasszon!</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="add_name" class="control-label">Házszám</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="add_number" name="add_number" maxlength=12 value="" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="add_name" class="control-label">Megjegyzés</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="add_description" name="add_description" value="" maxlength=128 placeholder="pl: kapucsengő">
                                    </div>
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


            @include('auth')
        </div><!-- End Container -->



    @endsection
