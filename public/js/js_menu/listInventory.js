
$('#btn-export-inventory').click(function(){
	$('#idFormInventory').submit();
});

showInventory();

function showInventory() {
  $.ajax({
    url: "getInventory",
    data: {},
    success: function (response) {
      var rows = response.object;
      var tblInventory = $('#tbl-inventory').DataTable();
			tblInventory.clear();
      for (var index = 0; index < rows.length; index++) {
        var no = (index+1);
        tblInventory.row.add([
            no,
            rows[index].product_name,
            rows[index].ttl_units,
            rows[index].remaining_units,
            rows[index].created_dtm,
            rows[index].lastupd_dtm
        ]).draw(true);
      }
      tblInventory.draw();
      $('#btn-excel-inventory').html('');
      new $.fn.DataTable.Buttons(
        tblInventory,{ buttons:[{ extend: 'excel', text:'Export',  filename: 'Inventory' }]
      }).container().appendTo( $('#btn-excel-inventory'));
    },
    error: function (response) {
      console.log(response);
      alert_info('System error. Please contact your administrator');
    },
  });
}
