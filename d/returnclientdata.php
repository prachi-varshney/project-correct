<?php
include ("database.php");

$edit_id = $_POST['id'];

$sql = "SELECT * FROM client_master where id = {$edit_id}";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $row = $result->fetch_assoc();
    echo json_encode($row); 
} 
?>

