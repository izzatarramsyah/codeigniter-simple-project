var tbl_invoice_buy = $('#tbl-invoice-order').DataTable();
var tbl_cart_list = $('#tbl-cart-list').DataTable();

var cart = [];

function Item ( product_code, product_name, product_description, product_price, quantity, total_price ) {
    this.product_code = product_code;
    this.product_name = product_name;
    this.product_description = product_description;
    this.product_price = product_price;
    this.quantity = quantity;
    this.total_price = total_price;
}

getListProduct();

// function
function getListProduct() {
    $.ajax({
        url: "getListProduct",
        success: function(response) {
            var dataArr = response.object;
            var content = '';
            dataArr.forEach(item => {
                content += '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column"> ' +
                    '<div class="card bg-light d-flex flex-fill"> ' +
                    '<div class="card-header text-muted border-bottom-0"> ' + item.product_name + ' </div> ' +
                    '<div class="card-body pt-0"> ' +
                    '<div class="row"> ' +
                    '<div class="col-7"> ' +
                    ' <p class="text-muted text-sm"> <b> ' + item.description + ' </b> </p> ' +
                    ' <p class="medium"> </span> ' + formatRupiah(item.product_price) + ' </p> ' +
                    ' <p class="text-sm"> </span> Remaining Qty :  ' + item.quantity + ' Pcs </p> ' +
                    '</div> ' +
                    '  <div class="col-5 text-center"> ' +
                    '   <img src="../../dist/img/diamond-128x128.jpg" alt="user-avatar" class="img-circle img-fluid"> ' +
                    '  </div> ' +
                    ' </div> ' +
                    '</div> ' +
                    '<div class="card-footer"> ' +
                    ' <div class="text-right"> ' +
                    '  <a class="btn btn-sm bg-teal buyProduct" data-code="' + item.product_code + '" data-name="' + item.product_name + '" data-price="' + item.product_price + '"  data-desc="' + item.description + '"> ' +
                    '  <i class="fas fa-shopping-cart"></i> </a> ' +
                    '  <a class="btn btn-sm btn-primary addToCart" data-code="' + item.product_code + '" data-name="' + item.product_name + '" data-price="' + item.product_price + '" data-desc="' + item.description + '"> ' +
                    '  <i class="fas fa-heart"></i> </a>' +
                    ' </div> ' +
                    '</div> ' +
                    '</div>' +
                    '</div>';
            })
            $('.view-product').html(content);
        },
        error: function(response) {
            console.log(response);
            alert_info('System error. Please contact your administrator');
        },
    });
}

// button click
$(".view-product").on("click", ".buyProduct", function() {
    var product_code = $(this).attr("data-code");
    var product_name = $(this).attr("data-name");
    var product_desc = $(this).attr("data-desc");
    var product_price = $(this).attr("data-price");
    var item = new Item(product_code, product_name, product_desc, product_price, 1, product_price);
    cart = [];
    cart.push(item);
    tbl_invoice_buy.clear().draw();
    tbl_invoice_buy.row.add([ product_code, product_name, 1, product_price ]).draw();
    $("#total-payment").html(formatRupiah(product_price));
    $('#modal-invoice-order').modal('show');
});

$(".view-product").on("click", ".addToCart", function() {
    $("#loading").modal("show");
    var product_code = $(this).attr("data-code");
    var product_name = $(this).attr("data-name");
    var desc = $(this).attr("data-desc");
    var product_price = $(this).attr("data-price");
    var total_price = product_price * 1;
    var item = new Item (product_code, product_name, desc, product_price, 1, total_price);
    $.ajax({
        url: "addToCart",
        type: "post",
        dataType: "json",
        data: { item: item },
        success: function(response) {
            $("#loading").modal("hide");
            if (response.status = 'success') {
                displayHeaderCart();
                toastr.success('Item has been added to cart');
            }
        },
        error: function(response) {
            console.log(response);
        },
    });
});

$("#tbl-cart-list").on("click", ".delete-item", function() {
    var cc_delete = tbl_cart_list.row($(this).closest('tr')).data()[0];
    $.ajax({
        url: "removeFromCart",
        type: "post",
        dataType: "json",
        data: {
            id: cc_delete
        },
        success: function(response) {
            if (response.status == 'success') {
                var filteredData = tbl_cart_list.rows().indexes()
                    .filter(function(value, index) {
                        return tbl_cart_list.row(value).data()[0] == cc_delete;
                    });
                tbl_cart_list.rows(filteredData).remove().draw();
                toastr.success('Item has been deleted from cart');
            }
        },
        error: function(response) {
            console.log(response);
            alert_info('System error. Please contact your administrator');
        },
    });
});

$("#tbl-cart-list").on("change", ".change-qty", function() {
    var cc_delete = tbl_cart_list.row($(this).closest('tr')).data()[0];
    var quantity = $(this).val();
    $.ajax({
        url: "updateCart",
        type: "post",
        dataType: "json",
        data: {
            id: cc_delete,
            quantity: quantity
        }
    });
});

function viewAllCart () {
    $.ajax({
        url: "getListCart",
        success: function(response) {
            cart = [];
            var data = response.object;
            var subTotal = 0;
            var totalPayment = 0;
            tbl_invoice_buy.clear().draw();
            data.forEach(item => {
                tbl_invoice_buy.row 
                .add([ item.product_code, item.product_name, item.quantity, item.total_price ])
                .draw(false);
                subTotal = subTotal + Number(item.total_price);
                totalPayment = totalPayment + Number(item.total_price);
                var item = new Item(item.product_code, item.product_name, item.product_description,
                    item.product_price, item.quantity, item.total_price);
                cart.push(item);
            });
            $("#subtotal-payment").html(formatRupiah(subTotal.toString()));
            $("#total-payment").html(formatRupiah(totalPayment.toString()));
            $('#modal-invoice-order').modal('show');
        },
        error: function(response) {
            console.log(response);
            alert_info('System error. Please contact your administrator');
        },
    });
}

function orderProduct () {
    $('#loading').modal('show');
    $.ajax({
        url: "orderProduct",
        type: "post",
        dataType: "json",
        data: { cart: cart },
        success: function(response) {
            $('#loading').modal('hide');
            $('#modal-invoice-order').modal('hide');
            alert_info(response.message, function() {
                window.location.reload();
            });
        },
        error: function(response) {
            $('#loading').modal('hide');
            alert_info('System error. Please contact your administrator');
        },
    });
}