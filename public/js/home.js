$(function ($) {

    let route = "home";


    $(document).ready(function () {

        // search
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".searchable").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        //value increase
        $('body').on('click', '.valueincrease', function () {

            let newval = $(this).parent().val();
            newval++;
            if (newval >= 0) {
                $(this).parent().val(newval);
                $(this).parent().attr('quantity', newval);
                $(this).parent().find('.currentvalue').html($(this).parent().val());
            }
            calcprice();

        });
        //value decrease
        $('body').on('click', '.valuedecrease', function () {

            let newval = $(this).parent().val();
            newval--;
            if (newval >= 0) {
                $(this).parent().val(newval);
                $(this).parent().attr('quantity', newval);
                $(this).parent().find('.currentvalue').html($(this).parent().val());
            }
            calcprice();

        });

        reload();
        regsuggestion();

    });

    function calcprice() {
        let sumprice = 0;
        let sumqty = 0;
        $('.currentvalue').each(function () {
            let thisval = 0;
            let thisqty = 0;
            let thisprice = 0;
            thisqty = parseFloat($(this).parent().attr('quantity'));
            thisprice = parseFloat($(this).parent().attr('price'));
            thisval = thisqty * thisprice;
            sumqty += thisqty;
            sumprice += thisval;
        });

        if(sumprice > 0){
            $('#actionbutton').empty();
            $('#actionbutton').append('<div class="btn btn-success" id="ordercontinue">Rendelés leadása '+sumprice+' HUF</div>');
        }else{
            $('#actionbutton').empty();
        }
        
    }

    function regsuggestion() {
        $.get('/authcheck', function (data) {
            if (!data['status']) {
                swal({
                    title: "Bejelentkezel?",
                    text: "Az egyszerű rendeléshez jelentkezz be, vagy ha nincs fiókod, csinálj egyet pár kattintással!",
                    type: "info",
                    showCancelButton: !0,
                    confirmButtonText: "Igen",
                    cancelButtonText: "Mégse",
                    reverseButtons: !0
                }).then(function (e) {

                    if (e.value === true) {
                        $('.loginform').click();
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;

                })
            }
        })
    }

    function reload() {

        $.ajax({

            url: 'menu',
            type: "GET",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (results) {

                if (results.success === true) {
                    if (results.data.length == 0) {
                        $('#results').html('<h3 class="text-center text-secondary">Sajnáljuk, még nincsenek feltöltve a menük, próbálja később!</h3>');
                        return false;
                    }
                    $('#thead').empty();
                    $('#thead').append('<th>  </th>');
                    $.each(results.types, function (key, item) {
                        let thisrow = '';
                        thisrow = '<th>' + item.menu_type + '</th>'
                        $('#thead').append(thisrow);
                    });

                    $('#tcontent').empty();

                    let rownumber = 0;
                    $.each(results.dates, function (key, tablerow) {
                        rownumber++;
                        let datecolumncolor;
                        if (rownumber % 2 == 0) {
                            datecolumncolor = "secondary";
                        } else {
                            datecolumncolor = "dark";
                        }
                        let thisrow = '';
                        let boxcolor = '';
                        let fontawesome = '';
                        let status = "";
                        if (tablerow.status == 1) {
                            status = "Rendelhető";
                        } else {
                            status = "Már nem rendelhető";
                        }

                        thisrow += '<tr><td class="bg-' + datecolumncolor + ' h-100 m-3 align-middle"><div class="align-middle"><h6>' + tablerow.delivery_date + '<br></h6><p>' + status + '</p></div></td>';
                        $.each(results.types, function (key, tablecolumn) {

                            thisrow += '<td>';
                            $.each(results.data, function (key, menus) {
                                if (tablecolumn.menu_type == menus.menu_type && tablerow.delivery_date == menus.delivery_date) {
                                    switch (tablecolumn.menu_type) {
                                        case 'Leves':
                                            boxcolor = 'warning';
                                            fontawesome = 'fas fa-utensil-spoon';
                                            break;
                                        case 'Főétel':
                                            boxcolor = 'primary';
                                            fontawesome = 'fas fa-utensils';
                                            break;
                                        case 'Desszert':
                                            boxcolor = 'info';
                                            fontawesome = 'fas fa-utensils';
                                            break;
                                        default:
                                            boxcolor = 'success';
                                            fontawesome = 'fas fa-utensils';
                                    }
                                    thisrow += '<div class="col-xl-12 col-12"><div class="small-box bg-' + boxcolor + '"><div class="inner"><h6>'
                                    thisrow += menus.menu_name;
                                    thisrow += '</h6><p>Ár: ' + menus.menu_price + ' HUF</p></div>';
                                    if (menus.noworderable) {
                                        thisrow += '<div class="btn-group mb-1 p-1 bg-white" quantity=0 price='+menus.menu_price+' data-id='+menus.id+'><button type="button" class="btn btn-outline-danger valuedecrease">-</button><button type="button" class="btn btn-muted currentvalue">0</button><button type="button" class="btn btn-outline-success valueincrease">+</button></div>';
                                    }
                                    thisrow += '<div class="icon"><i class="' + fontawesome + '"></i></div></div></div>';
                                }
                            });
                            thisrow += '</td>';
                        });
                        thisrow += '</tr>';
                        $('#tcontent').append(thisrow);
                    });

                } else {

                    alert("Váratlan hiba történt!");
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

});