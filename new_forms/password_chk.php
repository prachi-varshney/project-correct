<?php

include 'db_connection.php';

$id = $_POST['id'];
$password = $_POST['password'];
//echo $password;

$sql = "SELECT password FROM employees WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$hashed_password = $row['password'];
// echo $hashed_password;
if(password_verify($password, $hashed_password)) {
    echo "Password is valid";
}
else {
    echo "Invalid Password";
}

?>
