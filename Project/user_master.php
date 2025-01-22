<div class="form-group">
    <label for="name">Name: <i class="fa-regular fa-arrow-down-arrow-up"></i></label>
    <input type="text" class="form-control" id="name" name="name"
        placeholder="Enter full name" required>
</div><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body {
            background-color: #f0f0f0;
        }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 0.2rem 1rem;
    font-size: 12px;
        }
        .navbar-brand {
            font-size: 14px;
            font-weight: bold;
        }

        .navbar-brand img {
    width: 15px;
    height: 15px;
}
        .nav-pills {
            background-color: #f0f0f0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .nav-link.active {
            background-color: #333;
            color: #fff;
        }
        .tab-content {
            padding: 0px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tab-pane {
            padding: 20px;
        }
        .d-flex {
            height: 100vh;
        }
        .nav-pills {
            height: 100%;
        }
        .tab-content {
            height: 100%;
            overflow-y: auto;
        }
        .d-flex > div {
            height: 100%;
        }
        .nav-pills {
            flex: 1;
        }
        .tab-content {
            flex: 3;
        }


        .logo-image {
    width: 20px;
    height: 20px;
    object-fit: cover;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png">
                <span style="color: #fff;">Company Name</span>
            </a>
        </div>
    </nav>



    <div class="d-flex align-items-start" style="margin-top: 0px; height: 100vh;">
    <div class="col-2" style="height: 100%; overflow-y: auto;">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab" aria-controls="v-pills-dashboard" aria-selected="true">Dashboard</button>
            <button class="nav-link" id="v-pills-User -Master-tab" data-bs-toggle="pill" data-bs-target="#v-pills-User -Master" type="button" role="tab" aria-controls="v-pills-User -Master" aria-selected="false">User  Master</button>
            <button class="nav-link" id="v-pills-Client-Master-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Client-Master" type="button" role="tab" aria-controls="v-pills-Client-Master" aria-selected="false">Client Master</button>
            <button class="nav-link" id="v-pills-Invoice-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Invoice" type="button" role="tab" aria-controls="v-pills-Invoice" aria-selected="false">Invoice</button>
        </div>
    </div>
    <div class="col-10" style="height: 100%; overflow-y: auto;">
        <div class="tab-content" id="v-pills-tabContent">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 20px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-users-tab" data-bs-toggle="tab" data-bs-target="#all-users" type="button" role="tab" aria-controls="users" aria-selected="true">All Users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="add-users-tab" data-bs-toggle="tab" data-bs-target="#add-users" type="button" role="tab" aria-controls="add-users" aria-selected="false">Add users</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="all-user" role="tabpanel" aria-labelledby="all-user-tab">...</div>
                <div class="tab-pane fade" id="add-user" role="tabpanel" aria-labelledby="add-user-tab">...</div>
            </div>


>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#add-user-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'add_user.php',
            data: formData,
            success: function(response) {
                $('#add-user').html(response);
            }
        });
    });
});

</script>
</body>
</html> 