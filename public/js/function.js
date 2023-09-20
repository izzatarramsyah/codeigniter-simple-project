// variable
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

var tbl_notification = $('#tbl-notification').DataTable({ 
    paging : true,
    searching : true,
    columnDefs: [
        { targets: 0, orderable: false}, //first column is not orderable.
    ]
});
  
$('.inp-number').on('keydown', function(e) {
    -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13]) || /65|67|86|88/.test(e.keyCode) &&
        (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode &&
        40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) &&
        (96 > e.keyCode || 105 < e.keyCode) &&
        e.preventDefault()
});

$('.singchk').click(function(){
    $('.single').attr('disabled', false);   
    $('.multiple').attr('disabled', true);   
 });

$('.mulchk').click(function(){
    $('.multiple').attr('disabled', false);   
    $('.single').attr('disabled', true);   
});

$('#startdate').datetimepicker({
	format: 'L',
	defaultDate: new Date()
});

$('#enddate').datetimepicker({
	format: 'L',
	defaultDate: new Date()
});

// function
function alert_info(message, callback) {
    $('#modal-alert').modal('show');
    $('#modal-alert-title').html('Information');
    $('#btn-no').html('OK');
    $('#btn-yes').hide();
    $('#modal-alert-message').html(message);
    $('#btn-no').trigger('focus');
    $('#btn-no').off('click').on('click', function () {
        $('#modal-alert').modal('hide');
        if (typeof callback === 'function') {
            callback();
        }
    });
}

function alert_confirmation(message, callback) {
    $('#modal-alert').modal('show');
    $('#modal-alert-title').html('Confirmation');
    $('#btn-yes').show();
    $('#btn-no').html('No');
    $('#modal-alert-message').html(message);
    $('#btn-yes').trigger('focus');
    $('#btn-yes').off('click').on('click', function () {
        $('#modal-alert').modal('hide');
        if (typeof callback === 'function') {
            callback();
        }
    });
    $('#btn-no').off('click').on('click', function () {
        $('#modal-alert').modal('hide');
    });
}

function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
 
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return '<sup> Rp. </sup> ' + rupiah;
    // return rupiah;
}

// function formatPrice(price){
// 	var rp = formatRupiah(price);
// 	$('#inp-saldo-addons').val(rp);
// 	for (var i = 0; i < 5; i++) {
// 		stok = stok.replace('.','');
// 	}
// }

displayHeaderCart();
function displayHeaderCart(){
    $.ajax({
        url: "getListCart",
        success: function(response) {
            $('.badge-cart').html('');
            $('.view-cart').html('');
            $('.view-all-cart').html('');
            if ( response.object.length > 0 ) {
                var content = '';
                var count = 0;
                response.object.forEach(items => {
                content += 
                    '<li><a href="javascript:void(0);" class="dropdown-item"> ' +
                    '<div class="media"> ' +
                    '<img src="../../dist/img/diamond-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle"> ' +
                    '<div class="media-body"> ' +
                    '<h3 class="dropdown-item-title"> '+ items.product_name +'</h3> ' +
                    '<p class="text-sm"> ' + items.product_description + ' </p> ' +
                    '<p class="text-sm"> Qty : ' + items.quantity + ' Pcs </p> ' +
                    '</div> ' +
                    '</img></div> ' +
                    '</a><li>';
                count ++;
                })
                $('.badge-cart').html(count);
                $('.view-cart').html(content);
                $('.view-all-cart').html('See All Cart');
            }
        },
        error: function(response) {
            console.log(response);
        },
    });
}

function openModalOrderDetail ( orderId ) {
    $.ajax({
      type: "POST",
      url: "getOrderDetail",
      data: { orderId : orderId },
      success: function (response) {
        debugger;
        var rows = response.object;
        var tblDetailOrder = $('#tbl-detail-order').DataTable({ 
            info : false
        });
        tblDetailOrder.clear();
        $('#detail-order-id').val(rows[0].order_id);
        $('#detail-order-dt').val(rows[0].created_dtm);
        for (var index = 0; index < rows.length; index++) {
            tblDetailOrder.row.add([
              rows[index].product_code,
              rows[index].quantity,
              formatRupiah(rows[index].total_price)
            ]).draw(true);
        }
        tblDetailOrder.draw();
        $("#modal-detail-order").modal("show");
      },
      error: function (response) {
        console.log(response);
        $("#loading").modal("hide");
        alert_info('System error. Please contact your administrator');
      },
    });
}

function openModalPickupDetail ( pickupId ) {
	$('#txt-pickup-id').html(pickupId)
    $.ajax({
      type: "POST",
      url: "getListPickUpDetail",
      data: { pickupId : pickupId },
      success: function (response) {
		var content = '';
		response.object.forEach(items => {
			content += 
				'<div><i class="fas fa-user bg-green"></i> ' +
				'<div class="timeline-item">' +
				'<span class="time"><i class="fas fa-clock"></i> ' + items.created_dtm + '</span>' +
				'<h3 class="timeline-header no-border"> ' + items.status + '</h3>' +
				'</div></div>';
		});
		$('.timeline').html(content);
        $("#modal-detail-pickup").modal("show");
      },
      error: function (response) {
        console.log(response);
        $("#loading").modal("hide");
        alert_info('System error. Please contact your administrator');
      },
    });
}

function openModalProductDetail ( productId ) {
    $.ajax({
      type: "POST",
      url: "getProduct",
      data: { productId : productId },
      success: function (response) {
        var data = response.object;
        $('#dtl-product-code').html(data[0].product_code);
        $('#dtl-product-name').html(data[0].product_name);
        $('#dtl-product-desc').html(data[0].description);
        $('#dtl-product-price').html(data[0].product_price);
        $("#modal-detail-product").modal("show");
      },
      error: function (response) {
        console.log(response);
        $("#loading").modal("hide");
        alert_info('System error. Please contact your administrator');
      },
    });
}