<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <title>Login Form</title>
</head>
<body>
    <div id="form">
        <h1>LOGIN FORM</h1>
        <div class="imgcontainer">
            <img src="images/memoji.avif"
                alt="Login Image" class="img-fluid mx-auto" style="width: 500px;">
        </div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
        </form>
    </div>

    
    <?php
require_once 'database.php';

$db = new Database(); // Create an instance of the Database class


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "select * from project where email = '$email' and password = '$password'";
    $result = $db->getData($query); // Use the getData() method to execute the query

    if ($result['success']) {
        if (count($result['data']) == 1) {
            header(
                "location: action_page.php");
        } else {
            echo '<script>
                window.location.href="view.php";
                alert("login failed. invalid email or password!!!")
            </script>';
        }
    }
     else {
        echo '<script>
            window.location.href="view.php";
            alert("login failed. invalid email or password!!!")
        </script>';
    }
}
?>
</body>
</html>
