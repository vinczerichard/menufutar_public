$(function ($) {

    $(document).ready(function () {
        //getdata
        $('body').on('click', '#changetext', function () {
            $('#edit_modal').modal('show');

        });
        
        $('body').on('click', '#edit_modal_save', function () {
            if ($("#edit_form").length > 0) {
                $("#edit_form").validate({
    
                    submitHandler: function (form) {
    
                        $.ajax({
                            data: $('#edit_form').serialize(),
                            url: "pagecontent/" + $('#edit_id').val(),
                            type: 'post',
                            dataType: 'json',
    
                            success: function (results) {
    
                                if (results.success === true) {
    
                                    $('#edit_form').trigger("reset");
                                    $('#edit_modal').modal('hide');
                                    swal("Módosítva!", results.message, "success").then(function (e) {
                                            location.reload(); 
                                    });
    
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

    });

});