<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<?php $userErr = $emailErr = $passwordErr = ""; ?>

<!doctype html>
<html lang="en">

<head>
    <title>Client Master</title>
    <?php include("head.php")  ?>
    <style>
        #pagination{
  text-align: center;
  padding: 2px;
}
#pagination a{
    outline-color: #2980b9;
  background: #fff;
  color: #2980b9;
  text-decoration: none;
  display: inline-block;
  padding:5px 10px;
  margin-right: 5px;
  border-radius: 3px;
}
#pagination a.active{
  background: #2980b9;
  color: #fff;
}
    </style>
</head>

<body>
<div class="wrapper d-flex align-items-stretch">
<?php include("sidebar.php") 
?>
    <!-- Page Content  -->
    <div id="content" class="p-1 p-md-3">
        <?php include("nav.php") ?>
      <div id="main-content" class="shadow-sm p-3 mb-5 bg-white rounded">

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Clients</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Add Client</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent" >
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div  class="mb-4 mt-1 p-4 shadow-sm bg-white rounded" >
            
                <form class="row g-3">
                    <div class="col-md-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" name="name1" class="form-control form-control-sm" id="Name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="Email4" required>
                    </div>
                    <div class="col-md-3">
                        <label for="inputPhone" class="form-label">Phone no.</label>
                        <input type="tel" class="form-control form-control-sm" id="Phone" required>
                    </div>
                    <div class="col-md-2" style="margin-left:45px; margin-top:45px;">
                        <button type="button" class="btn btn-primary btn-sm" id="search" onclick="loadTable()">
                        <i class="fa-solid fa-magnifying-glass"></i>&nbsp; Search
                        </button>
                    </div>
                    <input type="hidden" name="sort_type">
                    <input type="hidden" name="sort_column">
                    <input type="hidden" name="sort_icon">
                </form>
            </div>
            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <div class="row mb-1">
                <div class="col-md-2"> no.of records</div>
        <div class="col-md-2">
        <select style="width: 60px; height:25px;" class="form-select form-select-sm" aria-label="form-select-sm example" id="setlimit" onchange="loadTable()">
              <!-- <option selected>select</option> -->
              <?php foreach([3,5,10,15,20] as $limit) : ?>
                <option value = "<?= $limit; ?>"><?= $limit; ?></option>
                <?php endforeach; ?>
                  </select> </div>
                </div>
        
                <table class="w-100">
                    <tr>
                        <td id="tabledata">  </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class=" mt-1 p-4 shadow-sm bg-white rounded">
                <form class="row g-3" id="formup">
                    <div class="col-md-4">
                        <label for="inputName" class="form-label">Name<span class="star">*<?php echo $userErr;?></span></label>
                        <input type="text" class="form-control form-control-sm" id="inputName"  name="name"  required>
                    </div>
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Email<span class="star">*<?php echo $emailErr;?></span></label>
                        <input type="email" class="form-control form-control-sm" id="inputEmail4" name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label for="inputPhone" class="form-label">Phone no.<span class="star">*</span></label>
                        <input type="tel" class="form-control form-control-sm" id="inputPhone" name="phone" pattern="[789][0-9]{9}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="inputaddress" class="form-label">Address<span class="star">*<?php echo $passwordErr;?></span></label>
                        <input type="text" class="form-control form-control-sm" id="inputaddress" name="address" required>
                    </div>
                    <div class="col-md-4">
                                    <label for="validationDefault04" class="form-label">State</label>
                                    <select class="form-select form-control-sm" name="select" id="validationDefault04" required>
                                        <option selected disabled value="">Select state</option>
                    <?php
                  require_once "database.php";
                  $result = mysqli_query($conn, "SELECT * FROM ms_state_master");
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                <option value="<?php echo $row['state_id']; ?>"><?php echo $row["state_name"]; ?></option>
                  <?php
                  }
                  ?>
                      </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationDefault03" class="form-label">City</label>
                                    <select class="form-select form-control-sm" name="select1" id="validationDefault03" required>
                                        <option selected disabled value="">Select City</option>
                                    </select>
                                </div>
                    <div class="col-md-4" style="padding-left: 90%; margin-top:30px;">
                        <button type="button" class="btn btn-primary btn-sm" id="save">Save</button>
                        <button class="btn btn-primary btn-sm" id="update" style="display:none;"  name="update" type="button">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
      </div>
		</div>

    <?php include("foot.php") ?>

    <script>
           function tabshow(){
      $('#profile-tab').tab('show');
               }

           $(document).ready(function() {
                 loadTable();
                 });



        //  CITIES OPTIONS ACC. TO STATE 
     $('#validationDefault04').on('change', function() {
        var state_id = this.value;
        $.ajax({
          url: "district-by-state.php",
          type: "POST",
          data: {
            state: state_id,
          },
          cache: false,
          success: function(result) {
            $("#validationDefault03").html(result);
          // console.log(result);
          }
        });
      });

       // INSERT NEW RECORDS
       $('#save').on('click', function() {
         var name = $('#inputName').val();
         var email = $('#inputEmail4').val();
         var phone = $('#inputPhone').val();
         var address = $('#inputaddress').val();
          var state = $('#validationDefault04').val();
        var city = $('#validationDefault03').val();
         var emailErr = "";
         if(name != "" && email != "" && phone != "" && address != "" && state != "" && city != ""){    
               $.ajax({
            url: "insertdataclient.php",
            type: "POST",
            data:  {
                name:name,
                email: email,
                phone: phone,
                address: address,
                state: state,
                city: city
            },
            success: function(data) {
                console.log(data);
             if(data==1){
                $.alert({
                  title: 'Congrats!',
                  content: 'Data added successfully!',
                });
                $("#formup").trigger("reset");
                loadTable();
            }
        else{
            $.alert({
                  title: 'Alert!',
                  content: 'email already exist! Please try with another email',
                });
        }
    }
         }); } 
         else {
            $.alert({
                  title: 'OOps!',
                  content: 'Please fill All fields!',
                });
         }
            });

            // SHOW TABLE FUNCTION
            function loadTable(page) {
        var arrow = "";
        var limit = $("#setlimit").val();
        var name = $('#Name').val();
        var email = $('#Email4').val();
        var phone = $('#Phone').val();

        var column = $("input[name='sort_column']").val();
        var order = $("input[name='sort_type']").val();
        var icon  = $("input[name='sort_icon']").val();
       $.ajax({
        url: "search-sort-pagi.php",
        type: "POST",
        data: {
           'column_name': column,
            'order' : order,
            'page_no' :page,
            'limit':limit,
            'name': name,
            'email':email,
            'phone' : phone,
            'icon':icon
          
         },
        success: function(data) {
       $('#tabledata').html(data);
        }
      });
    }
        // Pagination Code
    $(document).on("click","#pagination a",function(e) {
      e.preventDefault();
      var page_id = $(this).attr("id");

      loadTable(page_id);
    });

    function sorting(fld){
      var order  = $(fld).data('order');
      var column = $(fld).attr("id");
      var icon = $(fld).children('span').html();
    //    console.log(icon);
    //    console.log(order);
    //    console.log(column);
       if(order == "asc"){
        $(fld).attr("data-order","desc");
        $("input[name='sort_type']").val(order);
        $("input[name='sort_column']").val(column);
        $("input[name='sort_icon']").val('<i class="fa-solid fa-arrow-up fa-2xs myclass"></i>')
       }
       else{
        $(fld).attr("data-order","asc")
        $("input[name='sort_type']").val(order);
        $("input[name='sort_column']").val(column);
        $("input[name='sort_icon']").val('<i class="fa-solid fa-arrow-down fa-2xs myclass"></i>')
       }

       loadTable();
                 }

                 // RETURN DATA 
      $(document).on("click", ".edit-btn", function() {
        var edit = $(this).data("eid");
        $("#profile-tab").text($("#profile-tab").text().replace("Add Client", "Edit Client"));
        $.ajax({
          url: "returnclientdata.php",
          type: "POST",
          dataType: 'json',
          data: {
            id: edit
          },
          success: function(data) {
            console.log(data);
            // autofill all field of contact form 
            $('#inputName').val(data.name);
            $('#inputEmail4').val(data.email);
            $('#inputPhone').val(data.phone);
            $('#inputaddress').val(data.address);
            $('#validationDefault04').val(data.state).trigger('change');
            $('#validationDefault03').val(data.city);
            tabshow();
        
            $("#update").show();
            // set custom attribute 
            $('#update').attr("data-id",edit);
                $("#save").hide();
          }
        });
      });

      $(document).on("click", ".delete-btn", function() {
        if (confirm("Do you really want to delete?")){
          var numid = $(this).data("id");
          var element = this;
          $.ajax({
            url: "clientdelete.php",
            type: "POST",
            data: {
              id: numid
            },
            success: function(data) {
              if (data == 1) {
                $(element).closest("tr").fadeOut();
              } else {
                $.alert({
                  title: 'Alert!',
                  content: 'Cant delete data!',
                });
              }
            }
          });
        }
      });

        // UPDATE TABLE 
        $('#update').on('click',function(){
        var uid = $(this).data("id");
         var name = $('#inputName').val();
         var email = $('#inputEmail4').val();
         var phone = $('#inputPhone').val();
         var address = $('#inputaddress').val();
         var state = $('#validationDefault04').val();
         var city = $('#validationDefault03').val();
         $("#profile-tab").text($("#profile-tab").text().replace("Edit Client", "Add Client"));
        $.ajax({
          url: "clientupdate.php",
          type: "POST",
          data: {
             upid:uid,
             name: name,
               email: email,
               phone: phone,
                address: address,
                state: state,
                city: city
          },
          success: function(data){
           console.log(data);
                  $("#save").show();
                  $("#update").hide();
                  loadTable();
                  $.alert({
                  title: 'Congrats!',
                  content: 'Data updated successfully!',
                });
                $("#formup").trigger("reset");
          }
        });
      });
    </script>