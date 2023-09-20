$('#btn-print-report').click(function(){
	$('#temp-transaction-type').val($('#slc-trx-type').val());
	$('#temp-start-date').val($('#inp-start-date').val());
	$('#temp-end-date').val($('#inp-end-date').val());
	$('#idFormTransaction').submit();
});