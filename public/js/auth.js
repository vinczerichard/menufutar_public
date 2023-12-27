$(function ($) {

    $(document).ready(function () {



        //login modal
        $('body').on('click', '.loginform', function (e) {
            e.preventDefault();
            $('#login_verify').hide();
            $('#LoginModal').trigger("reset");
            $('#login_response').empty();
            $('#LoginModal').modal('show');
        });

        //login
        $('body').on('click', '#login', function (e) {

            e.preventDefault();

            var myJsonData = "email=" + $('#post_email').val() + "&password=" + $('#post_password').val() + "&verifycode=" + $('#post_verify_code').val();

            $.ajax({
                data: myJsonData,
                url: "postlogin",
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function (results) {

                    if (results.status === true) {

                        $('#LoginModal').modal('hide');
                        $('#login_form').trigger("reset");
                        $('.usermenu').empty();
                        let addtext = "";
                        addtext += '<div class="dropdown"><button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user">&nbsp' + results.name + '</i></button>';
                        addtext += '<div class="dropdown-menu">';
                        addtext += '<a class="dropdown-item text-secpndary" href="/myorders">Rendeléseim</a>';
                        addtext += '<a class="dropdown-item text-secpndary" href="/myaddresses">Szállítási címeim</a>';
                        addtext += '<a class="dropdown-item text-secpndary" href="/mysettings">Fiókbeállítások</a>';
                        addtext += '<a class="dropdown-item text-danger logout">Kijelentkezés</a>';
                        addtext += '</div></div>';
                        $('.usermenu').html(addtext);
                        swal("Bejelentkeztél!", "Üdv újra itt! :)", "success").then(function (e) {
                            if(results.isadmin){
                                location.reload();
                            }
                        });

                    } else {

                        $('#login_response').html('<h4 class="text-danger text-center">' + results.message + '</h4>');
                        if (results.noverify) {
                            $('#login_verify').show();
                        }
                    }

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        //logout
        $('body').on('click', '.logout', function () {
            $.get('logout', function (data) {
                if (data['status']) {
                    $('.usermenu').empty();
                    $('.usermenu').html('    <a class="loginform btn btn-outline-success"><i class="fa fa-user">&nbspBejelentkezés</i></a>');
                    swal("Kijelentkeztél!", "Várunk vissza! :)", "success").then(function (e) {
                        location.reload();
                    });
                } else {
                    swal("Hiba!", "Váratlan hiba történt!", "warning");
                }

            })

        });

        //registration modal
        $('body').on('click', '#reg_modal', function (e) {
            e.preventDefault();
            $('#registration_form').trigger("reset");
            $('#reg_city').empty();
            $('#reg_city').append('<option value="">Kérem válasszon!</option>');
            let currentlocation = "";
            $.get('getlocations', function (data) {
                $.each(data['locations'], function (key, item) {
                    $('#reg_city').append('<option value=' + item.id + '>' + item.id + '</option>');
                });

                if (data.loggedIn) {
                    swal("Hiba!", "Önnek már van fiókja, regisztáció előtt ki kell jelentkezni!", "warning");
                } else {
                    $('#reg_city').val(data['currentlocation']);
                    $('#registration_modal').modal('show');
                }
            })
        });

        //registration
        $('body').on('click', '#registration', function () {

            let pass1 = $('#reg_password').val();
            let pass2 = $('#reg_password2').val();
            if (pass1 != pass2) {
                swal("Hiba!", "Nem egyezik az először és másodjára megadott jelszó!", "warning");
                return false;
            }
            if ($('#reg_accept').is(':checked')) {
                $('#reg_accept').val(1);
            } else {
                $('#reg_accept').val("");
            }

            if ($("#registration_form").length > 0) {
                $("#registration_form").validate({
                    submitHandler: function (form) {
                        $.ajax({
                            data: $('#registration_form').serialize(),
                            url: "registration",
                            type: "POST",
                            dataType: 'json',

                            success: function (results) {

                                if (results.success === true) {
                                    swal("Sikeresen regisztrált!", results.message, "success");
                                    $('#registration_form').trigger("reset");
                                    $('#registration_modal').modal('hide');

                                } else {

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

    $('body').on('click', '#verify_code_resend', function (e) {

        e.preventDefault();

        var myJsonData = "email=" + $('#post_email').val() + "&password=" + $('#post_password').val();

        $.ajax({
            data: myJsonData,
            url: "verifycoderesend",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (results) {

                if (results.status === true) {

                    $('#login_response').html('<h4 class="text-success text-center">' + results.message + '</h4>');
                    $('#post_verify_code').val('');

                } else {

                    $('#login_response').html('<h4 class="text-danger text-center">' + results.message + '</h4>');
                }

            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    $('body').on('click', '#forgot_pass', function (e) {
        if ($('#post_email').val() == "") {
            swal("Üres email mező", "Meg kell adnia az email címet!", "warning");
            return false;
        }
        swal({
            title: "Visszaállítja a jelszavát?",
            text: "Amennyiben a visszaállítást választja, fog kapni az email címére egy levelet amiben meg kell nyomni a Visszaállítás gombot, majd a felugró képernyőn meg kell adni az új jelszavát!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Igen",
            cancelButtonText: "Mégse",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                var myJsonData = "email=" + $('#post_email').val();

                $.ajax({
                    data: myJsonData,
                    url: "forgotpasscode",
                    type: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function (results) {

                        if (results.status === true) {

                            swal("Sikerült!", results.message, "success");

                        } else {

                            swal("Sikertelen", results.message, "warning");
                        }

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });

            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;

        })
    });


    rewriteusermenu();

    function rewriteusermenu() {
        $.get('/authcheck', function (data) {
            if (data['status']) {
                $('.usermenu').empty();
                let addtext = "";
                addtext += '<div class="dropdown"><button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user">&nbsp' + data['username'] + '</i></button>';
                addtext += '<div class="dropdown-menu">';
                addtext += '<a class="dropdown-item text-secpndary" href="/myorders">Rendeléseim</a>';
                addtext += '<a class="dropdown-item text-secpndary" href="/myaddresses">Szállítási címeim</a>';
                addtext += '<a class="dropdown-item text-secpndary" href="/mysettings">Fiókbeállítások</a>';
                addtext += '<a class="dropdown-item text-danger logout">Kijelentkezés</a>';
                addtext += '</div></div>';
                $('.usermenu').html(addtext);
            }else{
                $('.usermenu').empty();
                $('.usermenu').html('<a class="loginform btn btn-outline-success"><i class="fa fa-user">&nbspBejelentkezés</i></a>');
            }
        })
    }

});