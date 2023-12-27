$(function ($) {

    let route = "menueditor";


    $(document).ready(function () {

        // search
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".searchable").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        // Sort table
        var table = $('table');
        $('.sortbutton').wrapInner('<span title="sort this column"/>').each(function () {

            var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function () {

                table.find('td').filter(function () {

                    return $(this).index() === thIndex;

                }).sortElements(function (a, b) {

                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;

                }, function () {

                    // parentNode is the element we want to move
                    return this.parentNode;

                });

                inverse = !inverse;

            });



        });


        $('body').on('click', '#getlist', function (e) {

            e.preventDefault();

            var myJsonData = "from=" + $('#min-date').val() + "&to=" + $('#max-date').val();

            $.ajax({
                data: myJsonData,
                url: "menueditor/list",
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function (results) {

                    if (results.status === true) {

                        $('#thead').empty();
                        $('#thead').append('<th class="sortbutton"> ID </th><th class="sortbutton"> Kiszállítás </th><th class="sortbutton"> Körzet </th><th class="sortbutton"> Típus </th><th class="sortbutton"> Megnevezés </th><th class="sortbutton"> Ár </th><th class="sortbutton"> Rendelhető </th>');
                        $('#tcontent').empty();

                        $.each(results.data, function (key, tablerow) {
                            let thisrow = '<tr class="searchable">';
                            thisrow += '<td class="text-right">' + tablerow.id + '<div class="btn btn-outline-secondary ml-1 edit" data-id=' + tablerow.id + '><i class="fas fa-cog"></i></div></td>';
                            thisrow += '<td>' + tablerow.delivery_date + '</td>';
                            if (tablerow.location != null) {
                                thisrow += '<td class="text-primary">' + tablerow.location + '</td>';
                            } else {
                                thisrow += '<td class="text-success">Mindegyik</td>';
                            }
                            thisrow += '<td>' + tablerow.menu_type + '</td>';
                            thisrow += '<td>' + tablerow.menu_name + '</td>';
                            thisrow += '<td>' + tablerow.menu_price + '</td>';
                            if (tablerow.orderable == 1) {
                                thisrow += '<td class="text-success">igen</td>';
                            } else {
                                thisrow += '<td class="text-danger">nem</td>';
                            }
                            thisrow += '</tr>';
                            $('#tcontent').append(thisrow);
                        });

                    } else {

                    }

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });

        // Create Modal Open
        $('#create').click(function (e) {
            e.preventDefault();

            $('#create_form').trigger("reset");
            $('#create_modal').modal('show');

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
                                    $('#getlist').click();

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

        //EDIT MODAL
        $('body').on('click', '.edit', function (e) {

            e.preventDefault();

            $.get(route + '/' + $(this).data('id') + '/edit', function (data) {

                    $('#edit_form').trigger("reset");
                    $('#edit_modal').modal('show');
                    $('#edit_id').val(data['record'].id);
                    if(data['record'].location != null){
                        $('#edit_location').val(data['record'].location);
                    }
                    $('#edit_menutype').val(data['record'].menu_type);
                    $('#edit_delivery_date').val(data['record'].delivery_date);
                    $('#edit_name').val(data['record'].menu_name);
                    $('#edit_price').val(data['record'].menu_price);
                    $('#edit_orderable').val(data['record'].orderable);
                    $('#edit_visible').val(data['record'].visible);

            })
        });

        //UPDATE
        $('#save_edit').click(function () {


            if ($("#edit_form").length > 0) {
                $("#edit_form").validate({

                    submitHandler: function (form) {

                        $.ajax({
                            data: $('#edit_form').serialize(),
                            url: route + "/" + $('#edit_id').val(),
                            type: 'post',
                            dataType: 'json',

                            success: function (results) {

                                    if (results.success === true) {

                                        $('#edit_form').trigger("reset");
                                        $('#edit_modal').modal('hide');
                                        $('#getlist').click();

                                    }
                                    else {

                                        let errorList = '';
                                        $.each(results.errors, function (key, value) {
                                            errorList += '\n' + value + '<br>';

                                        });
                                        swal("Hiba!", results.message, "warning");

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

            let id = $('#edit_id').val();
            swal({
                title: "Biztosan törli?",
                text: "A törlés nem visszavonható!",
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

                            if (results['access']) {

                                if (results.success === true) {

                                    $('#edit_form').trigger("reset");
                                    $('#edit_modal').modal('hide');
                                    $('#getlist').click();

                                } else {

                                    swal("Nem törölhető!", results.message, "warning");

                                }

                            } else {
                                swal("Hiba!", "Nincs jogosultsága a törléshez!", "warning");
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

    });
});