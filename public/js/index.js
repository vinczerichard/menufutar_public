$(function ($) {

    let route = "location";

    $(document).ready(function () {
        //getdata
        $('body').on('click', '.location', function () {
            $.get('location/' + $(this).attr('location'), function (data) {
                if (data['success']) {
                    window.location.replace('/');
                } else {
                    swal("Hiba!", "Váratlan hiba történt!", "warning");
                }

            })

        });
    });

});