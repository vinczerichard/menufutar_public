$(function ($) {

  let route = "location";

  $(document).ready(function () {

    $('#actionbutton').append('<div class="btn btn-outline-success position-static" id="savesortedlist">Sorrend rögzítése</div>');

    var example2Left = document.querySelector("#example2-left");
    var example2Right = document.querySelector("#example2-right");

    new Sortable(example2Left, {
      group: 'shared', // set both lists to same group
      animation: 150,
      onEnd: foo
    });
    new Sortable(example2Right, {
      group: 'shared',
      animation: 150,
      onEnd: foo
    });

    function foo(ev) {
      var to = ev.to;
      var from = ev.from;
      var oldIndex = ev.oldIndex;
      var newIndex = ev.newIndex;

      if (to != from || oldIndex != newIndex) {
        singleOnChange(ev)
      }
    }

    function singleOnChange(ev) {
      console.log("list(s) changed")
    }

    //save list
    $('body').on('click', '#savesortedlist', function () {

      $('.notordered').children('.list-group-item').each(function () {
        $(this).val(0);
      });

      let counter = 0
      $('.orderedlist').children('.list-group-item').each(function () {
        counter++;
        $(this).val(counter);
      });

      let seccessed = true;

      $('.list-group-item').each(function () {

        var myJsonData = "id=" + $(this).data('id') + "&value=" + $(this).val();

        $.ajax({
          data: myJsonData,
          url: "deliveryroute",
          type: "POST",
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success: function (results) {

            if (results.status === false) {
              seccessed = false;
            }

          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      });

      if (seccessed) {
        swal("Sikeres mentés!", "", "success");
      } else {
        swal("Sikertelen!", "Nem sikerült minden elemet sorszámozni!", "warning").then(function (e) {
          location.reload();
        });
      }

    });

  });

});