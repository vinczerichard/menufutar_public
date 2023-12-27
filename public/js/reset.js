$(function ($) {

    let route = "reset";

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.close', function () {
            window.location.href = "/";
        });

        $('body').on('click', '#makemenewpass', function () {
            var myJsonData = "newpass=" + $('#newpass').val() + "&newpass2=" + $('#newpass2').val() + "&userid=" + $('#userid').val() + "&hash=" + $('#hash').val();
            let pass1 = $('#newpass').val();
            let pass2 = $('#newpass2').val();
            if (pass1 != pass2) {
                swal("Hiba!", "Nem egyezik az először és másodjára megadott jelszó!", "warning");
                return false;
            }

                        $.ajax({
                            data: myJsonData,
                            url: "/savenewpass",
                            type: "POST",
                            dataType: 'json',

                            success: function (results) {

                                if (results.success === true) {
                                    swal("Sikeresen módosította jelszavát!", "", "success").then(function (e) {
                                        $('#reset_form').trigger("reset");
                                        $('#registration_modal').modal('hide');
                                        window.location.href = "/";
                                    });


                                } else {

                                    swal("Sikertelen!", results.message, "warning").then(function (e) {
                                        window.location.href = "/";
                                    });
                                }


                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });

        });

        if($('#isvalid').val() == 1){
            $('#reset_modal').modal('show');
        }else{
            swal("Sikertelen!", "Lejárt a visszaállíthatósági időkorlát.", "warning").then(function (e) {
                window.location.href = "/";
            });
        }
        

    });

});