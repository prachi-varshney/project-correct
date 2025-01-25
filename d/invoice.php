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
    <title>Invoice</title>
    <?php include("head.php")  ?>
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

        .star {
            color: red;
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
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Invoice List</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Add Invoice</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="mb-4 mt-1 p-4 shadow-sm bg-white rounded">

                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label for="inputlist" class="form-label">Invoice no.</label>
                                    <input type="text" name="name1" class="form-control form-control-sm" id="inputlist" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Namelist" class="form-label">Client name</label>
                                    <input type="text" name="name1" class="form-control form-control-sm" id="Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Emaillist" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="Email4" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Phonelist" class="form-label">Phone no.</label>
                                    <input type="tel" class="form-control form-control-sm" id="Phone" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="addresslist" class="form-label">Address<span class="star"><?php echo $passwordErr; ?></span></label>
                                    <input type="text" class="form-control form-control-sm" id="addresslist" name="address1" required>
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
                        <div class=" mt-1 p-4 shadow-sm bg-white rounded">
                            <form class="row g-3" id="formup">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Noadd" class="form-label">Invoice no. &nbsp;<span class="star">*<?php echo $userErr; ?></span></label>
                                        <input type="text" class="form-control form-control-sm" id="Noadd" name="no" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="date">Invoice date &nbsp;<span class="star">*<?php echo $userErr; ?></span></label>
                                        <input type="date" class="form-control form-control-sm" id="date" name="invoicedate" value="<?php echo date("Y-m-d"); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="autocomplete" class="form-label">Client name &nbsp;<span class="star">*<?php echo $userErr; ?></span></label>
                                    <input type="text" class="form-control form-control-sm" id="autocomplete" name="autocomplete" required>
                                    <div id="search-result"></div>
                                </div>
                                <div class="col-md-3">
                                    <label for="addEmail4" class="form-label">Email &nbsp;<span class="star">*<?php echo $emailErr; ?></span></label>
                                    <input type="email" class="form-control form-control-sm" id="addEmail4" name="email" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="addPhone" class="form-label">Phone no. &nbsp;<span class="star">*</span></label>
                                    <input type="tel" class="form-control form-control-sm" id="addPhone" name="phone" pattern="[789][0-9]{9}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="addaddress" class="form-label">Address &nbsp;<span class="star">*<?php echo $passwordErr; ?></span></label>
                                    <input type="text" class="form-control form-control-sm" id="addaddress" name="address" required>
                                </div>
                            </form>
                        </div>
                        <div class=" mt-1 p-4 shadow-sm bg-white rounded">
                            <form class="row g-3">
                                <div class="col-md-3">
                                    <label for="itemName" class="form-label">Item name</label>
                                    <input type="text" name="name1" class="form-control form-control-sm ml-1" id="itemName" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputprice" class="form-label">Item Price</label>
                                    <input type="text" name="name1" class="form-control form-control-sm" id="inputprice" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputquantity" class="form-label">Quantity</label>
                                    <input type="email" class="form-control form-control-sm" id="inputquantity" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="tel" class="form-control form-control-sm ml-1" id="total" required>
                                </div>
                                <div class="col-md-1 ">
                                    <label for="action" class="form-label">Action</label>
                                    <center style="margin-top: 6px; margin-left:10px;"> <a role="button" id="cross">
                                            <i class="fa-regular fa-circle-xmark fa-2xl" style="color: #ea2e2e;"></i>
                                        </a></center>
                                </div>
                                <div id="newinput"></div>
                                <div class="row mt-3 ml-1">
                                    <div class="col-md-6"><button type="button" class="btn btn-primary btn-sm" id="add" onclick="addnew()">Add</button></div>
                                    <div class="col-md-6">

                                        <button type="button" class="btn btn-primary btn-sm ml-3" id="save">Save</button>
                                        <button class="btn btn-primary btn-sm" id="update" style="display:none;" name="update" type="button">Update</button>
                                    </div>
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
        function addnew() {
            newRowAdd =
                '<div class="row" id="newrow"> <div class="col-md-3">' +
                '<input id="Name" type="text" class="form-control ml-2 form-control-sm mb-3"></div>' +
                '<div class="col-md-3"> <input type="text" class="form-control form-control-sm mb-3 ml-1"></div>' + '<div class="col-md-3"> <input type="text" class="form-control form-control-sm mb-3"></div>' + '<div class="col-md-2"> <input type="text" class="form-control form-control-sm mb-3"></div>' + '<div class= "col-md-1"><center style="margin-top: 6px;"> <a role="button" id="cross"> <i class = "fa-regular fa-circle-xmark fa-2xl"style= "color: #ea2e2e;"></i></a></center></div></div>';

            $('#newinput').append(newRowAdd);
        };
        $("body").on("click", "#cross", function() {
            $(this).parents("#newrow").remove();
        })

        function tabshow() {
            $('#profile-tab').tab('show');
        }
        $(document).ready(function() {
            loadTable();
        });

        // SHOW TABLE FUNCTION
        function loadTable(page) {
            var limit = $("#setlimit").val();
            var invoiceno = $('#inputlist').val();
            var name = $('#Name').val();
            var email = $('#Email4').val();
            var phone = $('#Phone').val();
            var address = $('#addresslist').val();
            var column = $("input[name='sort_column']").val();
            var order = $("input[name='sort_type']").val();
            var icon = $("input[name='sort_icon']").val();
            var load = ("loadid", true);
            $.ajax({
                url: "dbinvoice.php",
                type: "POST",
                data: {
                    'column_name': column,
                    'order': order,
                    'page_no': page,
                    'limit': limit,
                    'name': name,
                    'invoiceno': invoiceno,
                    'email': email,
                    'phone': phone,
                    'address': address,
                    'icon': icon,
                    'loadid': load

                },
                success: function(data) {
                    //   console.log(data);
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
        // $('#save').on('click', function() {
        //     var form = document.getElementById('formup');
        //     var formData = new FormData(form);
        //     formData.append("save_student", true);
        //     $.ajax({
        //         url: "oneitemfile.php",
        //         type: "POST",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(data) {
        //             console.log(data);
        //             if (data == 1) {
        //                 $.alert({
        //                     title: 'Congrats!',
        //                     content: 'Data added successfully!',
        //                 });

        //                 $("#formup").trigger("reset");
        //                 loadTable();
        //             } else {
        //                 $.alert({
        //                     title: 'Alert!',
        //                     content: 'Something went wrong!',
        //                 });
        //             }
        //         }
        //     });
        // });

        // DELETE DATA 
        $(document).on("click", ".delete-btn", function() {
            if (confirm("Do you really want to delete?")) {
                var numid = $(this).data("id");
                var element = this;
                $.ajax({
                    url: "dbinvoice.php",
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
            $("#profile-tab").text($("#profile-tab").text().replace("Add Invoice", "Edit Invoice"));
            $.ajax({
                url: "dbinvoice.php",
                type: "POST",
                dataType: 'json',
                data: {
                    id: edit
                },
                success: function(data) {
                    console.log(data);
                    // autofill all field of contact form 
                    $('#Noadd').val(data.invoiceno);
                    $('#date').val(data.invoicedate);
                    $('#addName').val(data.clientname);
                    $('#addEmail4').val(data.email);
                    $('#addPhone').val(data.phone);
                    $('#addaddress').val(data.address);
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
            $("#profile-tab").text($("#profile-tab").text().replace("Edit Invoice", "Add Invoice"));
            var invoiceno = $('#Noadd').val();
            var invoicedate = $('#date').val();
            var clientname = $('#addName').val();
            var email = $('#addEmail4').val();
            var phone = $('#addPhone').val();
            var address = $('#addaddress').val();

            $.ajax({
                url: "dbinvoice.php",
                type: "POST",
                data: {
                    'invoiceno': invoiceno,
                    'invoicedate': invoicedate,
                    'clientname': clientname,
                    'email': email,
                    'phone': phone,
                    'address': address,
                    'upid': uid
                },
                success: function(data) {
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

        // autofill  process

        $("#autocomplete").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "dbinvoice.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                        //  console.log(data);

                    }
                });
            },
            select: function(event, ui) {
                //  console.log(ui.item.eid);
                var id = (ui.item.eid)
                // console.log(id);
                $.ajax({
                    url: "dbinvoice.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        invoiceid: id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#addEmail4').val(data.email);
                        $('#addPhone').val(data.phone);
                        $('#addaddress').val(data.fulladdress);
                    }
                })
            }
        });

        // AUTO INCREMENT NO. IN INVOICE NO FIELD
        $('#profile-tab').on('click', function() {
            var autoincrement = ("autoincrementvalue", true);
            $.ajax({
                url: "dbinvoice.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    autoincrementvalue: autoincrement
                },
                success: function(data) {
                    console.log(data);
                    $('#Noadd').val(data.id);
                }
            })
        });

        $('#itemName').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'dbinvoice.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        searchitem: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                var id = (ui.item.eid);
                $.ajax({
                    url: 'dbinvoice.php',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        itemid: id
                    },
                    success: function(data) {
                        //  console.log(data);
                        $('#inputprice').val(data.price);
                    }
                });
            }
        });

        // $('#Name').autocomplete({
        //     source: function(request, response) {
        //         $.ajax({
        //             url: 'dbinvoice.php',
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 searchitemra: request.term
        //             },
        //             success: function(data) {
        //                 response(data);
        //             }
        //         });
        //     }
        // });

        $('#inputquantity').on('click', function() {
            var price = $('#inputprice').val();
            var quantity = $('#inputquantity').val();
            var total = price * quantity;
            $('#total').val(total);
        })
        // function amount() {
        //     var price = $('#inputprice').val();
        //     var quantity = $('#inputquantity').val();

        //     var total = price * quantity;
        //     $('#total').val(total);
        // };
        // $('#inputquantity').change(function() {
        //     var price = $('#inputprice').val();
        //     var quantity = $('#inputquantity').val();

        //     var total = price * quantity;
        //     $('#total').val(total);
        // })
    </script>