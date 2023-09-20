var tbl_transaction = $('#tbl-transaction').DataTable();

function getInfoTransactionCustomer() {
  var transactionId = $("#inp-transaction-id").val();
	var startDate = $("#inp-start-date").val();
	var endDate = $("#inp-end-date").val();
    $.ajax({
      type: "POST",
      url: "getTransactionCustomer",
      data: { 
        transactionId: transactionId, 
        startDate: startDate, 
        endDate: endDate 
      },
      success: function (response) {
        var rows = response.object;
        var tblListTransaction = $('#tbl-transaction').DataTable();
        tblListTransaction.clear();
        for (var index = 0; index < rows.length; index++) {
            var no = (index+1);
            var btn = 'Waiting For Package Arrived';
            if ( rows[index].status == 'ORDER RECEIVED' ) {
              btn = `<button type="button" class="btn btn-success" onclick="openModalReceiveOreder('`+rows[index].order_id+`')">Order Received</button>`;
            }
            tblListTransaction.row.add([
              no,
			        `<a href="javascript:void(0);" onclick="openModalOrderDetail('`+rows[index].order_id+`') ">`+rows[index].order_id+`</a>`,
              `<a href="javascript:void(0);" onclick="openModalPickupDetail('`+rows[index].pick_up_id+`') "> Detail </a>`,
              rows[index].created_dtm,
              btn
            ]).draw(true);
        }
        tblListTransaction.draw();
        $('#btn-excel-transaction').html('');
        new $.fn.DataTable.Buttons(
            tblListTransaction,{ buttons:[{ extend: 'excel', text:'Export', filename: 'List Transaction' }]
        }).container().appendTo( $('#btn-excel-transaction'));
      },
      error: function (response) {
        console.log(response);
        alert_info('System error. Please contact your administrator');
      },
    });
}

function openModalReceiveOreder( orderId ){
	alert_confirmation(  'Are you sure want to update this order to received ? ' , function() {
		 receiveOrder( orderId ) 
	});
}

function receiveOrder( orderId ) {
	$("#loading").modal("show");
    $.ajax({
        url: "receiveOrder",
        type: "post",
        dataType: "json",
        data: { orderId : orderId },
        success: function(response) {
          $("#loading").modal("hide");
          alert_info(response.message, function() {
            window.location.reload();
          });
        },
        error: function(response) {
            console.log(response);
            alert_info('System error. Please contact your administrator');
        },
    });
}

