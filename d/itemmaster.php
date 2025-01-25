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
  <title>Item Master</title>
  <?php include("head.php")
  ?>
  <style>
    #pagination {
      text-align: center;
      padding: 2px;
    }

    #pagination a {
      outline-color: #2980b9;
      background: #fff;
      color: #2980b9;
      text-decoration: none;
      display: inline-block;
      padding: 5px 10px;
      margin-right: 5px;
      border-radius: 3px;
    }

    #pagination a.active {
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
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Items</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Add Item</button>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="mb-4 mt-1 p-5 shadow-sm bg-white rounded">

              <form class="row g-3">
                <div class="col-md-4">
                  <label for="inputName" class="form-label">Item Name</label>
                  <input type="text" name="name1" class="form-control form-control-sm" id="Name" required>
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
                    <?php foreach ([3, 5, 10, 15, 20] as $limit) : ?>
                      <option value="<?= $limit; ?>"><?= $limit; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <table class="w-100">
                <tr>
                  <td id="tabledata"> </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class=" mb-4 mt-1 p-5 shadow-sm bg-white rounded">
              <form class="row g-3" id="formup">
                <div class="col-md-4">
                  <label for="inputName" class="form-label">Item Name<span class="star">*<?php echo $userErr; ?></span></label>
                  <input type="text" class="form-control form-control-sm" id="inputName" name="name" required>
                </div>
                <div class="col-md-4">
                  <label for="inputDescri" class="form-label">Item Description<span class="star">*<?php echo $emailErr; ?></span></label>
                  <input type="email" class="form-control form-control-sm" id="inputdesc" name="description" required>
                </div>
                <div class="col-md-4">
                  <label for="inputPrice" class="form-label">Item Price<span class="star">*</span></label>
                  <input type="tel" class="form-control form-control-sm" id="inputPrice" name="price" pattern="[789][0-9]{9}" required>
                </div>
                <div class="col-md-4">
                  <label for="formFile" class="form-label">Upload File</label>
                  <input class="form-control form-control-sm" name="fileupload" type="file" id="formFile">
                  <div id="postview"><img id="image" style=" width: 50%;" src="" /></div>
                </div>
                <div class="col-md-4" style="padding-left: 10%; margin-top:48px;">
                  <button type="button" class="btn btn-primary btn-sm" id="save" name="save">Save</button>
                  <button class="btn btn-primary btn-sm" id="update" style="display:none;" name="update" type="button">Update</button>
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
    function tabshow() {
      $('#profile-tab').tab('show');
    }
    $(document).ready(function() {
      loadTable();
    });

    // SHOW TABLE FUNCTION
    function loadTable(page) {
      var limit = $("#setlimit").val();
      var name = $('#Name').val();
      var column = $("input[name='sort_column']").val();
      var order = $("input[name='sort_type']").val();
      var icon = $("input[name='sort_icon']").val();
      var load = ("loadid", true);
      $.ajax({
        url: "oneitemfile.php",
        type: "POST",
        data: {
          'column_name': column,
          'order': order,
          'page_no': page,
          'limit': limit,
          'name': name,
          'icon': icon,
          'loadid': load

        },
        success: function(data) {
          $('#tabledata').html(data);
        }
      });
    }

    // Pagination Code
    $(document).on("click", "#pagination a", function(e) {
      e.preventDefault();
      var page_id = $(this).attr("id");

      loadTable(page_id);
    });

    //  INSERT NEW RECORDS   //
    $('#save').on('click', function() {
      var form = document.getElementById('formup');
      var formData = new FormData(form);
      // console.log(formData);
      formData.append("save_student", true);
      $.ajax({
        url: "oneitemfile.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          console.log(data);
          if (data == 1) {
            $.alert({
              title: 'Congrats!',
              content: 'Data added successfully!',
            });

            $("#formup").trigger("reset");
            loadTable();
          } else {
            $.alert({
              title: 'Alert!',
              content: 'Something went wrong!',
            });
          }
        }
      });
    });

    // DELETE DATA 
    $(document).on("click", ".delete-btn", function() {
      if (confirm("Do you really want to delete?")) {
        var numid = $(this).data("id");
        var element = this;
        $.ajax({
          url: "oneitemfile.php",
          type: "POST",
          data: {
            deleteid: numid
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


    // RETURN DATA 
    $(document).on("click", ".edit-btn", function() {
      var edit = $(this).data("eid");
      $("#profile-tab").text($("#profile-tab").text().replace("Add Item", "Edit Item"));
      $.ajax({
        url: "oneitemfile.php",
        type: "POST",
        dataType: 'json',
        data: {
          id: edit
        },
        success: function(data) {
          console.log(data);
          // autofill all field of contact form 
          $('#inputName').val(data.itemname);
          $('#inputdesc').val(data.itemdescription);
          $('#inputPrice').val(data.price);
          $('#image').attr('src', data.path);
          $("#image").show();
          tabshow();

          $("#update").show();
          // set custom attribute 
          $('#update').attr("data-id", edit);
          $("#save").hide();
        }
      });
    });


    // UPDATE TABLE 
    $('#update').on('click', function() {
      var uid = $(this).data("id");
      $("#profile-tab").text($("#profile-tab").text().replace("Edit Item", "Add Item"));
      var form = document.getElementById('formup');
      var formData = new FormData(form);
      formData.append("upid", uid);

      $.ajax({
        url: "oneitemfile.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          // console.log(data);
          $("#image").hide();
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


    // FUNCTION OF SORTING
    function sorting(fld) {
      var order = $(fld).data('order');
      var column = $(fld).attr("id");
      var icon = $(fld).children('span').html();
      if (order == "asc") {
        $(fld).attr("data-order", "desc");
        $("input[name='sort_type']").val(order);
        $("input[name='sort_column']").val(column);
        $("input[name='sort_icon']").val('<i class="fa-solid fa-arrow-up fa-2xs myclass"></i>')
      } else {
        $(fld).attr("data-order", "asc")
        $("input[name='sort_type']").val(order);
        $("input[name='sort_column']").val(column);
        $("input[name='sort_icon']").val('<i class="fa-solid fa-arrow-down fa-2xs myclass"></i>')
      }

      loadTable();
    }
  </script>