var tblTransactionSuplier = $('#tbl-transaction-suplier').dataTable();

$('#slc-trx-type').change(function() {
	var tablehead = $('#tbl-transaction-suplier').find('thead');
	var typeTrans = $('#slc-trx-type').val();
	tablehead.html(generateHeadTrans(typeTrans));
	$('#tbl-transaction-suplier').dataTable().fnClearTable();
});

function generateHeadTrans(type) {
	var head = new Array();
	head['stockOut'] = [
		'Order ID',
		'Pick Up ID',
		'Transaction Date'
	];
	head['stockIn'] = [
		'Product Code',
		'Quantity',
		'Transaction Date'
	];
	var header = '<tr>';
	for (var a = 0; a < head[type].length; a++) {
		header += '<th scope="col">' + head[type][a] + '</th>';
	}
	header += '</tr>';
	return header;
}

function generateColumnTrans(type) {
	var column = new Array();
	column['stockOut'] = [
		'order_id',
		'pick_up_id',
		'created_dtm',
	];
	column['stockIn'] = [
		'product_code',
		'quantity',
		'created_dtm'
	];
	var result = new Array();
	for (var a = 0; a < column[type].length; a++) {
		var obj = {
			data: column[type][a]
		};
		result.push(obj);
	}
	return result;
}

function getInfoTransactionSuplier() {
	var trxType = $("#slc-trx-type").val();
	var startDate = $("#inp-start-date").val();
	var endDate = $("#inp-end-date").val();
	var tblTransactionSuplier = $('#tbl-transaction-suplier').dataTable();
	try{
		tblTransactionSuplier.fnDestroy();
		tblTransactionSuplier = $('#tbl-transaction-suplier').DataTable({
			"processing": true,
			"autoWidth": false,
			"ajax": {
				type: "POST",
				url: "getTransactionSuplier",
				dataType: 'JSON',
				data: { 
					trxType: trxType, 
					startDate: startDate, 
					endDate: endDate 
				},
				dataSrc: function(data) {
					return data.object;
				}
			},
			"columns": generateColumnTrans(trxType)
		});
		$('#btn-excel-transaction').html('');
		new $.fn.DataTable.Buttons(
			tblTransactionSuplier,{ buttons:[{ extend: 'excel', text:'Export',  filename: 'Info Transaction' }]
		}).container().appendTo( $('#btn-excel-transaction'));
	} catch ( e ) { 
		console.log(e);
		window.location.reload();
	}
}

