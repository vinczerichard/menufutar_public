$(function ($) {

    let route = "stores";

    
    $(document).ready(function () {

        // search
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".searchable").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        reload();

    });

    function reload(){

        $.ajax({

            url: route,
            type: "GET",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (results) {

                if (results.success === true) {

                    $('.records').empty();

                    $.each(results.data, function (key, item) {
                        let thisrow = '';
                        thisrow = '<tr class="searchable"><td>'+item['id']+'</td><td>'+item['store_name']+'</td><td class="text-right"><button data-id='+item['id']+' class="edit btn btn-outline-secondary ml-1"> <i class="fas fa-cog"></i></button></td></tr>';
                        $('.records').append(thisrow);

                    });

                } else {

                    alert("Sikertelen!");
                }

            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    }


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

    // getData
    $('body').on('click', '.getData', function () {

        var myJsonData = "{sortBy: name, sortDirection: DESC}";
        // $.post('users/get', myJsonData, function(response) {
        //     alert("Kész!");
        // })

        $.ajax({
            data: myJsonData,
            url: route+"/get",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (results) {

                if (results.success === true) {

                    alert("Kész!");

                } else {

                    alert("Sikertelen!");
                }

            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });

    // Create Modal
    $('.create').click(function () {

        $.get(route + '/create', function (data) {
            if(data['access']){
                $('#create_form').trigger("reset");
                $('#create_modal').modal('show');
            }else{
                swal("Hiba!", "Nincs jogosultsága a létrehozáshoz!", "warning");
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

                            if(results['access']){

                                if (results.success === true) {

                                    $('#create_modal').modal('hide');

                                    $('#create_form').trigger("reset");
                                    reload();

                                } else {

                                    swal("Figyelem!", results.message, "warning");
                                }

                            }else{
                                swal("Hiba!", "Nincs jogosultsága a létrehozáshoz!", "warning");
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

            if(data['access']){

                $('#edit_form').trigger("reset");
                $('#edit_modal').modal('show');
                $('#edit_id').val(data['record'].id);
                $('#edit_name').val(data['record'].store_name);

            }else{
                swal("Hiba!", "Nincs jogosultsága a szerkesztéshez!", "warning");
            }

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

                            if(results['access']){

                                if (results.success === true) {

                                    $('#edit_form').trigger("reset");
                                    $('#edit_modal').modal('hide');
                                    reload();

                                }
                                else {

                                    let errorList = '';
                                    $.each(results.errors, function (key, value) {
                                        errorList += '\n' + value + '<br>';

                                    });
                                    swal("Hiba!", results.message, "warning");

                                }

                            }else{
                                swal("Hiba!", "Nincs jogosultsága a szerkesztéshez!", "warning");
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

                        if(results['access']){
                        
                            if (results.success === true) {

                                $('#edit_form').trigger("reset");
                                $('#edit_modal').modal('hide');
                                reload();

                            } else {

                                swal("Nem törölhető!", results.message, "warning");

                            }

                        }else{
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