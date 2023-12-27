$(function ($) {

    let route = "myaddresses";

    $(document).ready(function () {

        // Create Modal
        $('body').on('click', '.create', function (e) {

            e.preventDefault();

            $.get(route + '/create', function (data) {
                $('#create_form').trigger("reset");
                $('#create_modal').modal('show');
                if ($('#add_location').val() == "") {
                    $('#add_city').val("");
                    $('#add_city').prop("disabled", true);
                    $('#add_street').val("");
                    $('#add_street').prop("disabled", true);
                } else {
                    $.get('citybylocation/' + $('#add_location').val(), function (data) {
                        $('#add_city').prop("disabled", false);
                        $('#add_city').empty();
                        $('#add_city').append('<option value="">Kérem válasszon!</option>');
                        $.each(data.data, function (key, item) {
                            $('#add_city').append('<option value="' + item['postal'] + '">' + item['postal'] + '&nbsp' + item['city'] + '</option>');
                        });

                    })
                }
            })

        });

        // Create
        $('#save_new').click(function () {

            if ($("#create_form").length > 0) {
                $("#create_form").validate({
                    submitHandler: function (form) {
                        $.ajax({
                            data: $('#create_form').serialize(),
                            url: route,
                            type: "POST",
                            dataType: 'json',

                            success: function (results) {


                                if (results.success === true) {

                                    $('#create_modal').modal('hide');
                                    $('#create_form').trigger("reset");
                                    reload();

                                } else {

                                    swal("Figyelem!", results.message, "warning");
                                }


                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                })
            }
        });

        //DELETE 
        $('body').on('click', '.delete', function (e) {

            e.preventDefault();

            let id = $(this).data('id');
            swal({
                title: "Biztosan törli?",
                text: "",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Igen",
                cancelButtonText: "Mégse",
                reverseButtons: !0
            }).then(function (e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'DELETE',

                        url: route + "/" + id,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function (results) {


                                if (results.success === true) {

                                    reload();

                                } else {

                                    swal("Nem törölhető!", results.message, "warning");

                                }

                        }
                    })

                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;

            })
        });

        // Change location on create modal
        $('body').on('change', '#add_location', function (e) {
            if ($(this).val() == "") {
                $('#add_city').val("");
                $('#add_city').prop("disabled", true);
                $('#add_street').val("");
                $('#add_street').prop("disabled", true);
            } else {
                $.get('citybylocation/' + $(this).val(), function (data) {
                    $('#add_city').prop("disabled", false);
                    $('#add_city').empty();
                    $('#add_city').append('<option value="">Kérem válasszon!</option>');
                    $.each(data.data, function (key, item) {
                        $('#add_city').append('<option value="' + item['postal'] + '">' + item['postal'] + '&nbsp' + item['city'] + '</option>');
                    });

                })
            }
        });

        // Change city on create modal
        $('body').on('change', '#add_city', function (e) {
            if ($(this).val() == "") {
                $('#add_street').val("");
                $('#add_street').prop("disabled", true);
            } else {
                $.get('streetbycity/' + $(this).val(), function (data) {
                    $('#add_street').prop("disabled", false);
                    $('#add_street').empty();
                    $('#add_street').append('<option value="">Kérem válasszon!</option>');
                    $.each(data.data, function (key, item) {
                        $('#add_street').append('<option value="' + item['street'] + '">' + item['street'] + '</option>');
                    });
                })
            }
        });


        reload();
    });

    function reload() {

        $.get(route + '/user', function (data) {
            if (data.success === true) {

                $('.records').empty();

                $.each(data.data, function (key, item) {
                    let thisrow = '';
                    thisrow = '<tr class="searchable"><td>' + item['address_name'] + '</td><td>' + item['postal'] + ' ' + item['city'] + ' ' + item['street'] + ' ' + item['number'] + '<br>'+ ' ' + item['description'] + '</td><td class="text-right"><button data-id=' + item['id'] + ' class="delete btn btn-outline-danger ml-1"> <i class="fas fa-trash-alt"></i></button></td></tr>';
                    $('.records').append(thisrow);

                });

            } else {

                $('.records').append('<h3 class="text-center text-warning m-3">Még nem található szállítási cím, hozzon létre!</h3>');
            }
        })
    }

});