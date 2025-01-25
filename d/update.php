<?php
   include "database.php";
 //  print_r($_POST); die;
    $up_id = $_POST['upid'];
    $name = $_POST['name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];

    // print_r($phone); die;
$sql="UPDATE user_master SET name = '{$name}', email = '{$email}', phone = '{$phone}' WHERE id = {$up_id}";  
        
    if($result = mysqli_query($conn, $sql)){
      
      echo json_encode($result);
    }  
    
     ?>
