$("#togglePassword").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  if ($('#inp-password').attr("type") == "password") {
    $('#inp-password').attr("type", "text");
  } else {
    $('#inp-password').attr("type", "password");
  }
});

  getListUser();
  function getListUser() {
    $.ajax({
      type: "GET",
      url: "getListUser",
      success: function (response) {
        var rows = response.object;
        var tblListUser = $('#tbl-list-user').DataTable();
        tblListUser.clear();
        for (var index = 0; index < rows.length; index++) {
            var no = (index+1);
            tblListUser.row.add([
              no,
              rows[index].username,
              rows[index].email,
              rows[index].join_date,
              `<label class="switch"><input id="toggle-status-`+no+`" data-on="ACTIVE" data-off="INACTIVE" class="look" onchange="onChangeStatus(`+no+`, `+rows[index].id+`)" type="checkbox" `+(rows[index].status === "ACTIVE" ? "checked" : "")+` data-toggle="toggle"><label for="toggle-status-`+no+`"></label></label>`,
              `<button type="button" class="btn btn-primary" onclick="openModalEditUser(`+rows[index].id+`, '`+rows[index].username+`', '`+rows[index].email+`'`+`)">Edit</button> &nbsp;` +
              `<button type="button" class="btn btn-danger" onclick="openModalDeleteUser(`+rows[index].id+`)">Delete</button>`
            ]).draw(true);
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

  function onChangeStatus(idToggle, id) {
    debugger;
    var message; var status;
    if ( $('#toggle-status-'+idToggle).is(":checked") ) {
         $('#toggle-status-'+idToggle).prop("checked", false);
         message = 'Are you sure want to ACTIVE this user ? ';
         status = 'ACTIVE';
    } else {
         $('#toggle-status-'+idToggle).prop("checked", true);
         message = 'Are you sure want to INACTIVE this user ? ';
         status = 'INACTIVE';
    }
    alert_confirmation(message, function() { 
        updateStatusUser(id, status) 
    });
  }
  
  function addUser() {
    $("#loading").modal("show");
    var email = $('#inp-email').val();
    var role = $('#slc-role').val();
    $.ajax({
      type: "POST",
      url: "addUser",
      data: { email : email, role : role },
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

  function updateUser() {
    $("#loading").modal("show");
    var email = $('#inp-edit-email').val();
    var id = $('#idUser').val();
    $.ajax({
      type: "POST",
      url: "updateUser",
      data: { id : id, email : email },
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

  function updateStatusUser(id, status) {
    $("#loading").modal("show");
    $.ajax({
      type: "POST",
      url: "updateStatusUser",
      data: { id : id, status : status },
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

  function deleteUser(id) {
    $("#loading").modal("show");
    $.ajax({
      type: "POST",
      url: "deleteUser",
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

  function openModalEditUser(id, username, email){
    $('#idUser').val(id)
    $('#inp-edit-username').val(username)
    $('#inp-edit-email').val(email)
    $('#modal-edit-user').modal('show')
  }

  function openModalDeleteUser(id){
    alert_confirmation( 'Are you sure want to delete user item ? ' , function() { 
        deleteUser(id)
    });
  }