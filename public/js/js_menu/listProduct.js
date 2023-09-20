// initialize & variable
var tbl_topup = $('#tbl-list-product').DataTable({ 
    paging : true,
    searching : true,
    columnDefs: [
        { targets: 0, orderable: false}, //first column is not orderable.
    ]
});

var rows = null;

function inputPrice(){
  var rp = formatRupiah($('#inp-product-price').val());
  $('#inp-product-price').val(rp);
}

function inputPrice1(){
  var rp = formatRupiah($('#inp-edit-product-price').val());
  $('#inp-edit-product-price').val(rp);
}

$('#btn-export-product').click(function(){
	$('#idFormProduct').submit();
});

$('#slc-add-stock').on('change', function() {
    var value = $('#slc-add-stock').val(); 
    if ( value == 'single' ) {
        $('.single-input').prop('hidden', false);
        $('.bulk-input').prop('hidden', true);
    } else {
        $('.single-input').prop('hidden', true);
        $('.bulk-input').prop('hidden', false);
    }
});

showListProduct();

function showListProduct() {
  $.ajax({
    type: "GET",
    url: "getListProduct",
    data: {},
    success: function (response) {
      rows = response.object;
      var table = $('#tbl-list-product').DataTable();
      table.clear();
        for (var index = 0; index < rows.length; index++) {
          table.row.add([
            rows[index].product_code,
            rows[index].product_name,
            rows[index].description,
            formatRupiah(rows[index].product_price),
            rows[index].quantity,
            '<button type="button" class="btn btn-primary" data-toggle="modal" onclick=openModalEditProduct('+index+') >Edit</button> '+
            '<button type="button" class="btn btn-danger" data-toggle="modal" onclick=openModalDeleteProduct('+index+') >Delete</button> '
          ]).draw(true);
        }
      table.draw();
      $('#btn-excel-product').html('');
      new $.fn.DataTable.Buttons(
        table,{ buttons:[{ extend: 'excel', text:'Export', filename: 'List Product' }]
      }).container().appendTo( $('#btn-excel-product'));
    },
    error: function (response) {
      console.log(response);
      alert_info('System error. Please contact your administrator');
    },
  });
}

function addProduct() {
  $("#loading").modal("show");
  var formData = new FormData($('#form_add_stock')[0]);
  var price = $('#inp-product-price').val();
  formData.set('inp-product-price', price.replace('.',''))
  $.ajax({
      type: "POST",
      url: "addProduct",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function(response) {
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

function openModalEditProduct(index){ 
  $('#inp-edit-product-code').val(rows[index].product_code);
  $('#inp-edit-product-name').val(rows[index].product_name);
  $('#inp-edit-product-price').val(rows[index].product_price);
  $('#inp-edit-product-qty').val(rows[index].quantity);
  $('#inp-edit-product-desc').val(rows[index].description);
  $('#modal-edit-product').modal('show');
}

function updateProduct() {
  $("#loading").modal("show");
  var productCode      = $('#inp-edit-product-code').val();
  var productName      = $('#inp-edit-product-name').val();
  var productPrice     = $('#inp-edit-product-price').val();
  productPrice         = productPrice.replace('.','');
  var productQty       = $('#inp-edit-product-qty').val();
  var productDesc      = $('#inp-edit-product-desc').val();
  $.ajax({
      type: "POST",
      url: "updateProduct",
      data: {
        productCode  : productCode,
        productName  : productName,
        productPrice : productPrice,
        productQty   : productQty,
        productDesc  : productDesc
      },
      dataType: "json",
      success: function(response) {
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

function openModalDeleteProduct(index){ 
  alert_confirmation( 'Are you sure want to delete this item ? ' , 
    function(){deleteProduct(rows[index].product_code)});
}

function deleteProduct( productCode ) {
  $("#loading").modal("show");
  $.ajax({
      type: "POST",
      url: "deleteProduct",
      data: { productCode  : productCode },
      dataType: "json",
      success: function(response) {
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