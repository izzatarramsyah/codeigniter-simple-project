  getListPickUp ();
  function getListPickUp () {
    $.ajax({
      type: "GET",
      url: "getListPickUp",
      success: function (response) {
        var rows = response.object;
        var tblListPickUp = $('#tbl-pickup-history').DataTable();
        tblListPickUp.clear();
        for (var index = 0; index < rows.length; index++) {
            var no = (index+1);
            var btn = '';
            if ( rows[index].status != 'Order Completed' ) {
              btn = `<button type="button" class="btn btn-primary" onclick="openModalStatusPickup('`+rows[index].pick_up_id+`')">Edit</i></i></button>`;
            }
            tblListPickUp.row.add([
                no,
                `<a href="javascript:void(0);" onclick="openModalOrderDetail('`+rows[index].order_id+`') ">`+rows[index].order_id+`</a>`,
                `<a href="javascript:void(0);" onclick="openModalPickupDetail('`+rows[index].pick_up_id+`') ">`+rows[index].pick_up_id+`</a>`,
                rows[index].status,
                rows[index].created_dtm,
                rows[index].lastupd_dtm,
                btn
            ]).draw(true);
        }
        tblListPickUp.draw();
        $('#btn-excel-user').html('');
        new $.fn.DataTable.Buttons(
            tblListPickUp,{ buttons:[{ extend: 'excel', text:'Export', filename: 'List User' }]
        }).container().appendTo( $('#btn-excel-user'));
      },
      error: function (response) {
        console.log(response);
        alert_info('System error. Please contact your administrator');
      },
    });
  }

  function openModalStatusPickup ( id ) {
    $('#idPickUp').val(id);
    $('#modal-status-pickup').modal('show');
  }

  function updatePickupStatus () {
    $("#loading").modal("show");
    var id = $('#idPickUp').val();
    var status = $('#slc-status-pickup').val();
    var notes = $('#inp-notes').val();
    debugger;
    $.ajax({
      type: "POST",
      url: "updatePickupStatus",
      data: { id : id, status : status, notes : notes },
      success: function (response) {
        $("#loading").modal("hide");
        alert_info(response.message, function() {
            window.location.reload();
        });
      },
      error: function (response) {
        console.log(response);
        $("#loading").modal("hide");
        alert_info('System error. Please contact your administrator');
      },
    });
  }