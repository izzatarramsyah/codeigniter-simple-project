  getListPickUpOrder();
  function getListPickUpOrder() {
    $.ajax({
      type: "GET",
      url: "getListPickUpOrder",
      success: function (response) {
        var rows = response.object;
        var tblListUser = $('#tbl-list-pickup-product').DataTable();
        tblListUser.clear();
        for (var index = 0; index < rows.length; index++) {
            var no = (index+1);
            if ( rows[index].pick_up_id == '' || rows[index].pick_up_id == null ) {
              tblListUser.row.add([
                no,
                `<a href="javascript:void(0);" onclick="openModalOrderDetail('`+rows[index].order_id+`') ">`+rows[index].order_id+`</a>`,
                rows[index].created_dtm,
                `<button type="button" class="btn btn-success" onclick="openModalPickUpOrder(`+rows[index].id+`, '`+rows[index].order_id+`')">Pick Up Order</button>`
              ]).draw(true);
            } 
        }
        tblListUser.draw();
        $('#btn-excel-user').html('');
        new $.fn.DataTable.Buttons(
            tblListUser,{ buttons:[{ extend: 'excel', text:'Export', filename: 'List User' }]
        }).container().appendTo( $('#btn-excel-user'));
      },
      error: function (response) {
        console.log(response);
        alert_info('System error. Please contact your administrator');
      },
    });
  }
  
  function openModalPickUpOrder ( id, orderId) {
    var message = "Are you sure want to pick up " + orderId + " Order ? ";
    alert_confirmation(message, function() { 
        pickUpOrder(id) 
    });
  }

  function pickUpOrder ( id ) {
    $("#loading").modal("show");
    $.ajax({
      type: "POST",
      url: "updateProductOut",
      data: { id : id },
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

