<?php
   include "database.php";
 //  print_r($_POST); die;
    $up_id = $_POST['upid'];
    $name = $_POST['name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // print_r($phone); die;
$sql="UPDATE client_master SET name = '{$name}', email = '{$email}', phone = '{$phone}',
address = '{$address}', state = '{$state}', city = '{$city}' WHERE id = {$up_id}";  
        
    if($result = mysqli_query($conn, $sql)){
      
      echo json_encode($result);
    }  
    
     ?>